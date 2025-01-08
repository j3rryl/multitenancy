<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index(Request $request){
       ini_set('max_execution_time', -1);
    //    $users = User::with('company')->first();

    //    dd($users->toArray());

        $companies = Company::with('users')->get();
        dd($companies->toArray());
        //    dd(Company::with('users')->get());
        dd(app('currentTenant'));

        return response()->json([
            'message' => "Data fetched successfully from this database",
            'current_tenant' => app('currentTenant'),
        ]);

    }
}
