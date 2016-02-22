<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Category;
use App\Product;

class ProductController extends Controller
{
  protected $fieldRequirement = [
      'name' => 'required',
      'price' => 'required|numeric|min:0',
      'category_id' => 'required',
      'description' => 'required',
      'img' => 'required|image',
  ];

  public function __construct()
  {
    $this->middleware( 'auth:M', [ 'except' => [ 'index', 'search' ] ] );
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view( 'product', [
        'products' => Product::all(),
        'categorys' => Category::all(),
        'catActive' => 0,
        'navActive' => 'productList',
        'cart' => Cart::getUserCart(),
    ] );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view( 'form.product', [
        'isCreate' => true,
        'categorys' => Category::all(),
        'title' => 'New Product',
        'product' => new Product(),
        'navActive' => 'addProduct',
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
    $this->validate( $request, $this->fieldRequirement );

    $img = $request->file( 'img' );
    $imgName = hash_file( 'sha256', $img->getRealPath() ) . '.' . $img->getExtension();
    $img->move( public_path() . '/img', $imgName );

    Product::create( [
        'name' => $request->get( 'name' ),
        'price' => $request->get( 'price' ),
        'category_id' => $request->get( 'category_id' ),
        'description' => $request->get( 'description' ),
        'img' => '/img/' . $imgName,
    ] );

    return back()->with( 'success', 'Create successful' );
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
    return view( 'form.product', [
        'categorys' => Category::all(),
        'product' => Product::find( $id ),
        'title' => 'Edit Product',
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
    $this->validate( $request, $this->fieldRequirement );

    $param = [
        'name' => $request->get( 'name' ),
        'price' => $request->get( 'price' ),
        'category_id' => $request->get( 'category_id' ),
        'description' => $request->get( 'description' ),
    ];

    $img = $request->file( 'img' );
    if ( $img && $img->isValid() ) {
      $imgName = hash_file( 'sha256', $img->getRealPath() ) . '.' . $img->getExtension();
      $img->move( public_path(), $imgName );
      $param[ 'img' ] = $imgName;
    }

    Product::find( $id )->update( $param );

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
    Product::destroy( $id );
    return back()->with( 'success', 'Delete successful' );
  }

  public function search( Request $request )
  {
    $products = Product::where( 'name', 'LIKE', "%{$request->get('name')}%" );
    if ( ( $sorter = $request->get( 'sorter' ) ) != '' ) {
      $orderBy = explode( ',', $sorter );
      $products->orderBy( $orderBy[ 0 ], $orderBy[ 1 ] );
    }
    return view( 'product', [
        'products' => $products->get(),
        'categorys' => Category::all(),
        'navActive' => 'productList',
        'catActive' => 0,
        'cart' => Cart::getUserCart(),
    ] );
  }
}
