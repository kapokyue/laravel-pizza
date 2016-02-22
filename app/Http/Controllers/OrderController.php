<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Order;
use App\OrderItem;
use App\Cart;
use Auth;

class OrderController extends Controller
{
  public function __construct()
  {
    $this->middleware( 'auth' );
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view( 'order', [
        'navActive' => 'viewOrder',
        'cookingOrders' => Order::where( 'status', 'Cooking' )
                                ->orderBy( 'order_at' )->get(),
        'deliveringOrders' => Order::where( 'status', 'delivering' )
                                   ->orderBy( 'order_at' )->get(),
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
    $qtys = $request->get( 'qty' );
    $charge = Cart::where( 'user_id', Auth::user()->id )->get()
                  ->map( function ( $c ) {
                    return $c->product;
                  } )
                  ->sum( function ( $p ) use ( $qtys ) {
                    return $p->price * $qtys[ $p->id ];
                  } );

    $order = Order::create( [
        'user_id' => Auth::user()->id,
        'note' => $request->get( 'note' ),
        'charge' => $charge,
        'status' => 'Cooking',
        'address' => $request->get( 'address' ),
    ] );

    foreach ( $qtys as $pid => $qty ) {
      OrderItem::create( [
          'product_id' => $pid,
          'order_id' => $order->id,
          'qty' => $qty,
      ] );
    }

    Cart::where( 'user_id', Auth::user()->id )->delete();

    return redirect( '/' )
        ->with( 'success', 'Your order will be delivered to ' . $request->get( 'address' ) . ' soon.' );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function update( Request $request, int $id )
  {
    Order::find( $id )->update( [ 'status' => $request->get( 'status' ) ] );
    return back();
  }

  public function history()
  {
    return view( 'order-history', [
        'navActive' => 'orderHistory',
        'orders' => Auth::user()->type == 'M'
            ? Order::orderBy( 'order_at' )->get()
            : Order::where( 'user_id', Auth::user()->id )->orderBy( 'order_at' )->get(),
    ] );
  }
}
