<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
use Session;
use App\Account;
class Admin
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

        /*'fBaCZemyXbk6uUButDcfLhw1Z21B56Yd4sS4MR3'*/
        /*dd(Auth::user()->m_token.'!='.Session::get('m_token'));*/

        if (Auth::check()) {
          if(Auth::user()->role != "admin"){
                  return Redirect('/admin');
          }
        } else {
          return Redirect('/');
        }

        return $next($request);
    }
}
