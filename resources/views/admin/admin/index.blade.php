<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
@parent
    <body class="childrenBody">
    <div class="admin-main layui-anim layui-anim-upbit">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>用户列表</legend>
        </fieldset>

        <div class="layui-form layui-form-pane">
            <div class="layui-inline screen">
                <div class="layui-inline">
                    <div class="layui-input-inline">
                        <select name="group_id" lay-verify="required" lay-search="group_id" id="group_id">
                            <option value="0">全部</option>
                            @foreach($auth_group as $v)
                                <option value="{{$v['group_id']}}">{{$v['title']}}</option>
                            @endforeach

                        </select>
                    </div>
                    <!--<button class="layui-btn screen " data-type="reload">筛选</button>-->
                </div>
                <button class="layui-btn" id="reload" data-type="reload">筛选</button>
            </div>
        </div>
        <br><br>
        <div class="search">
            <div class="layui-inline">
                <input class="layui-input" name="key" id="key" placeholder="请输入关键字">
            </div>
            <button class="layui-btn" id="search" data-type="reload">搜索</button>
            <a href="{{url('admin/admin/index')}}" class="layui-btn">重置</a>
            <a href="{{url('admin/admin/add')}}"class="layui-btn" style="float:right;">添加用户</a>
            <div style="clear: both;"></div>
        </div>

        <table class="layui-table" id="list" lay-filter="list"></table>
    </div>

    <script type="text/html" id="img">

        @{{# if(!d.img){ }}
        暂无头像
        @{{#  } else { }}
        <img src="@{{d.img}}" style="max-width: 30px;max-height: 30px;">
        @{{#  } }}

    </script>

    <script type="text/html" id="action">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script>
        layui.use('table', function(){
            var table = layui.table,form = layui.form, $ = layui.jquery;

            table.render({
                elem: '#list'
                ,url:'{{url("admin/admin/index")}}'
                ,method:'post'
                ,cols: [[
                    {field:'admin_id', width:80, title: 'ID'},
                    {field: 'img',align:'center', title: '头像', width: 120,toolbar: '#img'},
                    {field: 'loginname',align:'center', title: '登录账号', width: 120},
                    {field: 'username',align:'center', title: '昵称', width: 150},
                    {field: 'mobile', align:'center',title: '手机', width: 150},
                    {field: 'group_title', align:'center',title: '角色', width: 150},
                    {field: 'create_time',align:'center', title: '创建时间', width: 170},
                    {width: 400,align: 'center',title: '操作', toolbar: '#action'}
                ]]
                ,page: true
                ,limit: {{ config('common.pageSize') }} //每页默认显示的数量
            });



            $('.screen .layui-btn').on('click', function(){
                table.reload('list', {
                    where: { //设定异步数据接口的额外参数，任意设
                        group_id: $("#group_id").find("option:selected").val(),
                        key : ''
                    }
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                });
            });

            $('#search').on('click', function(){
                table.reload('list', {
                    where: { //设定异步数据接口的额外参数，任意设
                        key: $('#key').val(),
                        group_id : 0
                    }
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                });
            });
            //监听行工具事件
            table.on('tool(list)', function(obj){
                var data = obj.data;

                if(obj.event === 'del'){
                    layer.confirm('确定要删除吗？', function(index){
                        if(data.admin_id == 1){
                            layer.msg('不能删除总管理员！', {time: 1800, icon: 2});
                            return false;
                        }
                        var loading = layer.load(1, {shade: [0.1, '#fff']});
                        $.post('{{url("admin/admin/del")}}',{id:data.admin_id},function(res){
                            layer.close(loading);
                            if(res.code === 1){
                                layer.msg(res.msg, {time: 1000, icon: 1});
                                obj.del();
                                layer.close(index);
                            }else{
                                layer.msg(res.msg,{time:1000,icon:2});
                            }
                        })

                    });
                }else if(obj.event === 'edit'){
                    location.href = "{{url('admin/admin/edit')}}?id="+data.admin_id;
                }
            });
        });
    </script>
    </body>
@endsection