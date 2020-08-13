<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Plan;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permissionadmin');
    }

    public function index()
    {   
        return view('admin.plan.main', [
            'plans' => Plan::where('is_deleted', null)->get()
        ]);
    }
}
