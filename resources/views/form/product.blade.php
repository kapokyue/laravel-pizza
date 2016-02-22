@extends('layout')
@section('title', $title)
@section('content')
  <form method="post" action="/product{{ isset($isCreate) ? '' : '/' . $product->id }}"
        class="form-horizontal" enctype="multipart/form-data">
    {!! csrf_field() !!}{!! isset($isCreate) ? '' : method_field('put') !!}

    <div class="form-group">
      <label for="name" class="col-sm-offset-2 col-sm-2 control-label">Name</label>

      <div class="col-sm-4">
        <input id="name" type="text" name="name" value="{{ $product->name }}"
               class="form-control" placeholder="Name"/>
      </div>
    </div>

    <div class="form-group">
      <label for="price" class="col-sm-offset-2 col-sm-2 control-label">Price</label>

      <div class="col-sm-4">
        <input id="price" type="text" name="price" value="{{ $product->price }}"
               class="form-control" placeholder="Price"/>
      </div>
    </div>

    <div class="form-group">
      <label for="category" class="col-sm-offset-2 col-sm-2 control-label">Category:</label>

      <div class="col-sm-4">
        <select id="category" name="category_id" class="form-control">
          @foreach($categorys as $category)
            <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="img" class="col-sm-offset-2 col-sm-2 control-label">Image</label>

      <div class="col-sm-4">
        <input id="img" type="file" name="img" class="form-control" placeholder="Image"/>
      </div>
    </div>

    <div class="form-group">
      <label for="img" class="col-sm-offset-2 col-sm-2 control-label">Description</label>

      <div class="col-sm-4">
        <textarea name="description" class="form-control" rows="3"
                  placeholder="Description">{{ $product->description }}</textarea>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-7 col-sm-1" style="text-align: center;">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
@endsection