<?php

namespace TeamReport\Http\Controllers;

use Illuminate\Http\Request;

use TeamReport\Http\Requests;
use TeamReport\Http\Controllers\Controller;
use Storage;

class TasklistsController extends Controller
{
    /**
     * Display a listing of the tasklist resource.
     *
     * @param  int  $project    Project ID
     * @return Response
     */
    public function index($project)
    {
        $report = json_decode(Storage::get('report.json'), true);

        return response()->json($report[$project]['tasklists']);
    }

    /**
     * Display the specified tasklist resource.
     *
     * @param  int  $project    Project ID
     * @param  int  $tasklist   Tasklist ID
     * @return Response
     */
    public function show($project, $tasklist)
    {
        $report = json_decode(Storage::get('report.json'), true);

        return response()->json($report[$project]['tasklists'][$tasklist]);
    }
}
