@extends('admin.layouts.app-dashboard')

@section('title-page', 'New Auction')
@section('title', 'New Auction')
@section('embed-css')
  @parent
@endsection

@section('nav')
@parent
@endsection

@section('content')
  <div class="content-container">
    <div class="row">
      <form class="col s12" action="{{ url('/auction-admin/auction/new/save') }}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="auction_id">
        <div class="col l8">
          <div class="row">
            <div class="input-field col l6">
              <input required name="auction_name" id="auction_name" type="text" class="validate">
              <label for="auction_name">Auction Name</label>
            </div>
            <div class="input-field col l6">
              <select id="status-select" name="status">
                <option value="live">Live</option>
                <option value="cooming">Cooming Soon</option>
                <option value="closed">Closed</option>
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
              <input required name="start_date" id="start_date" type="date" class="validate">
              <label for="start_date">Start Date</label>
              <script type="text/javascript">
              $('#start_date').pickadate({
                format: 'yyyy-mm-dd'
              });

              </script>
            </div>
            <div class="input-field col l6">
              <input required name="end_date" id="end_date" type="date" class="validate">
              <label for="end_date">End Date</label>
              <script type="text/javascript">
                $('#end_date').pickadate({
                  format: 'yyyy-mm-dd'
                });
              </script>
            </div>
            <div class="input-field col l6">
              <input required name="start_bid" id="start_bid" type="text" class="validate">
              <label for="start_bid">Auction Start Bidding</label>
            </div>
            <div class="input-field col l6">
              <input required name="max_bid" id="max_bid" type="text" class="validate">
              <label for="max_bid">Auction Max Bid</label>
            </div>
            <div class="file-field input-field col l6">
              <div class="btn">
                <span>Logo Auction</span>
                <input type="file" name="logo">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Auction Logo">
              </div>
            </div>
          </div>
          <div class="col l12">
            <label for="short_description">Short Description</label>
            <textarea id="short_description" name="short_desc" class="materialize-textarea" data-length="120" placeholder="Short description of your auction"></textarea>
          </div>
          <div class="col l12">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="materialize-textarea" placeholder="Detail description of your auction"></textarea>
          </div>
          <div class="col l12">
            <label for="term_cond">Term & Condition</label>
            <textarea id="term_cond" name="term_cond" class="materialize-textarea" placeholder="Term and Conditon of this auction"></textarea>
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
