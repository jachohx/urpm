@section('title', "角色管理")
@section('content_title', '角色管理')
@section('content_title_small', "$role->display_name $role->name")
@section('css')
    <link rel="stylesheet" href="{{ $assets_url ."/plugins/iCheck/all.css" }}">
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form id="form" action="{{ url("/role/" . $role['id'] . "/permission") }}" method="post">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">
                                <?php echo $role->display_name; ?>
                                <small><?php echo $role->name; ?></small>
                            </h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered text-center">
                                <tr class="active">
                                    <th><input type="checkbox" class="minimal" id="selectAll"></th>
                                    <th>序号</th>
                                    <th>角色标识</th>
                                    <th>角色名称</th>
                                    <th>角色描述</th>
                                </tr>
                                @foreach($pager as $item)
                                <tr>
                                    <td><input <?php foreach($role->perms as $perm) if($perm->id == $item->id) echo 'checked';  ?> type="checkbox" class="minimal checkitem" name="perms[]" value="{{ $item->id }}"></td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->display_name }}</td>
                                    <td>{{ str_limit($item->description, 30) }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-info pull-right _submit_" data-refresh-url="{{ url('/role')}}" data-form-id="form">保存</button>
                        </div>
                    </div>
                </form>
                <!-- /.box -->
            </div>
            <!-- /.col (right) -->
        </div>
        <!-- /.row -->
    </section>
@endsection
@section('js')
    <script src="{{ $assets_url }}/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function(){
            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });

            //多选删除
            $('#selectAll').on('ifChecked', function (event) {
                var checkboxes = $('.checkitem');
                var len = checkboxes.length;
                var cb;
                for(var i = 0; i < len; i++)
                {
                    cb = checkboxes[i];
                    if(false == $(cb).is(':checked'))
                    {
                        $(cb).iCheck('check');
                    }
                }
            });

            $('#selectAll').on('ifUnchecked', function (event) {
                var checkboxes = $('.checkitem');
                var len = checkboxes.length;
                var cb;
                for(var i = 0; i < len; i++)
                {
                    cb = checkboxes[i];
                    if(true == $(cb).is(':checked'))
                    {
                        $(cb).iCheck('uncheck');
                    }
                }
            });
        });
    </script>
@endsection
@extends('layouts.admin')