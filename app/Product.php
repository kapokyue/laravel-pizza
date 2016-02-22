<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $table = 'product';
  protected $guarded = [ ];
  public $timestamps = false;

  public function orderItems()
  {
    return $this->hasMany( OrderItem::class );
  }
}
