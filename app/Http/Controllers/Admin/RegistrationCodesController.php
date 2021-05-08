<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistrationCode;
use App\Models\Product;
use App\Library\Modules\EntryCodesLibrary;
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
        $search = $request->search;
        $status = (isset($request->status)) ? $request->status: 0;
        $show = (isset($request->show)) ? $request->show: 10;
        
        $entrycodes = RegistrationCode::select(['id', 'assigned_to_member_id', 'pincode1', 'pincode2', 'product_id', 'is_used', 'remarks', 'created_at', 'created_by'])
                ->with(['product' => function ($query) {
                    $query->select('name', 'price', 'id');
                }, 'creator' => function ($query) {
                    $query->select('name', 'id');
                }, 'member' => function ($query) {
                    $query->select('username', 'id');
                }])
                ->search(['search' => $search, 'status' => $status])->orderBy('id', 'desc')
                ->paginate($show);
        
        return view('admin.registrationcodes.index', ['entrycodes' => $entrycodes])->withQuery($search);
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
