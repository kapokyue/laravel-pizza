@extends('layout')
@section('title', 'Register')
@section('content')
  <form method="post" class="form-horizontal">
    {!! csrf_field() !!}
    <div class="form-group">
      <label for="account" class="col-sm-offset-2 col-sm-2 control-label">Account</label>

      <div class="col-sm-4">
        <input id="account" type="text" name="account" value="{{ old('account') }}"
               class="form-control" placeholder="User Name"/>
      </div>
    </div>
    <div class="form-group">
      <label for="newPwd" class="col-sm-offset-2 col-sm-2 control-label">Password</label>

      <div class="col-sm-4">
        <input id="newPwd" type="password" name="password"
               class="form-control" placeholder="Password"/>
      </div>
    </div>
    <div class="form-group">
      <label for="confPwd" class="col-sm-offset-2 col-sm-2 control-label">Re-enter Password</label>

      <div class="col-sm-4">
        <input id="confPwd" type="password" name="password_confirmation"
               class="form-control" placeholder="Re-enter Password"/>
      </div>
    </div>
    <div class="form-group">
      <label for="surname" class="col-sm-offset-2 col-sm-2 control-label">Surname</label>

      <div class="col-sm-4">
        <input id="surname" type="text" name="name" value="{{ old('surname') }}"
               class="form-control" placeholder="Surname"/>
      </div>
    </div>
    <div class="form-group">
      <label for="phone" class="col-sm-offset-2 col-sm-2 control-label">Contact Number</label>

      <div class="col-sm-4">
        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
               class="form-control" placeholder="Contact Number"/>
      </div>
    </div>
    <div class="form-group">
      <label for="address" class="col-sm-offset-2 col-sm-2 control-label">Address</label>

      <div class="col-sm-4">
                 <textarea id="address" name="address"
                           class="form-control" placeholder="Address">{{ old('address') }}</textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-5 col-sm-3" style="text-align: center;">
        <button type="submit" class="btn btn-primary pull-right">Submit</button>
        <button type="reset" class="btn btn-warning pull-right" style="margin-right: 10px;">Reset Form</button>
      </div>
    </div>
  </form>
@endsection