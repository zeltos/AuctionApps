@extends('admin.layouts.app-dashboard')

@section('title-page', $auction_name.' - edit')
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
      <form class="col s12">
        <div class="col l8">
          <div class="row">
            <div class="input-field col l6">
              <input required name="auction_name" id="auction_name" type="text" class="validate" value="{{ $auction_name }}">
              <label for="auction_name">Auction Name</label>
            </div>
            <div class="input-field col l6">
              <select id="status-select">
                <option value="live" {{ $status === 'live' ? 'selected' : '' }}>Live</option>
                <option value="cooming" {{ $status === 'cooming' ? 'selected' : '' }}>Cooming Soon</option>
                <option value="closed" {{ $status === 'closed' ? 'selected' : '' }}>Closed</option>
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
              <input required name="start_date" id="start_date" type="date" class="validate" value="{{ $auction_start_date }}">
              <label for="start_date">Start Date</label>
              <script type="text/javascript">
              $('#start_date').pickadate({
                format: 'yyyy-mm-dd'
              });

              </script>
            </div>
            <div class="input-field col l6">
              <input required name="end_date" id="end_date" type="date" class="validate" value="{{ $auction_end_date }}">
              <label for="end_date">End Date</label>
              <script type="text/javascript">
                $('#end_date').pickadate({
                  format: 'yyyy-mm-dd'
                });
              </script>
            </div>
            <div class="input-field col l6">
              <input required name="start_bid" id="start_bid" type="text" class="validate" value="{{ $auction_start_bidding }}">
              <label for="start_bid">Auction Start Bidding</label>
            </div>
            <div class="input-field col l6">
              <input required name="max_bid" id="max_bid" type="text" class="validate" value="{{ $auction_max_bid }}">
              <label for="max_bid">Auction Max Bid</label>
            </div>
            <div class="file-field input-field col l6">
              <div class="btn">
                <span>File</span>
                <input type="file" value="{{ $auction_logo }}">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Auction Logo" value="{{ $auction_logo }}">
              </div>
            </div>
          </div>
          <div class="col l12">
            <label for="short_description">Short Description</label>
            <textarea id="short_description" name="short_desc" class="materialize-textarea" data-length="120" placeholder="Short description of your auction">{{ $auction_short_description }}</textarea>
          </div>
          <div class="col l12">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="materialize-textarea" placeholder="Detail description of your auction">{{ $auction_description }}</textarea>
          </div>
          <div class="col l12">
            <label for="term_cond">Term & Condition</label>
            <textarea id="term_cond" name="term_cond" class="materialize-textarea" placeholder="Term and Conditon of this auction">{{ $auction_term_condition }}</textarea>
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
          <div class="list-images-gallery">

          </div>
        </div>
      </form>
    </div>
  </div>
  @include('admin.module.gallery')
@endsection
