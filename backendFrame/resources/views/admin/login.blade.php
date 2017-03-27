@extends('admin.layouts.app')

@section('title', 'Login Admin')
@section('embed-css')
  @parent
@endsection

@section('content')
  <div class="valign-wrapper login-wrapper">
    <div class="login-container valign">
      <h3 class="center-align">Login Admin</h3>
      <p class="center-align">You need to login to access admin page</p>
      <form action="" method="POST">
        {{ csrf_field() }}
        <div class="row">
          <div class="input-field col l12">
              <input id="email" type="text" name="email" class="validate">
              <label for="email">Email Address</label>
          </div>
          <div class="input-field col l12">
              <input id="password" type="password" name="password" class="validate">
              <label for="password">Password</label>
          </div>
          <div class="col l12">
            <button class="btn waves-effect waves-light" type="submit" name="action">Submit
              <i class="material-icons right">send</i>
            </button>
          </div>
        </div>
    </div>
    </form>
  </div>
@endsection
