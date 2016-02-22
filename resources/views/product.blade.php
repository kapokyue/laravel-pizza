@extends('layout')
@section('title', 'Products')
@section('content')
  <div><!-- Searching Form-->
    <form action="/search" method="get" target="_self"
          class="form-inline"
          style="float: none !important;text-align: center;">

      <div class="form-group">
        <label for="search-name">Searching Product</label>
        <input id="search-name" class="form-control" type="text" name="name"/>
      </div>

      <div class="form-group">
        <label for="sorter">Sort:</label>
        <select id="sorter" name="sorter" class="form-control">
          <option value=""></option>
          <option value="name,asc">Name - Start from character a</option>
          <option value="price,desc">Price - Start from higher price</option>
          <option value="price,asc">Price - Start from lower price</option>
        </select>
      </div>

      <input class="btn btn-primary" type="submit" value="submit"/>
    </form>
  </div><!-- End Searching Form-->

  <hr/>

  <form id="delete-form" method="post">
    {!! method_field('delete') !!}{!! csrf_field() !!}
  </form>
  <form id="cartAdd-form" method="post" action="/cart">
    {!! csrf_field() !!}
    <input type="hidden" name="productId" id="cartAdd-form-input">
  </form>
  <script>
    function deleteAction( action ) {
      var deleteForm = document.getElementById( 'delete-form' );
      deleteForm.action = action;
      confirm( 'Are you sure?' ) && deleteForm.submit();
    }
    function cartAdd( $productId ) {
      var postForm = document.getElementById( 'cartAdd-form' ),
          input    = document.getElementById( 'cartAdd-form-input' );
      input.value = $productId;
      postForm.submit();
    }
  </script>

  <!-- Catalog Content -->
  <div class="row">
    <div class="col-md-3">
      <h2 class="lead">Menu</h2>

      <ul class="list-group">
        <li class="list-group-item {{ $catActive == 0 ? 'active' : '' }}">
          <a href="/product" target="_self">All</a>
        </li>

        @foreach ($categorys as $category)
          <li class="list-group-item f center space-between {{ $category->id == $catActive ? 'active' : '' }}">
            <a href="/category/{{ $category->id }}" target="_self">{{ $category->name }}</a>
            @if ( Auth::check() && Auth::user()->type === 'M' )
              <div class="f">
                <a href="/category/{{ $category->id }}/edit" class="pull-right" style="margin-right: 5px">
                  <button class="btn btn-default btn-sm">Edit</button>
                </a>
                <button class="btn btn-danger btn-sm"
                        onclick="deleteAction('/category/{{ $category->id }}')">Delete
                </button>
              </div>
            @endif
          </li>
        @endforeach
      </ul>
    </div>

    <div class="col-md-9">
      <div class="row carousel-holder">
        <div class="row">
          @forelse ($products as $product)
            <div class="col-sm-4 col-lg-4 col-md-4">
              <div class="thumbnail">
                <img src="{{ $product->img }}" alt="{{ $product->name }}" style="width:320px;height:200px">
                <div style="padding: 10px">
                  <div>
                    <h4><a href="javascript:void(0)">{{ $product->name }}</a></h4>
                    <h4 class="pull-right">${{ $product->price }}</h4>

                    <p>{{ $product->description }}</p>
                  </div>
                  @if ( Auth::check() )
                    <hr>
                    @if ( Auth::user()->type === 'C' )
                      @if ( isset($cart[$product->id]) )
                        <div class="text-right">
                          <button class="btn btn-danger" onclick="deleteAction('/cart/{{ $product->id }}')">
                            Delete from Shopping Cart
                          </button>
                        </div>
                      @else
                        <div class="text-right">
                          <button class="btn btn-default" onclick="cartAdd({{ $product->id }})">
                            Add to Shopping Cart
                          </button>
                        </div>
                      @endif
                    @elseif ( Auth::user()->type === 'M' )
                      <div class="f flex-end">
                        <a href="/product/{{ $product->id }}/edit" style="margin-right: 5px">
                          <button class="btn btn-default">Edit</button>
                        </a>
                        <button class="btn btn-danger"
                                onclick="deleteAction('/product/{{ $product->id }}')">Delete
                        </button>
                      </div>
                    @endif
                  @endif
                </div>
              </div>
            </div>
          @empty
            <p>No Product is found.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
@endsection