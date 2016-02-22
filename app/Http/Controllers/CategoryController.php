<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Cart;
use App\Product;

class CategoryController extends Controller
{
  public function __construct()
  {
    $this->middleware( 'auth:M', [ 'except' => [ 'show' ] ] );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view( 'form.category', [
        'isCreate' => true,
        'title' => 'New Category',
        'category' => new Category(),
        'navActive' => 'addCategory',
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
    $this->validate( $request, [ 'name' => 'required' ] );
    Category::create( [ 'name' => $request->get( 'name' ) ] );

    return back()->with( 'success', 'Create successful' );
  }

  /**
   * Display the specified resource.
   *
   * @param  int $categoryId
   *
   * @return \Illuminate\Http\Response
   */
  public function show( int $categoryId )
  {
    return view( 'product', [
        'products' => Product::where( 'category_id', $categoryId )->get(),
        'categorys' => Category::all(),
        'catActive' => $categoryId,
        'navActive' => 'productList',
        'cart' => Cart::getUserCart(),
    ] );
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function edit( int $id )
  {
    return view( 'form.category', [
        'title' => 'Edit Category',
        'category' => Category::find( $id ),
    ] );
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
    $this->validate( $request, [ 'name' => 'required' ] );
    Category::find( $id )->update( [ 'name' => $request->get( 'name' ) ] );

    return redirect( '/' )->with( 'success', 'Edit successful' );
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Request $request
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy( Request $request, int $id )
  {
    Category::destroy( $id );
    return back()->with( 'success', 'Delete successful' );
  }
}
