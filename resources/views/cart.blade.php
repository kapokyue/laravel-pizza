@extends('layout')
@section('title', 'Cart')
@section('content')
  <form id="delete-form" method="post">
    {!! method_field('delete') !!}{!! csrf_field() !!}
  </form>
  <script>
    function deleteAction( action ) {
      var deleteForm = document.getElementById( 'delete-form' );
      deleteForm.action = action;
      confirm( 'Are you sure?' ) && deleteForm.submit();
    }
  </script>

  <div style="width: 80%; margin: auto;">
    @if ( count( $products ) > 0 )
      <div>
        <p>You have {{ count( $products ) }} item(s) in your shopping cart</p>

        <form method="post" action="/order" class="form-horizontal">
          {!! csrf_field() !!}
          <table class="table table-bordered table-hover">
            <tr>
              <th>Name</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Action</th>
            </tr>
            @foreach($products as $i => $product)
              <tr>
                <td>{{ $product->name }}</td>
                <td>${{ $product->price }}</td>
                <td>
                  <input name="qty[{{ $product->id }}]" type="text" value="1" title="quantity"
                         class="form-control qty-input" data-price="{{ $product->price }}"/>
                </td>
                <td>
                  <button class="btn btn-danger" style="margin-right: 5px" type="button"
                          onclick="deleteAction('/cart/{{ $product->id }}')">
                    Cancel
                  </button>
                </td>
              </tr>
            @endforeach
          </table>

          Address:<br>
            <textarea name="address" class="form-control"
                      placeholder="Address"></textarea>
          Note:<br>
            <textarea name="note" class="form-control"
                      placeholder="Any note you want to say"></textarea>
          <hr>
          <p>Total Price: $<span id="total"></span></p><br/>
          <script>
            var $chargeView = jQuery( '#total' ),
                $qtyInput = jQuery( '.qty-input' ),
                updatePrice = function () {
                  var charge = 0;
                  $qtyInput.each( function () {
                    var price = parseFloat( jQuery( this ).data( 'price' ) ),
                        qty   = parseInt( this.value );
                    charge += price * qty;
                  } );
                  $chargeView.html( charge );
                };
            updatePrice();
            $qtyInput.change( updatePrice );
          </script>

          <input type="submit" value="Buy" class="btn btn-success">
          <button onclick="history.go( -1 );" class="btn btn-default">Back</button>
        </form>
      </div>
    @else
      <div>
        <p>You have no product in shopping cart</p>
      </div>
    @endif
  </div>
@endsection