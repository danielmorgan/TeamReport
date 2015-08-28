<?php

namespace TeamReport\Http\Controllers;

use Illuminate\Http\Request;

use TeamReport\Http\Requests;
use TeamReport\Http\Controllers\Controller;
use Storage;
use TeamReport\Jobs\GenerateReports;

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
     * @param  int  $id     Project ID
     * @return Response
     */
    public function show($id)
    {
        $report = json_decode(Storage::get('report.json'), true);
        $result = array_first($report, function($key, $project) use (&$id) {
            if ($project['id'] == $id || trim($project['name']) == $id) {
                return $project;
            }
        });

        if ($result) {
            return response()->json($result);
        }

        return response()->json(['message' => 'Project not found'], 404);
    }
}
