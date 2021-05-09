<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Member;
use App\Models\MembersPlacement;
use App\Library\DataTables;

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
            ->with(['product' => function($query) {
                $query->select('id', 'display_icon');
            }])
            ->whereBetween('lft', [$memberLft, $memberRgt])
            ->where('lvl', '<', ($memberLvl + 4))
            ->orderBy('lvl', 'asc')
            ->get();
            
        $sortedMembers = $this->sortMemberViaChildParent($members->toArray(), $topId);
        $products = Product::select('code', 'price', 'display_icon')->where('type', 'ACT')->get();
        
        return view('gtree', ['member' => $sortedMembers, 'products' => $products]);
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
                    'product_id' => $members[$key]['product_id'],
                    'display_icon' => $members[$key]['product']['display_icon']
                ];
            } else {
                $memberKey = $this->searcharray($data[$targetPosition['target']]['id'], $targetPosition['position'], $members);
                if($memberKey) {
                    $data[$key] = [
                        'id' => $members[$memberKey]['member_id'],
                        'username' => $members[$memberKey]['member']['username'],
                        'product_id' => $members[$memberKey]['product_id'],
                        'display_icon' => $members[$memberKey]['product']['display_icon']
                    ];
                } else {
                    $data[$key] = [
                        'id' => 0,
                        'username' => 'Available',
                        'product_id' => 0,
                        'available' => false,
                        'position' => $targetPosition['position'],
                        'display_icon' => 'open_s.png'
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
        
        $show = (isset($request->show)) ? $request->show: 10;
        
        $pairs = $member->pairings()
                ->orderBy('id', 'desc')
                ->paginate($show);
        
        return view('gtree-pairing-list', ['pairs' => $pairs, 'member' => $member]);
    }
    
    public function pairingdata(Request $request, $id)
    {
        $tablecols = [
            0 => 'a.created_at',
            1 => 'b.username',
            2 => 'c.username',
            3 => 'd.username',
            4 => 'e.name',
            5 => 'a.type'
        ];
        
        $filteredmodel = DB::table('members_pairings as a')
                                ->join('members as b', 'b.id', '=', 'a.member_id')
                                ->join('members as c', 'c.id', '=', 'a.lft_mid')
                                ->join('members as d', 'd.id', '=', 'a.rgt_mid')
                                ->join('products as e', 'e.id', '=', 'a.product_id')
                                ->where('a.member_id', $id)
                                ->select(DB::raw("a.created_at,
                                                b.username as parentname,
                                                c.username as leftname,
                                                d.username as rightname,
                                                e.name,
                                                a.type
                                                ")
                            );
        
        if($request->status != "") {
            if($request->status == 'null') {
                $filteredmodel->whereNull('a.type');
            } else {
                $filteredmodel->where('a.type', $request->status);
            }
        }
        
        if($request->has('start_date') && !empty($request->start_date)) {        
            if($request->has('end_date') && !empty($request->end_date && $request->start_date != $request->end_date)) {
                $filteredmodel->whereBetween('a.created_at', [$request->start_date, $request->end_date . ' 23:59:00']);
            } else {
                $filteredmodel->whereDate('a.created_at', $request->start_date);
            }
        }

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
    
    public function genealogy(Request $request)
    {
        $member = Auth::user();
        
        return view('gtree-genealogy-list', ['member' => $member, 'lvl' => $member->placement->lvl]);
    }
    
    public function genealogydata(Request $request, $id)
    {
        $tablecols = [
            0 => 'a.created_at',
            1 => 'b.username',
            2 => 'b.firstname|b.lastname',
            3 => 'a.lvl',
            4 => 'c.name|c.price',
            5 => 'd.username'
        ];
        
        $placement = MembersPlacement::where('member_id', $id)->first();
        
        if($placement) {
            
            $filteredmodel = DB::table('members_placements as a')
                                    ->join('members as b', 'b.id', '=', 'a.member_id')
                                    ->join('members as d', 'd.id', '=', 'b.sponsor_id')
                                    ->join('products as c', 'c.id', '=', 'a.product_id')
                                    ->whereBetween('a.lft', [$placement->lft, $placement->rgt])
                                    ->where('a.member_id', '!=', $placement->member_id)
                                    ->select(DB::raw("a.created_at,
                                                    b.username,
                                                    b.firstname,
                                                    b.lastname,
                                                    a.lvl,
                                                    c.name,
                                                    c.price,
                                                    d.username as sponsor
                                                    ")
                                );
        
            if($request->has('start_date') && !empty($request->start_date)) {        
                if($request->has('end_date') && !empty($request->end_date && $request->start_date != $request->end_date)) {
                    $filteredmodel->whereBetween('a.created_at', [$request->start_date, $request->end_date . ' 23:59:00']);
                } else {
                    $filteredmodel->whereDate('a.created_at', $request->start_date);
                }
            }

            $modelcnt = $filteredmodel->count();

            $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

            return response(['data'=> $data,
                'draw' => $request->draw,
                'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
                'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
        }
        
        return response(['data'=> [],
            'draw' => $request->draw,
            'recordsTotal' => 0,
            'recordsFiltered' => 0], 200);
    }
    
    public function binary(Request $request)
    {
        return view('gtree-binary-list');
    }
    
    public function binaryleft(Request $request)
    {
        $tablecols = [
            0 => 'members.created_at',
            1 => 'members.username',
            2 => 'products.code|products.price'
        ];
        
        $member = MembersPlacement::where('member_id', Auth::id())->first();
        $childL = MembersPlacement::select('lft', 'rgt')->where(['lft' => ($member->lft + 1), 'position' => 'L'])->first();
        
        if($childL) {
            
            $filteredmodel = DB::table('members_placements')
                                    ->join('members', 'members.id', '=', 'members_placements.member_id')
                                    ->join('products', 'products.id', '=', 'members_placements.product_id')
                                    ->whereBetween('members_placements.lft', [$childL->lft, $childL->rgt])
                                    ->select(DB::raw("members.created_at, 
                                                    members.username, 
                                                    products.code,
                                                    products.price")
                                );
        
            if($request->has('start_date') && !empty($request->start_date)) {        
                if($request->has('end_date') && !empty($request->end_date && $request->start_date != $request->end_date)) {
                    $filteredmodel->whereBetween('members.created_at', [$request->start_date, $request->end_date . ' 23:59:00']);
                } else {
                    $filteredmodel->whereDate('members.created_at', $request->start_date);
                }
            }

            $modelcnt = $filteredmodel->count();

            $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

            return response(['data'=> $data,
                'draw' => $request->draw,
                'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
                'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
        }
        
        return response(['data'=> [],
            'draw' => $request->draw,
            'recordsTotal' => 0,
            'recordsFiltered' => 0], 200);
    }
    
    public function binaryright(Request $request)
    {
        $tablecols = [
            0 => 'members.created_at',
            1 => 'members.username',
            2 => 'products.code|products.price'
        ];
        
        $member = MembersPlacement::where('member_id', Auth::id())->first();
        $childR = MembersPlacement::select('lft', 'rgt')->where(['rgt' => ($member->rgt - 1), 'position' => 'R'])->first();
        
        if($childR) {
        
            $filteredmodel = DB::table('members_placements')
                                    ->join('members', 'members.id', '=', 'members_placements.member_id')
                                    ->join('products', 'products.id', '=', 'members_placements.product_id')
                                    ->whereBetween('members_placements.lft', [$childR->lft, $childR->rgt])
                                    ->select(DB::raw("members.created_at, 
                                                    members.username, 
                                                    products.code,
                                                    products.price")
                                );
        
            if($request->has('start_date') && !empty($request->start_date)) {        
                if($request->has('end_date') && !empty($request->end_date && $request->start_date != $request->end_date)) {
                    $filteredmodel->whereBetween('members.created_at', [$request->start_date, $request->end_date . ' 23:59:00']);
                } else {
                    $filteredmodel->whereDate('members.created_at', $request->start_date);
                }
            }

            $modelcnt = $filteredmodel->count();

            $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

            return response(['data'=> $data,
                'draw' => $request->draw,
                'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
                'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
        }
        
        return response(['data'=> [],
            'draw' => $request->draw,
            'recordsTotal' => 0,
            'recordsFiltered' => 0], 200);
    }
}
