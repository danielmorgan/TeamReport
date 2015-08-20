<?php

namespace TeamReport\Http\Controllers;

use Illuminate\Http\Request;

use TeamReport\Http\Requests;
use TeamReport\Http\Controllers\Controller;
use Storage;

class ProjectsController extends Controller
{

    /**
     * Display a listing of the project resource.
     *
     * @return Response
     */
    public function index()
    {
        $report = Storage::get('report.json');

        return response($report)->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified project resource.
     *
     * @param  int  $project    Project ID
     * @return Response
     */
    public function show($project)
    {
        $report = json_decode(Storage::get('report.json'), true);

        return response()->json($report[$project]);
    }
}
