<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
  protected $table = 'order_item';
  protected $guarded = [ ];
  public $timestamps = false;

  public function order()
  {
    return $this->belongsTo( Order::class );
  }

  public function product()
  {
    return $this->belongsTo( Product::class );
  }

  public static function toReadableString( OrderItem $item )
  {
    return $item->product->name . ' * ' . $item->qty;
  }
}
