@section('title', "角色管理")
@section('content_title', '角色管理')
@section('content_title_small', isset($item) ? "编辑Role Id: $item->id" : "增加")
@section('content')
    <!-- Main content -->
    <section class="content" id="pjax-container">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ isset($item) ? '编辑' : '增加' }}</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body" style="display: block;">
                        <form method="POST" id="form" action="{{ url('/role') }}" class="form-horizontal" accept-charset="UTF-8" pjax-container="">
                            <input type="hidden" name="id" value="{{ isset($item['id']) ? $item['id'] : 0 }}">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">角色标识</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" value="{{ isset($item['name']) ? $item['name'] : '' }}" {{ isset($item) ? 'readonly' : '' }}>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="display_name" class="col-sm-2 control-label">角色名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="display_name" value="{{ isset($item['display_name']) ?  $item['display_name'] : '' }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">角色描述</label>
                                    <div class="col-sm-10">
                                        <textarea title="description" name="description" class="form-control">{{ isset($item['description']) ?  $item['description'] : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <?php echo csrf_field(); ?>
                                <button type="button" class="btn btn-cancel pull-left" onclick="location='{{ url("/role") }}';">返回</button>
                                <button type="submit" class="btn btn-info pull-right _submit_" data-form-id="form"
                                        data-refresh-url="{{ url("/role") }}">提交</button>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
@endsection
@extends('layouts.admin')