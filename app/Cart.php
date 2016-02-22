<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Cart extends Model
{
  protected $table = 'cart';
  protected $guarded = [ ];
  public $timestamps = false;

  public static function getUserCart()
  {
    if ( Auth::check() ) {
      $cart = [ ];
      foreach ( self::where( 'user_id', Auth::user()->id )->get() as $c ) {
        $cart[ $c->product_id ] = true;
      }
      return $cart;
    }
    return false;
  }

  public function user()
  {
    return $this->belongsTo( User::class );
  }

  public function product()
  {
    return $this->belongsTo( Product::class );
  }
}
