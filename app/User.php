<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract
{
  use Authenticatable, Authorizable;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'system_user';

  protected $guarded = [ ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [ 'password', 'remember_token' ];

  public $timestamps = false;

  public function orders()
  {
    return $this->hasMany( Order::class );
  }

  public function carts()
  {
    return $this->hasMany( Cart::class );
  }
}
