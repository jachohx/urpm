@section('title', '后台首页')
@section('content_title', '后台首页')
@section('content_title_small', 'index')
@extends('layouts.admin')
@section('content')
    <div class="box-header">
    <span style="color:red;">
        {{ $role }}
    </span>
    </div>
@endsection