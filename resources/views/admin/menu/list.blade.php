@section('title', '菜单列表')
@section('content_title', '菜单列表')
@section('content_title_small', '查看')
@section('css')
    <link rel="stylesheet" href="{{ $assets_url }}/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="{{ $assets_url }}/plugins/nestable/nestable.css">
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
            <div class="col-md-5">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">新增</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body" style="display: block;">
                        <form method="POST" id="form" action="/menu" class="form-horizontal" accept-charset="UTF-8" pjax-container="">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="parent_id" class="col-sm-3 control-label">上级菜单</label>
                                    <div class="col-sm-8">
                                        <?php $tab = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>
                                        <select class="form-control" style="width: 100%;" id="parent_id" name="parent_id"
                                                tabindex="-1" aria-hidden="true">
                                            <option value="0">根目录</option>
                                            @foreach ($menus as $item)
                                                <option value="{{  $item['id'] }}">{{ $tab .  $item['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">菜单名</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                            <input type="text" id="title" name="title" value="" class="form-control" placeholder="输入菜单名">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="icon" class="col-sm-3 control-label">图标</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <a href="#" class="btn btn-default"><i class="fa fa-bars" id="menu-icon"></i></a>
                                            <input type="hidden" name="icon" value="fa-bars">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="icon" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div id="iconpicker"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="uri" class="col-sm-3 control-label">链接</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                            <input type="text" id="uri" name="uri" value="" class="form-control" placeholder="输入链接">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="uri" class="col-sm-3 control-label">路由</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <select class="form-control" name="route_key">
                                                <option value="url">URL</option>
                                                <option value="controller">Controller</option>
                                            </select>
                                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                            <input type="text" name="route_value" value="" class="form-control" placeholder="输入规则">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="roles" class="col-sm-3 control-label">权限</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="roles" name="roles[]" multiple="">
                                            <?php foreach($roles as $role) { ?>
                                                <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="roles[]">
                                    </div>
                                </div>

                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-sm-3">
                                </div>
                                <div class="col-sm-3">
                                    <div class="btn-group pull-left">
                                        <button type="submit" class="btn btn-warning pull-right">重置</button>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="btn-group pull-right">
                                        <button type="submit" class="btn btn-info pull-right _submit_" data-form-id="form" data-url="{{ $base_url . '/menu' }}">保存</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-7">
                <div class="box">

                    <div class="box-header">

                        <div class="btn-group">
                            <a class="btn btn-primary menu-tools" data-action="expand-all"><i class="fa fa-plus-square-o"></i>&nbsp;
                                展开
                            </a>
                            <a class="btn btn-primary menu-tools" data-action="collapse-all"><i class="fa fa-minus-square-o"></i>
                                折叠
                            </a>
                        </div>

                        <div class="btn-group">
                            <a class="btn btn-info menu-tree-save"><i class="fa fa-save"></i>
                                保存
                            </a>
                        </div>

                        <div class="btn-group">
                            <a class="btn btn-warning menu-tree-refresh"><i class="fa fa-refresh"></i>
                                刷新
                            </a>
                        </div>
                        <div class="btn-group pull-right">
                            <span class="btn btn-info disabled">辅助显示的权限名</span>
                            <span class="btn btn-primary disabled">可视菜单的角色名</span>
                        </div>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <div class="dd" id="menu-tree">
                            <ol class="dd-list">
                                @foreach($menus as $branch)
                                    @include('admin.menu.tree')
                                @endforeach
                            </ol>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

    </section>

@endsection
@section('js')
    <script src="{{ $assets_url }}/plugins/select2/select2.full.min.js"></script>
    <script src="{{ $assets_url }}/plugins/select2/i18n/zh-CN.js"></script>
    <script src="{{ $assets_url }}/plugins/iconpicker/iconset-fontawesome-4.2.0.min.js"></script>
    <script src="{{ $assets_url }}/plugins/iconpicker/bootstrap-iconpicker.min.js"></script>
    <script src="{{ $assets_url }}/plugins/nestable/jquery.nestable.js"></script>
    <script data-exec-on-popstate>
        $(function () {
            $("#parent_id").select2({allowClear: true});
            $("#roles").select2({allowClear: true});

            $('#menu-tree').nestable({maxDepth:2});
            $('.menu-tools').on('click', function(e){
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });

            $('.menu-tree-save').click(function () {
                var serialize = $('#menu-tree').nestable('serialize');
                $.post('{{ $base_url }}/menu/tree', {'tree':JSON.stringify(serialize)}, function(data){
                    alert(data.msg);
                    location.reload();
                });
            });

            $('.menu-tree-refresh').click(function () {
                location.reload();
            });

            //iconpicker
            var width = $('#iconpicker').parent().parent().width();
            var cols = Math.floor(width / 39);
            $("#iconpicker").iconpicker({
                icon: 'fa-bars',
                rows: 9,
                cols: cols,
                iconset: 'fontawesome',
            });
            $('#iconpicker').on('change', function(e) {
                var icon = e.icon;
                $('#menu-icon').attr('class', '').addClass('fa ' + icon);
                $("input[name='icon']").val(icon);

            });
        });
    </script>
@endsection
@extends('layouts.admin')