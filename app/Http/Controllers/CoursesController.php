<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CoursesController extends Controller
{
    //
    public function index(Request $request)
    {
        $show = (isset($request->show)) ? $request->show: 10;
        
        $courses = Course::select(['id', 'title', 'link', 'link_id', 'source', 'filename'])
                        ->orderBy('id', 'desc')
                        ->paginate($show);
        
        return view('course-list', ['courses' => $courses]);
    }
}
