@section('title', "日志管理")
@section('content_title', '登录日志')
@section('content_title_small',  $pager->total())
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header width-border">
                        <h3 class="box-title">搜索</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <form action="{{ url('loginLog/list') }}" method="get">
                                <div class="form-group col-lg-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">创建时间</div>
                                        <input type="text" class="form-control datepicker" name="startTime" id="startTime" value="{{ Input::get('startTime','') }}">
                                        <div class="input-group-addon">至</div>
                                        <input type="text" class="form-control datepicker" name="endTime" id="endTime" value="{{ Input::get('endTime','') }}">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-default">搜索</button>
                                    <button type="button" style="margin-left:5px;" class="btn btn-default" onclick="location.href='{{ url('log/list') }}'">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">日志管理</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered text-center">
                            <tr>
                                <th width="100px">ID</th>
                                <th width="150px">用户名</th>
                                <th>角色名</th>
                                <th>ip</th>
                                <th width="150px">登录时间</th>
                            </tr>
                            <?php
                                if(true == isset($pager)) {
                                    foreach ($pager as $item) {
                                        ?>
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ isset($item->user) ? str_replace(Input::get('userName',''), "<span style=\"color: red\">" . Input::get('userName','') . "</span>", $item->user->username) : '用户已删除（'.$item->user_id.')' }}</td>
                                            <td>@if(isset($item->user) && isset($item->user->roles))
                                                @foreach($item->user->roles as $role)
                                                {{ $role['display_name'] }} <br/>
                                                @endforeach
                                                @endif
                                            </td>
                                            <td>{{ $item->ips}}</td>
                                            <td>{{ $item->created_at }}</td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                        </table>
                    </div>
                    @include('admin.common.pager')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ $assets_url }}/plugins/datepicker/datepicker3.css">
    <style>
        .disabled.day {
            color: #ddd !important;
        }
    </style>
@endsection
@section('js')
    <script src="{{ $assets_url }}/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script>
        $.fn.datepicker.dates['zh-CN'] = {
            days: ["星期天", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
            daysShort: ["日", "一", "二", "三", "四", "五", "六", "日"],
            daysMin: ["日", "一", "二", "三", "四", "五", "六", "日"],
            months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            today: "今天",
            clear: "清除",
        }
        $(".datepicker").datepicker(
            {
                format: "yyyy-mm-dd",
                language: 'zh-CN',
                todayHighlight: true,
                autoclose: true,
        }
        );
        $("#startTime").change(function () {
            $(".datepicker").datepicker('setStartDate' , $("#startTime").val());
        });
        $("#endTime").change(function () {
            $(".datepicker").datepicker('setEndDate' , $("#endTime").val());
        });
    </script>
@endsection
@extends('layouts.admin')