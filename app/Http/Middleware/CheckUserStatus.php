<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\UserStatus;
class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()) {
            # code...

        $status=UserStatus::where('user_id',Auth::user()->id)->select('slug')->first();
        // dd($status);

        if (!$status->slug) {

            return redirect('/change_password')->with('message','Your account is currently inactive please change password to activate it');

        }
        return $next($request);
        }
        else{
            return redirect('/login');
        }
    }
}
