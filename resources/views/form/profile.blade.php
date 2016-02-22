@extends('layout')
@section('title', 'Profile')
@section('content')
  <form method="post" class="form-horizontal">
    {!! csrf_field() !!}{!! method_field('put') !!}
    <div class="form-group">
      <label for="account" class="col-sm-offset-2  col-sm-2 control-label">User Name</label>

      <div class="col-sm-4">
        <input id="account" type="text" name="account" value="{{ $user->account }}"
               class="form-control" placeholder="User Name"/>
      </div>
    </div>
    <div class="form-group">
      <label for="newPwd" class="col-sm-offset-2  col-sm-2 control-label">Password</label>

      <div class="col-sm-4">
        <input id="newPwd" type="password" name="password"
               class="form-control" placeholder="Password"/>
      </div>
    </div>
    <div class="form-group">
      <label for="confPwd" class="col-sm-offset-2  col-sm-2 control-label">Re-enter Password</label>

      <div class="col-sm-4">
        <input id="confPwd" type="password" name="password_confirmation"
               class="form-control" placeholder="Re-enter New Password"/>
      </div>
    </div>
    <div class="form-group">
      <label for="surname" class="col-sm-offset-2  col-sm-2 control-label">Surname</label>

      <div class="col-sm-4">
        <input id="surname" type="text" name="name" value="{{ $user->name }}"
               class="form-control" placeholder="Surname"/>
      </div>
    </div>
    <div class="form-group">
      <label for="phone" class="col-sm-offset-2  col-sm-2 control-label">Contact Number</label>

      <div class="col-sm-4">
        <input id="phone" type="text" name="phone" value="{{ $user->phone }}"
               class="form-control" placeholder="Contact Number"/>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-5 col-sm-3" style="text-align: center;">
        <button type="submit" class="btn btn-primary pull-right">Update</button>
      </div>
    </div>
  </form>
@endsection