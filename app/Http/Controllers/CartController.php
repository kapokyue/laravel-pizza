<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Cart;
use Auth;

class CartController extends Controller
{
  public function __construct()
  {
    $this->middleware( 'auth:C' );
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view( 'cart', [
        'products' => Cart::where( 'user_id', Auth::user()->id )
                          ->get()
                          ->map( function ( $cart ) {
                            return $cart->product;
                          } ),
    ] );
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\Response
   */
  public function store( Request $request )
  {
    Cart::create( [
        'user_id' => Auth::user()->id,
        'product_id' => $request->get( 'productId' ),
    ] );
    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy( int $id )
  {
    Cart::destroy( [
        'user_id' => Auth::user()->id,
        'product_id' => $id,
    ] );
    return back();
  }
}
