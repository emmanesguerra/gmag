<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\MembersRegistrationCode;
use App\Models\Product;
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
        
        $entrycodes = MembersRegistrationCode::select(['id', 'pincode1', 'pincode2', 'product_id', 'is_used', 'remarks', 'created_at', 'created_by'])
                ->with(['product' => function ($query) {
                    $query->select('name', 'price', 'id');
                }, 'creator' => function ($query) {
                    $query->select('name', 'id');
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
            
            $product = Product::find($request->product_id);
            $data = array();
            for ($i = 0; $i < $request->code_count; $i++) {
                $data[] = [
                    'product_id' => $request->product_id,
                    'remarks' => $request->remarks,
                    'pincode1' => $product->registration_code_prefix . substr(strtoupper(bin2hex(random_bytes(10))), 0, 6),
                    'pincode2' => substr(strtoupper(bin2hex(random_bytes(10))), 0, 8),
                    'created_by' => Auth::id(),
                    'created_at' => \Carbon\Carbon::now()
                ];
            }
            
            MembersRegistrationCode::insertOrIgnore($data);                
            
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
}
