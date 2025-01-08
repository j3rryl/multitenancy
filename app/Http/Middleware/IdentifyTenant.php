<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Fetch the tenant ID from query parameters
        // $tvetId = $request->query('tvet_id');
        // if (!$tvetId) {
        //     logger('No TVET ID provided in request.');
        //     return response()->json(['error' => 'TVET ID is required'], 400);
        // }

        // // Retrieve the tenant information from the landlord database
        // $tenant = DB::table('tenants')->where('id', $tvetId)->first();
        // if (!$tenant) {
        //     logger('Tenant not found for TVET ID: ' . $tvetId);
        //     return response()->json(['error' => 'Tenant not found'], 404);
        // }
        // config(['database.connections.tenant.database' => $tenant->database]);
        // DB::purge('tenant');
        // DB::reconnect('tenant');

        // config(['database.default' => 'tenant']);


        // Proceed with the request
        return $next($request);
    }
}
