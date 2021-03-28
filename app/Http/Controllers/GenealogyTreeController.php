<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\MembersPlacement;

class GenealogyTreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $topId = (isset($request->top)) ? $request->top: Auth::id();
        $member = Member::find($topId);
        $memberLvl = $member->placement->lvl;
        $memberLft = $member->placement->lft;
        $memberRgt = $member->placement->rgt;
        
        $members = MembersPlacement::select('member_id', 'product_id', 'position', 'placement_id')
            ->with(['member' => function($query) {
                $query->select('id', 'username');
            }])
            ->whereBetween('lft', [$memberLft, $memberRgt])
            ->where('lvl', '<', ($memberLvl + 4))
            ->orderBy('lvl', 'asc')
            ->get();
            
        $sortedMembers = $this->sortMemberViaChildParent($members->toArray(), $topId);
        
        return view('gtree', ['member' => $sortedMembers]);
    }
    
    private function sortMemberViaChildParent($members, $topId)
    {
        $tempPosition = [
            0 => ['target' => 0],
            1 => ['target' => 0,
                'position' => 'L'],
            2 => ['target' => 0,
                'position' => 'R'],
            3 => ['target' => 1,
                'position' => 'L'],
            4 => ['target' => 1,
                'position' => 'R'],
            5 => ['target' => 2,
                'position' => 'L'],
            6 => ['target' => 2,
                'position' => 'R'],
            7 => ['target' => 3,
                'position' => 'L'],
            8 => ['target' => 3,
                'position' => 'R'],
            9 => ['target' => 4,
                'position' => 'L'],
            10 => ['target' => 4,
                'position' => 'R'],
            11 => ['target' => 5,
                'position' => 'L'],
            12 => ['target' => 5,
                'position' => 'R'],
            13 => ['target' => 6,
                'position' => 'L'],
            14 => ['target' => 6,
                'position' => 'R'],
        ];
        
        $data = [];
        foreach($tempPosition as $key => $targetPosition) {
            if($key == 0) {
                $data[$key] = [
                    'id' => $members[$key]['member_id'],
                    'username' => $members[$key]['member']['username'],
                    'product_id' => $members[$key]['product_id']
                ];
            } else {
                $memberKey = $this->searcharray($data[$targetPosition['target']]['id'], $targetPosition['position'], $members);
                if($memberKey) {
                    $data[$key] = [
                        'id' => $members[$memberKey]['member_id'],
                        'username' => $members[$memberKey]['member']['username'],
                        'product_id' => $members[$memberKey]['product_id']
                    ];
                } else {
                    $data[$key] = [
                        'id' => 0,
                        'username' => 'Available',
                        'product_id' => 0,
                        'available' => false,
                        'position' => $targetPosition['position']
                    ];
                    if ($data[$targetPosition['target']]['id'] > 0) {
                        $data[$key]['username'] = 'Sign Up';
                        $data[$key]['target_id'] = $data[$targetPosition['target']]['id'];
                    }
                }
            }
        }
        
        return $data;
    }
    
    private function searcharray($placementId, $position, $members) {
        foreach ($members as $k => $member) {
            if ($member['placement_id'] == $placementId && $member['position'] == $position) {
                return $k;
            }
        }
        return null;
    }
    
    public function member_data(Request $request)
    {
        $placement = MembersPlacement::select('member_id', 'product_id')->where(['placement_id' => $request->id, 'position' => $request->position])->first();
        
        if($placement) {
            switch ($placement->product_id) {
                case 4:
                    $image = asset('images/gold.png');
                    break;
                case 3:
                    $image = asset('images/silver.png');
                    break;
                case 2:
                    $image = asset('images/bronze.png');
                    break;
                case 1:
                    $image = asset('images/starter.png');
                    break;
                default;
                    $image = asset('images/open.png');
                    break;
            }

            return response()->json([
                'image' => $image,
                'target_id' => $placement->member_id,
                'username' => $placement->member->username,
                'success' => true
            ], 200);
        }

        return response()->json([], 400);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function pairing(Request $request)
    {
        $topId = (isset($request->top)) ? $request->top: Auth::id();
        $member = Member::find($topId);
        
        $childrenIds = $member->children()->pluck('member_id');
        
        
        $show = (isset($request->show)) ? $request->show: 10;
        
        $pairs = \App\Models\MembersPairing::whereIn('member_id', $childrenIds)
                ->orderBy('id', 'desc')
                ->paginate($show);
        
        return view('gtree-pairing-list', ['pairs' => $pairs, 'member' => $member]);
    }
}
