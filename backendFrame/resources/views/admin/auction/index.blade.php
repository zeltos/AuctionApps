@extends('admin.layouts.app-dashboard')

@section('title-page', 'Auction Configuration')
@section('title', 'Auction Configuration')
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
        <a href="{{ secure_url('/auction-admin/auction/new')}}" class="waves-effect waves-light btn-large blue darken-1 text-white"><i class="material-icons right">gavel</i>Add New Auction</a>
        <span class="sptr"></span>
        <div class="cover">
          <table class="striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Auction Name</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Max Per Bid</th>
                <th>Start Bidding</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($auctionQ as $auction)
              <tr>
                <td>#</td>
                <td><a href="#">{{ $auction->auction_name }}</a></td>
                <td>
                  @if ($auction->status == 'closed')
                    <span style="color:red;">{{ $auction->status }}</span>
                  @elseif ($auction->status == 'live')
                    <span style="color:green;">{{ $auction->status }}</span>
                  @else
                    <span>{{$auction->status}}</span>        
                  @endif
                </td>
                <td>{{ $auction->auction_start_date }}</td>
                <td>{{ $auction->auction_end_date }}</td>
                <td>IDR {{ number_format( $auction->auction_max_bid , 0 , '' , '.' ) }}</td>
                <td>IDR {{ number_format( $auction->auction_start_bidding , 0 , '' , '.' ) }}</td>
                <td>
                  <a href="{{ secure_url('/auction-admin/auction/config/'.$auction->auction_id.'/edit') }}"><i class="material-icons">border_color</i></a>
                  <a href="{{ secure_url('/auction-admin/auction/delete/'.$auction->auction_id)}}" style="color:red;margin-left:10px;" onclick="return confirm('Are you sure to delete this auction data?');"><i class="material-icons">delete_forever</i></a>
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
