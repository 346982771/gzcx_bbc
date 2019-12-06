<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
@parent
    <body class="childrenBody">
    <div class="admin-main layui-anim layui-anim-upbit">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>信息列表</legend>
        </fieldset>


        <div class="search layui-form">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input class="layui-input" name="key" id="key" placeholder="请输入关键字">
                </div>
                <div class="layui-form-mid ">关键字</div>

            </div>
            <div class="layui-inline" style="margin-left: 15px">
                <div class="layui-input-inline">
                    <select name="status1" lay-verify="required" lay-search="" id="status1">
                        <option value="-1">全部</option>
                        <option value="0">待审核</option>
                        <option value="1">审核通过</option>
                        <option value="2">拒绝</option>

                    </select>
                </div>
                <div class="layui-form-mid ">状态</div>
            </div>
            <button class="layui-btn" id="search" data-type="reload">搜索</button>
            <a href="{{url('admin/News/index')}}" class="layui-btn">重置</a>
            <a href="{{url('admin/News/add')}}"class="layui-btn" style="float:right;">添加信息</a>
            <div style="clear: both;"></div>
        </div>

        <table class="layui-table" id="list" lay-filter="list"></table>
    </div>


    <script type="text/html" id="action">
        {{--<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>--}}
        <a class="layui-btn layui-btn-xs" lay-event="look">查看</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        <a class="layui-btn layui-btn-xs" lay-event="topping">置顶</a>
        @{{# if(d.status == 0){ }}
        <a class="layui-btn layui-btn-xs" lay-event="status1">通过审核</a>
        <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="status2">拒绝审核</a>
        @{{#  } }}
        @{{# if(d.status != 0){ }}
        <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="status0">恢复待审核</a>
        @{{#  } }}

    </script>
    <script type="text/html" id="hide">
        <input type="checkbox" name="hide" value="@{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="hide" @{{ d.hide == 0 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="is_draft">
        <input type="checkbox" name="is_draft" value="@{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="is_draft" @{{ d.is_draft == 1 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="order">
        <input name="@{{d.id}}" data-id="@{{d.id}}" class="list_order layui-input" value=" @{{d.sort}}" size="10"/>
    </script>
    <script type="text/html" id="status">
        @{{# if(d.status == 0){ }}
        待审核
        @{{#  } else if(d.status == 1){ }}
        审核通过
        @{{#  } else if(d.status == 2){ }}
        已拒绝
        @{{#  } }}
    </script>
    <script type="text/html" id="headImg">
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
                ,url:'{{url("admin/News/index")}}'
                ,method:'post'
                ,cols: [[
                    {field:'id', width:80, title: 'ID'},
                    {field: 'title',align:'left', title: '标题', width: 200},
                    //{field: 'topic_name',align:'left', title: '话题', width: 200},
                    {field: 'hide',align: 'center', title: '显示', width: 150,toolbar: '#hide'},
                    {field: 'status',align: 'center', title: '状态', width: 150,toolbar: '#status'},
                    {field: 'is_draft',align: 'center', title: '草稿', width: 150,toolbar: '#is_draft'},
                    {field: 'username',align:'center', title: '用户昵称', width: 150},
                    {field: 'headImg',align:'center', title: '用户头像', width: 150,toolbar: '#headImg'},
                    {field: 'create_time',align:'center', title: '创建时间', width: 170},
                    {width: 400,align: 'center',title: '操作', toolbar: '#action'}
                ]]
                ,page: true
                ,limit: {{ config('common.pageSize') }} //每页默认显示的数量
            });

            table.on('edit(list)', function(obj){
                var value = obj.value //得到修改后的值
                        ,data = obj.data //得到所在行所有键值
                        ,field = obj.field; //得到字段
                //layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
                $.post('{{url("admin/News/sort")}}',{id:data.id,sort:value},function(res){
                    if(res.code==1){
                        layer.msg(res.msg,{time:1000,icon:1});
                    }else{
                        layer.msg(res.msg,{time:1000,icon:2});
                    }
                })

            });


            $('#search').on('click', function(){
                table.reload('list', {
                    where: { //设定异步数据接口的额外参数，任意设
                        key: $('#key').val(),
                        status : $('#status1 option:selected').val()
                    }
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                });
            });
            form.on('switch(is_draft)', function(obj){
                loading =layer.load(1, {shade: [0.1,'#fff']});
                var id = this.value;
                var is_draft = obj.elem.checked===true?1:0;
                $.post('{{url("admin/News/isDraft")}}',{'id':id,'is_draft':is_draft},function (res) {
                    layer.close(loading);
                    if (res.code==1) {
                        table.reload('list');
                    }else{
                        layer.msg(res.msg,{time:1000,icon:2});
                        return false;
                    }
                })
            });
            form.on('switch(hide)', function(obj){
                loading =layer.load(1, {shade: [0.1,'#fff']});
                var id = this.value;
                var hide = obj.elem.checked===true?0:1;
                $.post('{{url("admin/News/hide")}}',{'id':id,'hide':hide},function (res) {
                    layer.close(loading);
                    if (res.code==1) {
                        table.reload('list');
                    }else{
                        layer.msg(res.msg,{time:1000,icon:2});
                        return false;
                    }
                })
            });
            //监听行工具事件
            table.on('tool(list)', function(obj){
                var data = obj.data;

                if(obj.event === 'del'){
                    layer.confirm('确定要删除吗？', function(index){
                        var loading = layer.load(1, {shade: [0.1, '#fff']});
                        $.post('{{url("admin/News/del")}}',{id:data.id},function(res){
                            layer.close(loading);
                            if(res.code === 1){
                                layer.msg(res.msg, {time: 1000, icon: 1});
                                table.reload('list');
                            }else{
                                layer.msg(res.msg,{time:1000,icon:2});
                            }
                        })

                    });
                }else if(obj.event === 'edit'){
                    location.href = "{{url('admin/News/edit')}}?id="+data.id;
                }else if(obj.event === 'status1'){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post('{{url("admin/News/status")}}',{id:data.id,status:1},function(res){
                        layer.close(loading);
                        if(res.code === 1){
                            layer.msg(res.msg, {time: 1000, icon: 1});
                            table.reload('list');
                        }else{
                            layer.msg(res.msg,{time:1000,icon:2});
                        }
                    })
                }else if(obj.event === 'status2'){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post('{{url("admin/News/status")}}',{id:data.id,status:2},function(res){
                        layer.close(loading);
                        if(res.code === 1){
                            layer.msg(res.msg, {time: 1000, icon: 1});
                            table.reload('list');
                        }else{
                            layer.msg(res.msg,{time:1000,icon:2});
                        }
                    })
                }else if(obj.event === 'status0'){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post('{{url("admin/News/status")}}',{id:data.id,status:0},function(res){
                        layer.close(loading);
                        if(res.code === 1){
                            layer.msg(res.msg, {time: 1000, icon: 1});
                            table.reload('list');
                        }else{
                            layer.msg(res.msg,{time:1000,icon:2});
                        }
                    })
                }else if(obj.event === 'topping'){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post('{{url("admin/News/topping")}}',{id:data.id},function(res){
                        layer.close(loading);
                        if(res.code === 1){
                            layer.msg(res.msg, {time: 1000, icon: 1});
                        }else{
                            layer.msg(res.msg,{time:1000,icon:2});
                        }
                    })
                }else if (obj.event =='look') {
                    layer.open({
                        title:"查看【"+data.title+"】详情",
                        type:2,
                        area:['95%','90%'],
                        content:'{{url("admin/News/detail")}}?id='+data.id
                    })
                }
            });
        });
    </script>
    </body>
@endsection