@section('title', '后台首页')
@section('content_title', '后台首页')
@section('content_title_small', 'index')
@extends('layouts.admin')
@section('content')
    @if (Session::has('msg'))
    <div class="box-header">
        <span style="color:red;">
            {{ Session::get('msg') }}
        </span>
    </div>
    @endif
@endsection