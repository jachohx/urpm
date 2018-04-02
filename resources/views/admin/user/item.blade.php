@section('title', "用户管理")
@section('content_title', '用户管理')
@section('content_title_small', isset($item) ? "编辑User Id: $item->id " : "增加")
@section('css')
    <link rel="stylesheet" href="{{ $assets_url}}/plugins/select2/select2.min.css">
@endsection
@section('content')
    <!-- Main content -->
    <section class="content" id="pjax-container">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-body" style="display: block;">
                        <form method="POST" id="form" action="{{ url('/user') }}" class="form-horizontal" accept-charset="UTF-8" pjax-container="">
                            <input type="hidden" name="id" value="{{ isset($item['id']) ? $item['id'] : 0 }}">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="username" class="col-sm-2 control-label">用户名</label>
                                    <div class="col-sm-10">
                                        @if (isset($item))
                                            <input type="text" class="form-control" name="username" value="{{ $item->username }}" readonly>
                                        @else
                                            <input type="text" class="form-control" name="username" value="" >
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">邮箱</label>
                                    <div class="col-sm-10">
                                        @if (isset($item))
                                            <input type="text" class="form-control" name="email" value="{{ $item->email }}" readonly>
                                        @else
                                            <input type="text" class="form-control" name="email" value="" >
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="role" class="col-sm-2 control-label">角色</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="roles[]" title="role" multiple="multiple" id="role-select">
                                            @foreach($roles as $role)
                                                <option
                                                @if(isset($item))
                                                    @foreach($item->roles as $uRole)
                                                        @if($role->id == $uRole->id)
                                                            {{ 'selected' }}
                                                        @endif
                                                    @endforeach
                                                @endif
                                                value="{{ $role->id }}">{{ $role->display_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mobile" class="col-sm-2 control-label">手机号码</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="mobile" name="mobile" value="{{ isset($item) ? $item['mobile'] : '' }}">
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
                                    <label for="password" class="col-sm-2 control-label">密码</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation" class="col-sm-2 control-label">确认密码</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password_confirmation" value="">
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-cancel pull-left" onclick="location='{{ url("/user") }}';">返回</button>
                                <button type="submit" class="btn btn-info pull-right _submit_" data-form-id="form"
                                        data-refresh-url="{{ url("/user") }}">提交</button>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
<script src="{{ $assets_url }}/plugins/select2/select2.full.min.js"></script>
<script src="{{ $assets_url }}/plugins/select2/i18n/zh-CN.js"></script>
<script>
    $(function(){
        $('select').select2({
            placeholder: "角色",
            language: "zh-CN"
        });
    });
</script>
@endsection
@extends('layouts.admin')