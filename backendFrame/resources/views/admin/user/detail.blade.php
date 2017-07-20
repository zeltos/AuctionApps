@extends('admin.layouts.app-dashboard')

@section('title-page', 'Detail User')
@section('title', 'Detail User')
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
          <h3>{{ $result[0]['user_name'] }} <a class="waves-effect waves-light btn right" href="#modalEdit" style="font-size:14px;"><i class="material-icons left">cloud</i>Edit Data</a></h3>
        </div>
        <div class="col l12">
          <table class="striped">
            <tr>
              <th><b>Email Address</b></th>
              <td>:</td>
              <td>{{ $result[0]['user_email']}}</td>
            </tr>
            <tr>
              <th><b>Phone Number</b></th>
              <td>:</td>
              <td>{{ $result[0]['user_phone']}}</td>
            </tr>
            <tr>
              <th><b>Birth Date</b></th>
              <td>:</td>
              <td>{{ $result[0]['user_birthdate']}}</td>
            </tr>
            <tr>
              <th><b>Status</b></th>
              <td>:</td>
              <td>
                @if ($result[0]['user_status'] === '1')
                  <div class="chip light-green accent-2">
                    active
                  </div>
                @elseif ($result[0]['user_status'] === '0')
                  <div class="chip">
                    nonactive
                  </div>
                @endif
              </td>
            </tr>
            {{-- <tr>
              <td colspan="3" style="text-align:center;">
                <a href="#">Change Password</a>
              </td>
            </tr> --}}
          </table>
          <br>
          <form action="{{ secure_url('/auction-admin/user/edit/save/'.$result[0]['user_id']) }}" method="post">
            {{ csrf_field() }}
            <div id="modalEdit" class="modal">
              <div class="modal-content">
                <h4>Edit Data User</h4>
                <div class="row">
                  <div class="input-field col l12">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="user_name" name="user_name" type="text" class="validate" value="{{$result[0]['user_name']}}">
                    <label for="icon_prefix">User Name</label>
                  </div>
                  <div class="input-field col l12">
                    <i class="material-icons prefix">email</i>
                    <input id="user_email" name="user_email" type="text" class="validate" value="{{$result[0]['user_email']}}">
                    <label for="icon_prefix">Email Address</label>
                  </div>
                  <div class="input-field col l12">
                    <i class="material-icons prefix">today</i>
                    <input id="user_birthdate" name="user_birthdate" type="text" class="validate" value="{{$result[0]['user_birthdate']}}">
                    <label for="icon_prefix">Birth Date</label>
                    <script type="text/javascript">
                    // $('#user_birthdate').pickadate({
                    //   format: 'yyyy-mm-dd'
                    // });

                    </script>
                  </div>
                  <div class="input-field col l12">
                    <i class="material-icons prefix">phone</i>
                    <input id="user_phone" name="user_phone" type="text" class="validate" value="{{$result[0]['user_phone']}}">
                    <label for="icon_prefix">Phone Number</label>
                  </div>
                  <div class="input-field col l12">
                    <i class="material-icons prefix">nature</i>
                    <select id="status_user" name="status_user">
                       <option value="1" @if($result[0]['user_status']== '1') selected @endif>Active</option>
                       <option value="0" @if($result[0]['user_status']== '0') selected @endif>Nonactive</option>
                       <option value="2" @if($result[0]['user_status']== '2') selected @endif>Disbanend</option>
                     </select>
                     <label>Status User</label>
                    <script type="text/javascript">
                    $(document).ready(function() {
                      $('#status_user').material_select();
                    });
                    </script>
                  </div>
                  <div class="input-field col l12">
                    <i class="material-icons prefix">vpn_key</i>
                    <input id="password" name="password" type="password" class="" value="" placeholder='let blank if no want change password'>
                    <label for="icon_prefix">New Password</label>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">close</a>
                <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">cloud</i>Save Update</button>
              </div>
            </div>
          </form>
          <script type="text/javascript">
          $(document).ready(function(){
            // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
            $('#modalEdit').modal();
          });
          </script>
        </div>
        <div class="col l12">
          <br>
          <h4>History bidding</h4>
          <table class="striped">
            <tr>
              <th>#</th>
              <th>Auction Name</th>
              <th>Bid Value</th>
              <th>bid date</th>
            </tr>
            @foreach ($result[0]['bid_data'] as $bid)
              <tr>
                <td>{{$bid['bid_id']}}</td>
                <td>{{$bid['auction_name']}}</td>
                <td>IDR {{ number_format( $bid['bid_value'] , 0 , '' , '.' ) }}</td>
                <td>{{$bid['created_at']}}</td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
  </div>


@endsection
