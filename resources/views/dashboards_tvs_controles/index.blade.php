@extends('layouts.master')

@section('title')
{{ session('crudNameSubmodulo') }}
@endsection

@section('topbar_title')
{{ session('crudNameSubmodulo') }}
@endsection

@section('content')

<!-- Form -->
@include('dashboards_tvs_controles.form')
@endsection

@section('script')
    <!-- scripts_dashboards_tvs_controles.js -->
    <script src="{{ asset('assets/js/scripts_dashboards_tvs_controles.js')}}"></script>
@endsection

@section('script-bottom')
@endsection