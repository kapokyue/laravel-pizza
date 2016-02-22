<?php

namespace App\Providers;

use Request;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
  /**
   * This namespace is applied to the controller routes in your routes file.
   *
   * In addition, it is set as the URL generator's root namespace.
   *
   * @var string
   */
  protected $namespace = 'App\Http\Controllers';

  /**
   * Define your route model bindings, pattern filters, etc.
   *
   * @param  \Illuminate\Routing\Router $router
   *
   * @return void
   */
  public function boot( Router $router )
  {
    parent::boot( $router );
  }

  /**
   * Define the routes for the application.
   *
   * @param  \Illuminate\Routing\Router $router
   *
   * @return void
   */
  public function map( Router $router )
  {
    $router->group( [ 'namespace' => $this->namespace ], function ( Router $router ) {
      $router->get( '/', function ( Router $router ) {
        return $router->dispatch( Request::create( 'product', 'GET', [ ] ) );
      } );

      $router->get( '/about-us', function () {
        return view( 'about-us', [
            'navActive' => 'about-us',
        ] );
      } );

      $router->resource( '/product', 'ProductController', [ 'except' => [ 'show' ] ] );
      $router->resource( '/category', 'CategoryController', [ 'except' => [ 'index' ] ] );
      $router->resource( '/cart', 'CartController', [ 'only' => [ 'index', 'store', 'destroy' ] ] );
      $router->resource( '/order', 'OrderController', [ 'only' => [ 'index', 'store', 'update' ] ] );
      $router->get( 'order/history', 'OrderController@history' );

      $router->get( '/search', 'ProductController@search' );

      $router->get( '/login', 'Auth\AuthController@getLogin' );
      $router->post( '/login', 'Auth\AuthController@postLogin' );
      $router->get( '/logout', 'Auth\AuthController@getLogout' );
      $router->get( '/register', 'Auth\AuthController@getRegister' );
      $router->post( '/register', 'Auth\AuthController@postRegister' );
      $router->get( '/account/edit', 'Auth\AuthController@edit' );
      $router->put( '/account/edit', 'Auth\AuthController@update' );

    } );
  }
}
