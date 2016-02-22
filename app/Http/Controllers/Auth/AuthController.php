<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Registration & Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users, as well as the
  | authentication of existing users. By default, this controller uses
  | a simple trait to add these behaviors. Why don't you explore it?
  |
  */

  use AuthenticatesAndRegistersUsers, ThrottlesLogins;

  protected $redirectPath = '/';
  protected $loginPath = '/login';
  protected $fieldRequirement = [
      'account' => 'required|max:255',
      'password' => 'required|confirmed|min:6',
      'phone' => 'required|digits:8',
      'name' => 'required',
  ];

  /**
   * Create a new authentication controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware( 'guest', [ 'except' => [ 'getLogout', 'edit', 'update' ] ] );
  }

  /**
   * Get the login username to be used by the controller.
   *
   * @return string
   */
  public function loginUsername()
  {
    return 'account';
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array $data
   *
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator( array $data )
  {
    return Validator::make( $data, $this->fieldRequirement );
  }


  /**
   * Override the implementation of trait.
   *
   * @param Request $request
   *
   * @return Response
   *
   */
  public function postLogin( Request $request )
  {
    $user = User::where( 'account', $request->get( $this->loginUsername() ) )
                ->where( 'password', $request->get( 'password' ) )
                ->first();

    // If the class is using the ThrottlesLogins trait, we can automatically throttle
    // the login attempts for this application. We'll key this by the username and
    // the IP address of the client making these requests into this application.
    $throttles = $this->isUsingThrottlesLoginsTrait();

    if ( $throttles && $this->hasTooManyLoginAttempts( $request ) ) {
      return $this->sendLockoutResponse( $request );
    }

    if ( $user ) {
      Auth::login( $user, $request->get( 'remember' ) );
      return $this->handleUserWasAuthenticated( $request, $throttles );
    } else {
      // If the login attempt was unsuccessful we will increment the number of attempts
      // to login and redirect the user back to the login form. Of course, when this
      // user surpasses their maximum number of attempts they will get locked out.
      if ( $throttles ) {
        $this->incrementLoginAttempts( $request );
      }
      return redirect( $this->loginPath )
          ->exceptInput( 'password' )
          ->withErrors( [
              $this->loginUsername() => $this->getFailedLoginMessage(),
          ] );
    }
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array $data
   *
   * @return User
   */
  protected function create( array $data )
  {
    return User::create( [
        'account' => $data[ 'account' ],
        'password' => $data[ 'password' ],
        'phone' => $data[ 'phone' ],
        'name' => $data[ 'name' ],
        'type' => 'C',
    ] );
  }

  public function edit()
  {
    return view( 'form.profile', [
        'user' => Auth::user(),
    ] );
  }

  public function update( Request $request )
  {
    $this->fieldRequirement[ 'password' ] = 'confirmed|min:6';
    $this->validate( $request, $this->fieldRequirement );

    $param = [
        'account' => $request->get( 'account' ),
        'phone' => $request->get( 'phone' ),
        'name' => $request->get( 'name' ),
    ];

    if ( $request->has( 'password' ) ) {
      $param[ 'password' ] = $request->get( 'password' );
    }

    Auth::user()->update( $param );

    return back()->with( 'success', 'Update successful' );
  }
}
