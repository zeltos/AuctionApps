@extends('admin.layouts.app-dashboard')

@section('title-page', 'User Configuration')
@section('title', 'User Configuration')
@section('embed-css')
  @parent
@endsection

@section('nav')
@parent
@endsection
@section('content')
  <div class="content-container">
    <div class="row">
      <div class="col l12">
        @if(session()->has('message.success'))
          <span class="alert-massage success">{{ session()->get('message.success') }}</span>
        @endif
      </div>
      <div class="col l12">
        <div class="cover">
          <table class="striped">
            <thead>
              <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Birthdate</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Has Bid</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($userQ as $user)
              <tr>
                <td>#</td>
                <td><a href="#">{{ $user->user_name }}</a></td>
                <td>{{ $user->user_email }}</td>
                <td>{{ $user->user_birthdate }}</td>
                <td>{{ $user->user_phone }}</td>
                <td>
                  @if ($user->user_status === '1')
                    active
                  @elseif ($user->user_status === '0')
                    nonactive
                  @endif
                </td>
                <td>{{ $user->bidCount }}</td>
                <td>
                  <a href="{{ url('/auction-admin/user/view/'.$user->user_id) }}"><i class="material-icons">border_color</i></a>
                  <a href="{{ url('/auction-admin/user/delete/'.$user->user_id)}}" style="color:red;margin-left:10px;" onclick="return confirm('Are you sure to delete this auction data?');"><i class="material-icons">delete_forever</i></a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
