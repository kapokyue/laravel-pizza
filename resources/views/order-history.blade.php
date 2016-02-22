@extends('layout')
@section('title', 'Orders History')
@section('content')
  <table class="table table-bordered table-hover">
    <tr>
      <th>Order ID</th>
      <th>Customer</th>
      <th>Address</th>
      <th>Ordered Product</th>
      <th>Charge</th>
      <th>Order At</th>
      <th>Status</th>
    </tr>
    @foreach($orders as $order)
      <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->user->name }}</td>
        <td>{{ $order->user->address }}</td>
        <td>{!! $order->orderItems->map([\App\OrderItem::class,'toReadableString'])->implode( '<br>' ) !!}</td>
        <td>{{ $order->charge }}</td>
        <td>{{ $order->order_at }}</td>
        <td>{{ $order->status }}</td>
      </tr>
    @endforeach
  </table>
@endsection