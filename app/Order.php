<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $table = 'customer_order';
  protected $guarded = [ ];
  public $timestamps = false;

  public function user()
  {
    return $this->belongsTo( User::class );
  }

  public function orderItems()
  {
    return $this->hasMany( OrderItem::class );
  }
}
