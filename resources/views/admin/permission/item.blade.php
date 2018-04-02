@section('title', "权限管理")
@section('content_title', '权限列表')
@section('content_title_small',  isset($item) ? "编辑 Permission Id: $item->id" : "增加")
@section('css')
    <link rel="stylesheet" href="{{ $assets_url }}/plugins/select2/select2.min.css">
    <style>
        .select2-container .select2-selection--single{
            height: 32px;
        }
    </style>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
<!-- Horizontal Form -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ isset($item) ? '编辑' : '增加' }}</h3>
            <div class="box-tools pull-right">
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <!-- form start -->
        <form id="form" class="form-horizontal" action="{{ url('/permission') }}" method="post">
            <input type="hidden" name="id" value="{{ isset($item) ? $item['id'] : 0 }}" />
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">权限标识</label>
                    <div class="col-sm-10">
                        @if (isset($item))
                        <input type="text" class="form-control" name="name" value="{{ $item['name'] }}" readonly>
                        @else
                        <input type="text" class="form-control" name="name" value="" >
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="display_name" class="col-sm-2 control-label">权限名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="display_name" value="{{ isset($item) ? $item['display_name'] : '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">权限描述</label>
                    <div class="col-sm-10">
                        <textarea title="description" name="description" class="form-control">{{ isset($item) ?  $item['description'] : '' }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">权限controllers</label>
                    <div class="col-sm-10">
                        <textarea title="description" name="controllers" class="form-control">{{ isset($item) ?  $item['controllers'] : '' }}</textarea>
                        <p class="text-muted">格式是Controller@method，多个以英文 <b>;</b> 隔开。<br>
                            Controller，如App\Http\Controllers\MenuController，也可以简写为MenuController；<br>
                            method，可以是get/post，也可以是controller类的方法。
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="role" class="col-sm-2 control-label">角色</label>
                    <div class="col-sm-10">
                    <?php $roleIds = isset($item) ? $item->roleToIds() : [];?>
                            <select class="form-control" name="roles[]" title="role" multiple="multiple" id="roles">
                            @foreach($roles as $role) { ?>
                            <option value="{{ $role['id'] }}" {{ (in_array($role->id, $roleIds)) ? 'selected' : '' }}>{{ $role['display_name'] }}</option>
                            @endforeach
                        </select>
                        <p class="text-muted">拥有权限的角色。</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">菜单</label>
                    <div class="col-sm-10">
                    <?php $tab = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?>
                    <?php $memuIds = isset($item) ? $item->menuToIds() : [];?>
                        <select class="form-control" name="menus" id="menus">
                            <option value="0">根目录</option>
                            {{--一级目录--}}
                            @foreach ($menus as $_item)
                            <option value="{{ $_item['id'] }}" {{ (isset($menu['parent_id']) && $menu['parent_id'] == $_item['id']) ? 'selected' : '' }}>
                                {{ $tab . (!empty($_item['trans']) ? trans('menu.'.$_item['trans']) :$_item['title']) }}
                            </option>
                            @if(isset($_item['children']))
                            {{--二级目录--}}
                            @foreach ($_item['children'] as $childItem)
                            <option value="{{ $childItem['id'] }}" {{ in_array($childItem['id'], $memuIds) ? 'selected' : '' }}>
                                {{  $tab . $tab . (!empty($childItem['trans']) ? trans('menu.'.$childItem['trans']) :$childItem['title']) }}
                            </option>
                            @endforeach
                            @endif
                            @endforeach
                        </select>
                        <p class="text-muted">绑定菜单，辅助作用，无权限效果，在菜单管理上显示。</p>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            <?php echo csrf_field(); ?>
                <button type="button" class="btn btn-cancel pull-left" onclick="location='{{ url("/permission") }}';">返回</button>
                <button type="submit" class="btn btn-success pull-right _submit_" data-form-id="form"
                        data-refresh-url="{{ url("/permission") }}">提交</button>
            </div>
        <!-- /.box-footer -->
        </form>
    </div>
<!-- /.box -->
</section>

@endsection
@section('js')
<script src="{{ $assets_url }}/plugins/select2/select2.full.min.js"></script>
<script src="{{ $assets_url }}plugins/select2/i18n/zh-CN.js"></script>
<script data-exec-on-popstate>
    $(function () {
        $("#roles").select2({allowClear: true});
        $("#menus").select2({allowClear: true});
    });
</script>
@endsection
@extends('layouts.admin')