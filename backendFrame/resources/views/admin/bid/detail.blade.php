@extends('admin.layouts.app-dashboard')

@section('title-page', 'Report Detail')
@section('title', 'Report Detail')
@section('embed-css')
  @parent
@endsection

@section('nav')
@parent
@endsection
@section('content')
  <div class="content-container">
    @if (count($dataReport) !== 0)
    <div class="row">
      <div class="col l12">
        <h3>{{$dataReport[0]->auction_name}} <a href="{{ secure_url('/auction-admin/bid/export/'.$dataReport[0]->auction_id)}}" class="right waves-effect waves-light btn-large blue darken-1 text-white" style="font-size:16px;"><i class="material-icons right">content_paste</i>Export to Excel</a></h3>
      </div>
      <div class="col l12">
        <table class="striped">
          <tr>
            <th>#</th>
            <th>Bidder Name</th>
            <th>Bidder Email</th>
            <th>Bid Value</th>
            <th>Created at</th>
          </tr>
          @foreach ($dataReport as $index => $report)
          <tr>
            <td>{{$report->bid_id}}</td>
            <td>{{$report->user_name}}</td>
            <td>{{$report->user_email}}</td>
            <td>IDR {{ number_format( $report->bid_value , 0 , '' , '.' ) }}</td>
            <td>{{$report->created_at}}</td>
          </tr>
          @endforeach
        </table>
        {!! $dataReport->links() !!}
      </div>
    </div>
    @else
      <span  class="alert-massage error">No one bid this auction yet...</span>
      <a href="{{ url()->previous() }}" class="waves-effect waves-teal btn-flat  grey darken-3 text-white">Back</a>
    @endif
  </div>
@endsection
