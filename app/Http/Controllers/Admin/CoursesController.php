<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CoursesCreateRequest;
use App\Models\Course;
use App\Library\DataTables;

class CoursesController extends Controller
{
    const THIRD_PARTY = 1;
    const HOSTED = 2;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.course.index');
    }
    
    public function getdata(Request $request)
    {
        $tablecols = [
            0 => 'created_at',
            1 => 'title',
            2 => 'source',
            3 => 'link',
            4 => 'filename'
        ];
        
        $filteredmodel = DB::table('courses')
                                ->select(DB::raw("title, 
                                                source, 
                                                link,
                                                filename,
                                                created_at,
                                                id")
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
        return view('admin.course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CoursesCreateRequest $request)
    {
        try
        {
            DB::beginTransaction();
            
            $course = new Course();
            $course->title = $request->title;
            $course->link = $request->link;
            $course->source = self::THIRD_PARTY;
            
            if($request->hasFile('fileToUpload')) {
                $upload = $request->file('fileToUpload');
                $newname = time() . '_' . strtolower($upload->getClientOriginalName());
                Storage::disk('courses')->put($newname, file_get_contents($upload));
                
                $course->filename = $newname;
                $course->source = self::HOSTED;
            }
            
            $course->save();
            
            DB::commit();
            return redirect()->route('admin.course.index')->with('status-success', 'Course ['.$request->title.'] has been added to the system');
            
        } catch (\Exception $ex) {
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
        $course = Course::find($id);
        
        if($course->source == self::HOSTED) {
            Storage::disk('courses')->delete($course->filename);
        }
        
        $course->delete();
        
        return redirect()->route('admin.course.index')->with('status-success', 'Course ['.$id.'] has been deleted to the system');
    }
}
