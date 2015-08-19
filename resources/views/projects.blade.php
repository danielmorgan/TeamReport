@extends('layouts.master')
@section('title', 'All Projects')

@section('content')
<!--<div class="row">
    <div>
        <h1>All Projects</h1>
    </div>
</div>

<div class="row">
    <div class="project">
        <h2>DB-ABC-XYZ</h2>
        
        <div class="row">
            <div class="col-sm-8 chart">
                <canvas id="testChart"></canvas>
            </div>

            <div class="col-sm-4" class="tooltip">
                <table class="times">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="budget">Budget</th>
                            <th class="used">Used</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="tasklist">Project Management</td>
                            <td class="budget">50 Hours</td>
                            <td class="used">64 Hours</td>
                        </tr>
                        <tr>
                            <td class="tasklist">Research</td>
                            <td class="budget">22 Hours</td>
                            <td class="used">23 Hours</td>
                        </tr>
                        <tr>
                            <td class="tasklist">Systems Development</td>
                            <td class="budget">120 Hours</td>
                            <td class="used">0 Hours</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>-->

<div id="charts"></div>
@endsection
