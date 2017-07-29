@extends('admin.layouts.app-dashboard')

@section('title-page', 'Admin Manager Edit')
@section('title', 'Admin Manager Edit')
@section('embed-css')
  @parent
@endsection

@section('nav')
@parent
@endsection
@section('content')
<?php foreach ($adminData as $data) { ?>
  <div class="content-container">
    <div class="col l12">
      @if(session()->has('message.success'))
        <span class="alert-massage success">{{ session()->get('message.success') }}</span>
      @endif
    </div>
    <form action="{{ secure_url('auction-admin/admin/config/'.$data->admin_id.'/edit/save') }}" method="post">
      {{ csrf_field() }}
      <div class="row">
        <div class="col l12">
          <h4>Info Account</h4>
          <span class="sptr"></span>
        </div>
        <div class="input-field col l6">
         <input placeholder="Placeholder" id="name" name="name" type="text" class="validate" value="{{$data->name}}">
         <label for="name">Admin Name</label>
       </div>
       <div class="input-field col l6">
        <?php if(Auth::user()->admin_id == $data->admin_id || Auth::user()->role_id !== 1){ ?>
         <select  disabled class="select-role">
           <option value="1" <?php if($data->role_id == '1'){echo"selected";} ?>>Super Admin</option>
           <option value="2" <?php if($data->role_id == '2'){echo"selected";} ?>>Admin</option>
         </select>
          <label>Admin Role</label>
         <select  name="role_id" style="display:none;">
           <option value="1" <?php if($data->role_id == '1'){echo"selected";} ?>>Super Admin</option>
           <option value="2" <?php if($data->role_id == '2'){echo"selected";} ?>>Admin</option>
         </select>
         <?php }else{ ?>
           <select name="role_id" class="select-role">
             <option value="1" <?php if($data->role_id == '1'){echo"selected";} ?>>Super Admin</option>
             <option value="2" <?php if($data->role_id == '2'){echo"selected";} ?>>Admin</option>
           </select>
            <label>Admin Role</label>
         <?php } ?>
         <script type="text/javascript">
         $(document).ready(function() {
            $('.select-role').material_select();
          });

         </script>
      </div>
    </div>
    <div class="row">
      <div class="input-field col l6">
        <input placeholder="Admin Email" id="email" type="email" name="email" class="validate" value="{{$data->email}}">
        <label for="email">Admin Email</label>
      </div>
    </div>

    <div class="row">
      <div class="col l12">
        <h4>change Password</h4>
        <p style="color:red;">*NB : let this form blank if you not change your password</p>
        <span class="sptr"></span>
        <div class="input-field col s6">
         <input placeholder="your new password here" name="password" id="password" type="text" class="validate">
         <label for="password">New Password</label>
       </div>
      </div>
      <div class="col l12">
        <span class="sptr"></span>
        <button class="waves-effect waves-light btn-large green darken-1 text-white"><i class="material-icons right">accessibility</i>Save your changes</button>
      </div>
    </div>
    </form>
  </div>

<?php } ?>
@endsection
