@extends('layout')
@section('title', 'Login')
@section('content')
  <form method="post" class="form-horizontal">
    {!! csrf_field() !!}
    <div class="form-group">
      <label for="inputUN" class="col-sm-offset-2 col-sm-2 control-label">Account</label>

      <div class="col-sm-4">
        <input id="inputUN" type="text" name="account"
               class="form-control" maxlength="10" size="15" placeholder="User Name"/>
      </div>
    </div>
    <div class="form-group">
      <label for="inputPW" class="col-sm-offset-2 col-sm-2 control-label">Password</label>

      <div class="col-sm-4">
        <input id="inputPW" type="password" name="password"
               class="form-control" maxlength="10" size="15" placeholder="Password"/>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-6 col-sm-2 text-right">
        <label><input type="checkbox" name="remember" class="pull-right"> Remember Me</label>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-7 col-sm-1" style="text-align: center;">
        <button type="submit" class="btn btn-default">Login</button>
      </div>
    </div>
  </form>
@endsection