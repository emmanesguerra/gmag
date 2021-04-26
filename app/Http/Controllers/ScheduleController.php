<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Member;
use App\Models\MembersPairing;
use App\Models\TransactionBonus;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    const MAX_PAIR_PER_DAY = 3;
    
    /*
     * THIS IS TEMPORARY, THIS FUNCTION will be move on a CRONJOB
     */
    
    public function checkTodaysPairs()
    {
        $pairIds = MembersPairing::distinct()->select('member_id')
                            ->whereDate('created_at', Carbon::now())
                            ->where(function ($query) {
                                $query->where('type', 'TP')
                                      ->orWhereNull('type');
                            })
                            ->get();
        
        $pairIds->map(function($member) {
            $this->SetMemberPairsType($member->member);
        });
        
        return redirect()->back();
    }
    
    private function SetMemberPairsType(Member $member)
    {
        try
        {
            DB::beginTransaction();
            
            $maxPair = ($member->pair_cycle) ? $member->pair_cycle->max_pair: 0;
            
            $pairs = $member->pairings()
                            ->whereDate('created_at', Carbon::now())
                            ->where(function ($query) {
                                $query->where('type', 'TP')
                                      ->orWhereNull('type');
                            })
                            ->orderBy('product_value', 'desc')
                            ->get();

            $ctr = $member->pair_cycle_ctr % self::MAX_PAIR_PER_DAY;
            foreach($pairs as $pair)
            {
                $type = (($ctr < self::MAX_PAIR_PER_DAY) && ($member->pair_cycle_ctr < $maxPair)) ? 'MP': 'FP';
                
                $pair->type = $type;
                $pair->save();

                if($pair->product->price > $member->placement->product->price) {
                    $price = $member->placement->product->price;
                    $fbonus = $member->placement->product->flush_bonus;
                } else {
                    $price = $pair->product->price;
                    $fbonus = $pair->product->flush_bonus;
                }
                
                if($type == 'MP') {
                    $acquiredAmt = $price / 2; // 50% of total price
                } else {
                    $acquiredAmt = $fbonus;
                }
                
                $trans = TransactionBonus::create([
                    'member_id' => $member->id,
                    'class_id' => $pair->id,
                    'class_type' => 'App\Models\MemberPairing',
                    'type' => $type,
                    'acquired_amt' => $acquiredAmt
                ]);
                
                if($trans) {
                    if($type == 'MP') {
                        $member->pair_cycle_ctr += 1;
                        $member->matching_pairs += $acquiredAmt;
                        $member->total_amt += $acquiredAmt;
                    } else {
                        $member->flush_pts += $acquiredAmt;
                    }
                    $member->save();
                    
                    if(($member->pair_cycle)) {
                        if(empty($member->pair_cycle->starting_pair_id)) {
                            $pairCycle = $member->pair_cycle;
                            $pairCycle->starting_pair_id = $pair->id;
                            $pairCycle->save();
                        }
                    }
                }
                $ctr++;
            }
            
            if(($member->pair_cycle_ctr >= $maxPair) && ($maxPair != 0)) {
                $pairCycle = $member->pair_cycle;
                $pairCycle->end_date = Carbon::now();
                $pairCycle->ending_pair_id = $pair->id;
                $pairCycle->save();
                
                $member->pair_cycle_ctr = 0;
                $member->pair_cycle_id = 0;
                $member->save();
            }
            
            DB::commit();
            return;
        } catch (\Exception $ex) {
            DB::rollback();
            Log::error(__CLASS__ . "::" . __METHOD__ . "  " . $ex->getMessage() . " MEMBERID:" . $member->id);
        }
    }
}
