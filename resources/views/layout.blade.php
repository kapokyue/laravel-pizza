<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>@yield('title') - Laravel Pizza</title>

  {{-- jQuery --}}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
  {{-- Bootstrap --}}
  <script src="https://cdn.jsdelivr.net/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
  <link href="https://cdn.jsdelivr.net/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/shop.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default" role="navigation" style="position: fixed; width: 100%; z-index: 99; top: 0;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/">Laravel Pizza</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li id="productList"><a href="/product">Product List</a></li>
        <li id="about-us"><a href="/about-us">About Us</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        @if ( Auth::check() )
          @if ( Auth::user()->type === 'C' )
            <li id="cart"><a href="/cart">My Shopping Cart</a></li>
            <li id="orderHistory"><a href="/order/history">Orders History</a></li>
          @elseif ( Auth::user()->type === 'M' )
            <li id="viewOrder"><a href="/order">View Orders</a></li>
            <li id="orderHistory"><a href="/order/history">Orders History</a></li>
            <li id="addProduct"><a href="/product/create">Add Product</a></li>
            <li id="addCategory"><a href="/category/create">Add Category</a></li>
          @endif

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
              {{ Auth::user()->name }} {{ Auth::user()->type === 'M' ? '(Manager)' : '' }}
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="/account/edit">Edit Profile</a></li>
              <li><a href="/logout">Logout</a></li>
            </ul>
          </li>
        @else
          <li id="register">
            <a href="/register">Register</a>
          </li>

          <li id="login">
            <a href="/login">Login</a>
          </li>
        @endif
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
@if (isset($navActive))
  <script>
    document.getElementById( "{{ $navActive }}" ).classList.add( "active" );
  </script>
@endif

<div class="container">
  <noscript><div class="alert alert-danger">JavaScript is required</div></noscript>
  @if (count($errors) > 0)
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  @if (isset($success))
    <div class="alert alert-success">
      {{ $success }}
    </div>
  @endif
  @yield('content')
</div>
</body>
</html>