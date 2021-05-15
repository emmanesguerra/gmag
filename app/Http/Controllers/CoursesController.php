<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

/**
 * @group Course List
 *
 */
class CoursesController extends Controller
{
    /**
     * Display the list of courses for logged in members
     * 
     * - Link can be found on the left side menu of Member page * COURSES
     */
    public function index(Request $request)
    {
        $show = (isset($request->show)) ? $request->show: 10;
        
        $courses = Course::select(['id', 'title', 'description', 'link', 'link_id', 'source', 'filename', 'file_thumbnail'])
                        ->orderBy('id', 'desc')
                        ->paginate($show);
        
        return view('course-list', ['courses' => $courses]);
    }
}
