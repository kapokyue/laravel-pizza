@extends('layout')
@section('title', $title)
@section('content')
  <form method="post" action="/category{{ isset($isCreate) ? '' : '/' . $category->id }}"
        class="form-horizontal">
    {!! csrf_field() !!}{!! isset($isCreate) ? '' : method_field('put') !!}

    <div class="form-group">
      <label for="name" class="col-sm-offset-2 col-sm-2 control-label">Name</label>

      <div class="col-sm-4">
        <input id="name" type="text" name="name" value="{{ $category->name }}"
               class="form-control" placeholder="Name"/>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-7 col-sm-1" style="text-align: center;">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
@endsection