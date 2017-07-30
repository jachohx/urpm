@section('title', '菜单列表')
@section('content_title', '菜单列表')
@section('content_title_small', '查看')
@section('css')
    <link rel="stylesheet" href="{{ $assets_url }}/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="{{ $assets_url }}/plugins/nestable/nestable.css">
    {{--<link rel="stylesheet" href="{{ $assets_url }}/plugins/iconpicker/icon-picker.min.css">--}}
    <link rel="stylesheet" href="{{ $assets_url }}/plugins/iconpicker/bootstrap-iconpicker.min.css">
    <style>
        .select2-container .select2-selection--single{
            height: 32px;
        }
    </style>
@endsection
@section('content')
    <!-- Main content -->
    <section class="content" id="pjax-container">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">编辑</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body" style="display: block;">
                        <form method="POST" id="form" action="{{ url('/menu') }}" class="form-horizontal" accept-charset="UTF-8" pjax-container="">
                            <input type="hidden" name="id" value="{{ isset($menu['id']) ? $menu['id'] : 0 }}">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="parent_id" class="col-sm-2 control-label">上级菜单</label>
                                    <div class="col-sm-10">
                                        <?php $tab = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>
                                        <select class="form-control" style="width: 100%;" id="parent_id" name="parent_id"
                                                tabindex="-1" aria-hidden="true">
                                            <option value="0">根目录</option>
                                            @foreach ($menus as $item)
                                                <option value="{{  $item['id'] }}" {{ (isset($menu['parent_id']) && $menu['parent_id'] == $item['id']) ? 'selected' : ''}}>{{ $tab .  $item['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">菜单名</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                            <input type="text" id="title" name="title" value="{{ $menu['title'] }}" class="form-control" placeholder="输入菜单名">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="icon" class="col-sm-2 control-label">图标</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <a href="#" class="btn btn-default"><i class="fa {{ $menu['icon'] }}" id="menu-icon"></i></a>
                                            <input type="hidden" name="icon" value="{{ $menu['icon'] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="icon" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div id="iconpicker"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="uri" class="col-sm-2 control-label">链接</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                            <input type="text" id="uri" name="uri" value="{{ $menu['uri'] }}" class="form-control" placeholder="输入链接">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="uri" class="col-sm-2 control-label">路由</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <select class="form-control" name="route_key">
                                                <option value="url">URL</option>
                                                <option value="controller" {{ isset($menu["routes"]) ? (explode(":", $menu["routes"])[0] == 'controller' ? 'selected' : '') : '' }}>Controller</option>
                                            </select>
                                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                            <input type="text" name="route_value" value="{{ isset($menu["routes"]) ? (explode(":", $menu["routes"])[1]) : '' }}" class="form-control" placeholder="输入规则">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="roles" class="col-sm-2 control-label">权限</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="roles" name="roles[]" multiple="">
                                            <?php foreach($roles as $role) { ?>
                                                <option value="{{ $role->id }}" {{ (isset($menu['roleIds']) && in_array($role->id, $menu['roleIds'])) ? 'selected' : '' }}>{{ $role->display_name }}</option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="roles[]">
                                    </div>
                                </div>

                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-2">
                                    <div class="btn-group pull-left">
                                        <button type="submit" class="btn btn-warning pull-right">重置</button>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="btn-group pull-right">
                                        <button type="submit" class="btn btn-info pull-right _submit_" data-form-id="form" data-refresh-url="{{ url('/menu') }}">保存</button>
                                    </div>
                                </div>

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
    <!--<script src="{{ $assets_url }}/plugins/iconpicker/iconPicker.min.js"></script>-->
    <script src="{{ $assets_url }}/plugins/iconpicker/iconset-fontawesome-4.2.0.min.js"></script>
    <script src="{{ $assets_url }}/plugins/iconpicker/bootstrap-iconpicker.min.js"></script>
    <!-- <script src="{{ $assets_url }}/plugins/iconpicker/iconset-glyphicon.min.js"></script> -->
    <script src="{{ $assets_url }}/plugins/nestable/jquery.nestable.js"></script>
    <script data-exec-on-popstate>
        $(function () {
            $("#parent_id").select2({allowClear: true});
            $("#roles").select2({allowClear: true});
        });
    </script>
    <script>
        $("#iconpicker").iconpicker({
            icon: '{{ $menu['icon'] }}',
            rows: 9,
            cols: 9,
            iconset: 'fontawesome',
            labelHeader: '{0} / {1} 页',
            labelFooter: '{0} - {1} / {2} 个图标',
        });
        $('#iconpicker').on('change', function(e) {
            var icon = e.icon;
            $('#menu-icon').attr('class', '').addClass('fa ' + icon);
            $("input[name='icon']").val(icon);

        });
    </script>
@endsection
@extends('layouts.admin')