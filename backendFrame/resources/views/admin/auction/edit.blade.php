@extends('admin.layouts.app-dashboard')

@section('title-page', $result['data_auction']->auction_name.' - edit')
@section('title', 'Auction edit')
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
      <form class="col s12" action="{{ url('/auction-admin/auction/config/'.$result['data_auction']->auction_id.'/edit/save') }}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <input type="hidden" value="{{$result['data_auction']->auction_id}}" name="auction_id">
        <div class="col l8">
          <div class="row">
            <div class="input-field col l6">
              <input required name="auction_name" id="auction_name" type="text" class="validate" value="{{  $result['data_auction']->auction_name }}">
              <label for="auction_name">Auction Name</label>
            </div>
            <div class="input-field col l6">
              <select id="status-select" name="status">
                <option value="live" {{ $result['data_auction']->status === 'live' ? 'selected' : '' }}>Live</option>
                <option value="cooming" {{ $result['data_auction']->status === 'cooming' ? 'selected' : '' }}>Cooming Soon</option>
                <option value="closed" {{ $result['data_auction']->status === 'closed' ? 'selected' : '' }}>Closed</option>
              </select>
              <label>Status Auction</label>
              <script type="text/javascript">
                jQuery(document).ready(function() {
                  $('#status-select').material_select();
                });
              </script>
            </div>
          </div>
          <div class="row">
            <div class="input-field col l6">
              <input required name="start_date" id="start_date" type="date" class="validate" value="{{ $result['data_auction']->auction_start_date }}">
              <label for="start_date">Start Date</label>
              <script type="text/javascript">
              $('#start_date').pickadate({
                format: 'yyyy-mm-dd'
              });

              </script>
            </div>
            <div class="input-field col l6">
              <input required name="end_date" id="end_date" type="date" class="validate" value="{{ $result['data_auction']->auction_end_date }}">
              <label for="end_date">End Date</label>
              <script type="text/javascript">
                $('#end_date').pickadate({
                  format: 'yyyy-mm-dd'
                });
              </script>
            </div>
            <div class="input-field col l6">
              <input required name="start_bid" id="start_bid" type="text" class="validate" value="{{ $result['data_auction']->auction_start_bidding }}">
              <label for="start_bid">Auction Start Bidding</label>
            </div>
            <div class="input-field col l6">
              <input required name="max_bid" id="max_bid" type="text" class="validate" value="{{ $result['data_auction']->auction_max_bid }}">
              <label for="max_bid">Auction Max Bid</label>
            </div>
            <div class="file-field input-field col l6">
              <div class="btn">
                <span>Logo Auction</span>
                <input type="file" value="{{ $result['data_auction']->auction_logo }}" name="logo">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Auction Logo" value="{{ $result['data_auction']->auction_logo }}">
              </div>
            </div>
          </div>
          <div class="col l12">
            <label for="short_description">Short Description</label>
            <textarea id="short_description" name="short_desc" class="materialize-textarea" data-length="120" placeholder="Short description of your auction">{{ $result['data_auction']->auction_short_description }}</textarea>
          </div>
          <div class="col l12">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="materialize-textarea" placeholder="Detail description of your auction">{{ $result['data_auction']->auction_description }}</textarea>
          </div>
          <div class="col l12">
            <label for="term_cond">Term & Condition</label>
            <textarea id="term_cond" name="term_cond" class="materialize-textarea" placeholder="Term and Conditon of this auction">{{ $result['data_auction']->auction_term_condition }}</textarea>
          </div>
          <div class="col l12">
            <br>
            <button class="waves-effect waves-light btn-large green darken-1 text-white"><i class="material-icons right">gavel</i>Save your changes</button>
          </div>
        </div>
        <div class="col l4">
          <p style="margin:0;"><b>Auction Images Gallery</b></p>
          <span class="sptr"></span>
          <a href="#gallery-modal" class="waves-effect waves-light btn-large grey darken-4 cover"><i class="material-icons left">library_add</i>Add Image from gallery</a>
          <hr>
          <div class="list-images-gallery row">
            @foreach ($result['image_gallery'] as $image)
              <div class="col l6 gallery-item" image-id="{{$image->images_id }}">
                <span class="deleteGallery" onclick="removeAuctionImage({{$image->images_id}})"><i class='material-icons'>delete</i></span>
                <input type="hidden" name="images_id[]" value="{{$image->images_id }}">
                <img src="{{URL::asset('/images/')}}/{{$image->images}}" style="width:100%;">
              </div>
            @endforeach
          </div>
          <script type="text/javascript">
            function removeAuctionImage(id) {

              $('.gallery-item').each(function(index, el) {
                  var imageId = $(this).attr('image-id');
                  if (imageId == id) {
                    $(this).remove();
                  }
              });
              hasInserted();
            }
          </script>
        </div>
      </form>
    </div>
  </div>
  @include('admin.module.gallery')
@endsection
