<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
		if($request->ajax()) {
			return LogActivity::dataTable($request);
		}

		return view('users.logActivites', [
			'title' => 'Log Aktivitas',
		]);
    }
}
