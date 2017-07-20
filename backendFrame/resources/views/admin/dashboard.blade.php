@extends('admin.layouts.app-dashboard')

@section('title-page', 'Admin Dasboard')
@section('title', 'Admin Dasboard')
@section('embed-css')
  @parent
@endsection

@section('nav')
@parent
@endsection
@section('content')
<div class="content-container">
<h4>Welcome to Dasboard</h4>
<p>didalam halaman ini kita bisa mengolah data-data yang berhubungan dengan aplikasi ini. selamat berkarya!</p>
</div>
@endsection
