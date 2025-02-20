<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Library\DataTables;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.index');
    }
    
    public function data(Request $request)
    {
        $tablecols = [
            0 => 'id',
            1 => 'code',
            2 => 'name',
            3 => 'price',
            4 => 'product_value',
            5 => 'flush_bonus'
        ];
        
        $filteredmodel = DB::table('products')
                                ->select(DB::raw(" id, 
                                                 name, 
                                                 code,
                                                 slug,
                                                 product_value,
                                                 price,
                                                 flush_bonus,
                                                 created_at")
                            );
        
        if($request->has('start_date') && !empty($request->start_date)) {        
            if($request->has('end_date') && !empty($request->end_date && $request->start_date != $request->end_date)) {
                $filteredmodel->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:00']);
            } else {
                $filteredmodel->whereDate('created_at', $request->start_date);
            }
        }

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
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddProductRequest $request)
    {
        try
        {            
            DB::beginTransaction();
            
            $product = Product::create($request->only([
                'type', 
                'name', 
                'code', 
                'price', 
                'product_value', 
                'flush_bonus',
                'display_icon',
                'registration_code_prefix']));
            
            DB::commit();
            
            return redirect()->route('admin.products.index')->with('status-success', 'Product ['.$product->name.'] has been added to the system');
            
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
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();
        
        return view('admin.products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->first();
        
        return view('admin.products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        try
        {            
            DB::beginTransaction();
            
            $product = Product::find($id);           
            $product->update($request->only([
                'type', 
                'name', 
                'code', 
                'price', 
                'product_value', 
                'flush_bonus',
                'display_icon',
                'registration_code_prefix']));
            
            DB::commit();
            
            return redirect()->route('admin.products.index')->with('status-success', 'Product id ['.$product->id.'] has been updated');
            
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
        //
    }
}
