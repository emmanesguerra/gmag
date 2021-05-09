<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistrationCode;
use App\Models\Product;
use App\Library\Modules\EntryCodesLibrary;
use App\Library\DataTables;
use App\Http\Requests\GenerateEntryCodeRequest;

class RegistrationCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.registrationcodes.index');
    }
    
    public function data(Request $request)
    {
        $tablecols = [
            0 => 'a.created_at',
            1 => 'b.username',
            2 => 'a.pincode1',
            3 => 'a.pincode2',
            4 => 'c.username',
            5 => 'd.name',
            6 => 'd.price',
            7 => 'a.remarks'
        ];
        
        $filteredmodel = DB::table('registration_codes as a')
                                ->leftjoin('members as b', 'b.id', '=', 'a.assigned_to_member_id')
                                ->join('members as c', 'c.id', '=', 'a.created_by')
                                ->join('products as d', 'd.id', '=', 'a.product_id')
                                ->where('is_used', 0)
                                ->select(DB::raw("a.id, 
                                                b.username as assignto, 
                                                a.pincode1,
                                                a.pincode2,
                                                d.name,
                                                c.username as creator,
                                                d.price,
                                                a.remarks,
                                                a.created_at")
                            );

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
    
    public function used()
    {
        return view('admin.registrationcodes.used');
    }
    
    public function useddata(Request $request)
    {
        $tablecols = [
            0 => 'a.created_at',
            1 => 'b.username',
            2 => 'a.pincode1',
            3 => 'a.pincode2',
            4 => 'c.username',
            5 => 'd.name',
            6 => 'd.price',
            7 => 'a.remarks'
        ];
        
        $filteredmodel = DB::table('registration_codes as a')
                                ->leftjoin('members as b', 'b.id', '=', 'a.assigned_to_member_id')
                                ->join('members as c', 'c.id', '=', 'a.created_by')
                                ->join('products as d', 'd.id', '=', 'a.product_id')
                                ->where('is_used', 1)
                                ->select(DB::raw("a.id, 
                                                b.username as assignto, 
                                                a.pincode1,
                                                a.pincode2,
                                                d.name,
                                                c.username as creator,
                                                d.price,
                                                a.remarks,
                                                a.created_at")
                            );

        $modelcnt = $filteredmodel->count();

        $data = DataTables::DataTableFiltersNormalSearch($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);

        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::select(['id', 'name', 'price'])->get();
        
        return view('admin.registrationcodes.create', ['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GenerateEntryCodeRequest $request)
    {
        try
        {            
            DB::beginTransaction();
            
            $assignedMember = null;
            if($request->username) {
                $member = \App\Models\Member::where('username', $request->username)->first();
                if($member) {
                    $assignedMember = $member->id;
                }
            }
            
            $product = Product::find($request->product_id);   
            
            EntryCodesLibrary::createEntryCodes($product, $assignedMember, $request->code_count, $request->remarks);
            
            DB::commit();
            
            return redirect()->route('admin.entrycodes.index')->with('status-success', $request->code_count . ' entry code(s) has been added to the system');
            
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
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
        $entrycode = RegistrationCode::find($id);
        
        return view('admin.registrationcodes.edit', ['entrycode' => $entrycode]);
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
        try
        {            
            DB::beginTransaction();
            
            $entrycode = RegistrationCode::find($id);           
            $entrycode->update($request->only([
                'is_used', 
                'remarks']));
            
            DB::commit();
            
            return redirect()->route('admin.entrycodes.index')->with('status-success', 'Entry code # ['.$entrycode->id.'] has been updated');
            
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            RegistrationCode::find($id)->delete();
            return redirect()->route('admin.entrycodes.index')
                            ->with('status-success','Entry code #'.$id.' deleted successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.entrycodes.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
}
