@extends('layout')
@section('title', 'Orders')
@section('content')
  <form id="deliver-form" method="post">
    {!! method_field('put') !!}{!! csrf_field() !!}
    <input type="hidden" name="status" value="Delivering">
  </form>
  <form id="done-form" method="post">
    {!! method_field('put') !!}{!! csrf_field() !!}
    <input type="hidden" name="status" value="Done">
  </form>
  <script>
    function deliver( oid ) {
      jQuery( '#deliver-form' ).attr( 'action', '/order/' + oid ).submit();
    }
    function done( oid ) {
      jQuery( '#done-form' ).attr( 'action', '/order/' + oid ).submit();
    }
  </script>
  <h3>Cooking</h3>
  <table class="table table-bordered table-hover">
    <tr>
      <th>Order ID</th>
      <th>Customer</th>
      <th>Address</th>
      <th>Ordered Product</th>
      <th>Charge</th>
      <th>Order At</th>
      <th></th>
    </tr>
    @foreach($cookingOrders as $order)
      <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->user->name }}</td>
        <td>{{ $order->user->address }}</td>
        <td>{!! $order->orderItems->map([\App\OrderItem::class,'toReadableString'])->implode( '<br>' ) !!}</td>
        <td>{{ $order->charge }}</td>
        <td>{{ $order->order_at }}</td>
        <td>
          <button class="btn btn-primary" onclick="deliver({{ $order->id }})">
            Deliver
          </button>
        </td>
      </tr>
    @endforeach
  </table>

  <h3>Delivering</h3>
  <table class="table table-bordered table-hover">
    <tr>
      <th>Order ID</th>
      <th>Customer</th>
      <th>Address</th>
      <th>Ordered Product</th>
      <th>Charge</th>
      <th>Order At</th>
      <th></th>
    </tr>
    @foreach($deliveringOrders as $order)
      <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->user->name }}</td>
        <td>{{ $order->user->address }}</td>
        <td>{!! $order->orderItems->map([\App\OrderItem::class,'toReadableString'])->implode( '<br>' ) !!}</td>
        <td>{{ $order->charge }}</td>
        <td>{{ $order->order_at }}</td>
        <td>
          <button class="btn btn-success" onclick="done({{ $order->id }})">
            Done
          </button>
        </td>
      </tr>
    @endforeach
  </table>
@endsection