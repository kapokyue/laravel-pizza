<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
  /**
   * The Guard implementation.
   *
   * @var Guard
   */
  protected $auth;

  /**
   * Create a new filter instance.
   *
   * @param  Guard $auth
   *
   * @return void
   */
  public function __construct( Guard $auth )
  {
    $this->auth = $auth;
  }

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @param string $userType
   *
   * @return mixed
   */
  public function handle( $request, Closure $next, $userType = null )
  {
    if ( $this->auth->guest() ) {
      if ( $request->ajax() ) {
        return response( 'Unauthorized.', 401 );
      } else {
        return redirect()->guest( 'auth/login' );
      }
    }

    if ( $userType != null ) {
      if ( $userType != $this->auth->user()->type ) {
        $request->session()->flash( 'err', 'You are not allowed to do this action' );
        return back();
      }
    }

    return $next( $request );
  }
}
