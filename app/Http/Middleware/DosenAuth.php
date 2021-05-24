<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Dosen;
class DosenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        // return $next($request);
        $authHeader = $request->header('Authorization');
        if(!$authHeader ) {
            $response = [
                'status' => 401,
                'message' => 'Unauthorized'
            ];

            return response()->json($response,401);
        }
        $api_token = explode(' ', $request->header('Authorization'));
        $ujian = Dosen::where('api_token', $api_token[1])->first();

        if(!$ujian){
            $response = [
                'status' => 401,
                'message' => 'Unauthorized'
            ];

            return response()->json($response,401);
        }
        return $next($request);
    }
    
}
