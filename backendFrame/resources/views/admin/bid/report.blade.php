@extends('admin.layouts.app-dashboard')

@section('title-page', 'Bid Reports')
@section('title', 'Bid Reports')
@section('embed-css')
  @parent
@endsection

@section('nav')
@parent
@endsection
@section('content')
  <div class="content-container">
    <a href="{{ url('/auction-admin/bid/export-all/')}}" class="waves-effect waves-light btn-large blue darken-1 text-white" style="font-size:16px;"><i class="material-icons right">content_paste</i>Export All Data</a>
    <br>
    <br>
    <table class="striped">
      <tr>
        <th>#</th>
        <th>Auction Name</th>
        <th>Status Auction</th>
        <th>Bid Count</th>
        <th>User Count</th>
        <th></th>
      </tr>
      @foreach ($bidHistory as $bid)
      <tr>
        <td>{{$bid->auction_id}}</td>
        <td>{{$bid->auction_name}}</td>
        <td>{{$bid->status}}</td>
        <td>{{$bid->bidCount}}</td>
        <td>{{$bid->userCount}}</td>
        <td><a href="{{url('/auction-admin/bid/report/detail/'.$bid->auction_id )}}">See Detail Report</a></td>
      </tr>
      @endforeach
    </table>
    {{-- {{ $bidHistory }} --}}

  </div>
@endsection
