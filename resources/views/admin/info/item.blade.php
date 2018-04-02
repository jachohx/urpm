@section('title', "用户信息")
@section('content_title', '用户信息')
@section('content_title_small', "User Id: $item->id")
@section('content')
    <!-- Main content -->
    <section class="content">
    <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">用户信息</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="form" class="form-horizontal" action="{{ url('/info') }}" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">用户名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" value="{{ $item->username }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">邮箱</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="email" value="{{ $item->email }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile" class="col-sm-2 control-label">手机号码</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="mobile" value="{{ isset($item) ? $item['mobile'] : '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sex" class="col-sm-2 control-label">性别</label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" name="sex" value="1" checked>男
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="sex" value="2" {{ isset($item) && $item['sex'] == 2 ? 'checked' : '' }}>女
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="old_password" class="col-sm-2 control-label">原密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="old_password" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">新密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="col-sm-2 control-label">确认新密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password_confirmation" value="">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right _submit_" data-form-id="form"
                            data-refresh-url="{{ url("/") }}">提交</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </section>
@endsection
@extends('layouts.admin')