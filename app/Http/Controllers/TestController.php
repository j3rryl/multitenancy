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
    //    dd($users);

    $users = User::all();
    dd($users);
    $companies = Company::all();
    dd($companies);
    //    dd(Company::with('users')->get());
       dd(app('currentTenant'));

 // Example query to verify tenant database switch
        // $marks = Company::has('users')->with('users')
        //         ->limit(1)->get();

        $tvetId = $request->query('tvet_id');

        $tenant = DB::table('tenants')->where('id', $tvetId)->first();

        $users = User::all();
        return response()->json([
            'message' => "Data fetched successfully from {$tenant?->database} database",
            'users' => $users,
        ]);
    }
}
