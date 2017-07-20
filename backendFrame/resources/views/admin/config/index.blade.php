@extends('admin.layouts.app-dashboard')

@section('title-page', 'Admin Manager')
@section('title', 'Admin Manager')
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
          @if (Auth::user()->role_id == 1)
            <a href="#add-admin" class="waves-effect waves-light btn-large blue darken-1 text-white"><i class="material-icons right">accessibility</i>Add New Admin</a>
          @endif
          <form action="{{ secure_url('auction-admin/admin/add/save') }}" method="POST">
            {{ csrf_field() }}
            <div id="add-admin" class="modal">
               <div class="modal-content">
                 <h4>Add New Admin</h4>
                 <p>* Only Super Admin can access this facility.</p>
                 <div class="row" style="margin:0;">
                   <div class="input-field col s6">
                      <i class="material-icons prefix">account_circle</i>
                      <input id="admin_name" name="name" type="text" class="validate">
                      <label for="admin_name">Full Name</label>
                   </div>
                   <div class="input-field col s6">
                      <i class="material-icons prefix">email</i>
                      <input id="admin_email" name="email" type="text" class="validate">
                      <label for="admin_email">Email Address</label>
                   </div>
                   <div class="input-field col s6">
                      <i class="material-icons prefix">vpn_key</i>
                      <input id="admin_password" name="password" type="password" class="validate">
                      <label for="admin_password">Password</label>
                   </div>
                   <div class="input-field col s6">
                     <select name="role">
                       <option value="" disabled selected>Choose your option</option>
                       <option value="1">Super Admin</option>
                       <option value="2">Admin</option>
                     </select>
                     <label>Materialize Select</label>
                     <script type="text/javascript">
                     $(document).ready(function() {
                      $('select').material_select();
                    });
                     </script>
                   </div>
                 </div>
               </div>
               <div class="modal-footer">
                 <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">close</a>
                 <button type="submit" class="waves-effect waves-light btn" href="#modal1">Save</button>
               </div>
            </div>
          </form>
          <script type="text/javascript">
          $(document).ready(function(){
           // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
           $('#add-admin').modal();
          });
          </script>
          <br>
          <br>
      </div>
      <div class="col l12">
        <table>
          <tr>
            <th>#</th>
            <th>Admin Name</th>
            <th>Admin Email</th>
            <th>Admin Role</th>
            <th></th>
          </tr>
          @foreach ($adminData as $key => $admin)
          <tr>
            <td>{{$admin->admin_id}}</td>
            <td>{{$admin->name}}</td>
            <td>{{$admin->email}}</td>
            <td>{{$admin->role_name}}</td>
            <td>
                <a href="{{ secure_url('/auction-admin/auction/config/'.$admin->admin_id.'/edit') }}"><i class="material-icons">border_color</i></a>
              @if ($admin->admin_id !== Auth::user()->admin_id || $admin->role_id !== 1)
                <a href="{{ secure_url('/auction-admin/auction/delete/'.$admin->admin_id)}}" style="color:red;margin-left:10px;" onclick="return confirm('Are you sure to delete this auction data?');"><i class="material-icons">delete_forever</i></a>
              @endif
            </td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
@endsection
