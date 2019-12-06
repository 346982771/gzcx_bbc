<!-- 继承layouts模板 -->
@extends('admin.common.admin')

@section('content')
@parent
    <body class="childrenBody">
    <div class="admin-main layui-anim layui-anim-upbit">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>信息列表</legend>
        </fieldset>

        <div class="search">

            <div class="layui-inline">
                <input class="layui-input" name="key" id="key" placeholder="请输入关键字">
            </div>
            <button class="layui-btn" id="search" data-type="reload">搜索</button>
            <a href="{{url('admin/User/index')}}" class="layui-btn">重置</a>
            <div style="clear: both;"></div>
        </div>

        <table class="layui-table" id="list" lay-filter="list"></table>
    </div>


    <script type="text/html" id="action">
        {{--<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>--}}
        {{--<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>--}}
        @{{#  if(d.status == '0'){ }}
        <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="thaw">解冻</a>
        @{{# }else{  }}
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="frozen">冻结</a>
        @{{# } }}
        @{{#  if(d.level == '0'){ }}
        <a class="layui-btn layui-btn-xs" lay-event="level1">授权发帖</a>
        @{{# }else{  }}
        <a class="layui-btn layui-btn-xs  layui-btn-warm" lay-event="level0">取消发帖</a>
        @{{# } }}
    </script>
    <script type="text/html" id="avatar">
        @{{# if(!d.headImg){ }}
        暂无图片
        @{{#  } else { }}
        <img src="@{{d.headImg}}" style="max-width: 30px;max-height: 30px;">
        @{{#  } }}
    </script>

    <script>
        layui.use('table', function(){
            var table = layui.table,form = layui.form, $ = layui.jquery;

            table.render({
                elem: '#list'
                ,url:'{{url("admin/User/index")}}'
                ,method:'post'
                ,cols: [[
                    {field: 'id', align:'center',title: '用户id', width: 90, fixed: true},
                    {field: 'headImg',align:'center', title: '头像', width: 120,toolbar: '#avatar'},
                    {field: 'username',align:'center', title: '昵称', width: 120},
                    {field: 'mobile', align:'center',title: '手机', width: 150},
                    {field: 'email', align:'center',title: '邮箱', width: 150},
                    {field: 'orderScore', align:'center',title: '积分', width: 150},
                    {field: 'created_at',align:'center', title: '注册时间', width: 170},
                    {width: 400,title:'操作',align: 'center', toolbar: '#action'}
                ]]
                ,page: true
                ,limit: {{ config('common.pageSize') }} //每页默认显示的数量
            });

            $('.screen .layui-btn').on('click', function(){
                table.reload('list', {
                    where: { //设定异步数据接口的额外参数，任意设
                        brand: $("#brand").find("option:selected").val(),
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
                        var loading = layer.load(1, {shade: [0.1, '#fff']});
                        $.post('{{url("admin/Car/del")}}',{id:data.id},function(res){
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
                }
                if (obj.event === 'thaw') {
                    layer.confirm('您确定要解冻该用户吗？', function(index){
                        var loading = layer.load(1, {shade: [0.1, '#fff']});
                        $.post('{{url("admin/User/pass")}}',{id:data.id,status:10},function(res){
                            layer.close(loading);
                            if(res.code===1){
                                layer.msg(res.msg,{time:1000,icon:1});
                                table.reload('list');
                            }else{
                                layer.msg('操作失败！',{time:1000,icon:2});
                            }
                        });
                        layer.close(index);
                    });
                }
                if (obj.event === 'frozen') {
                    layer.confirm('您确定要冻结该用户吗？', function(index){
                        var loading = layer.load(1, {shade: [0.1, '#fff']});
                        $.post('{{url("admin/User/pass")}}',{id:data.id,status:0},function(res){
                            layer.close(loading);
                            if(res.code===1){
                                layer.msg(res.msg,{time:1000,icon:1});
                                table.reload('list');
                            }else{
                                layer.msg('操作失败！',{time:1000,icon:2});
                            }
                        });
                        layer.close(index);
                    });
                }
                if (obj.event === 'level1') {
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post('{{url("admin/User/level")}}',{id:data.id,level:1},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            table.reload('list');
                        }else{
                            layer.msg('操作失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                }
                if (obj.event === 'level0') {
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post('{{url("admin/User/level")}}',{id:data.id,level:0},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            table.reload('list');
                        }else{
                            layer.msg('操作失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                }
            });
        });
    </script>
    </body>
@endsection