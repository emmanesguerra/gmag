<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\MembersPairing;
use App\Models\TransactionBonus;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    //
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
            
            $pairs = $member->pairings()
                            ->whereDate('created_at', Carbon::now())
                            ->where(function ($query) {
                                $query->where('type', 'TP')
                                      ->orWhereNull('type');
                            })
                            ->orderBy('product_value', 'desc')
                            ->get();

            $ctr = 0;
            foreach($pairs as $pair)
            {
                $type = ($ctr < 3) ? 'MP': 'FP';
                $pair->type = $type;
                $pair->save();

                if($type == 'MP') {
                    $acquiredAmt = $pair->product->price / 2;
                } else {
                    $acquiredAmt = $pair->product->flush_bonus;
                }

                TransactionBonus::create([
                    'member_id' => $member->id,
                    'class_id' => $pair->id,
                    'class_type' => 'App\Models\MemberPairing',
                    'type' => $type,
                    'acquired_amt' => $acquiredAmt
                ]);

                $ctr++;
            }
            
            DB::commit();
            return;
        } catch (Exception $ex) {
            DB::rollback();
        }
    }
}
