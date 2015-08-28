<?php

namespace TeamReport\Http\Controllers;

use Illuminate\Http\Request;

use TeamReport\Http\Requests;
use TeamReport\Http\Controllers\Controller;
use TeamReport\Jobs\GenerateReports;

class ReportsController extends Controller
{
    /**
     * Generate the project report.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generate()
    {
        $this->dispatch(new GenerateReports());
        return redirect()->route('home');
    }
}
