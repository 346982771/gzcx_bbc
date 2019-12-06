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
            <a href="{{url('admin/CarParam/index')}}" class="layui-btn">重置</a>
            <a href="{{url('admin/CarParam/add')}}"class="layui-btn" style="float:right;">添加信息</a>
            <div style="clear: both;"></div>
        </div>

        <table class="layui-table" id="list" lay-filter="list"></table>
    </div>


    <script type="text/html" id="action">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        @{{#  if(d.pid > 0 && d.type > 1){ }}


        <a class="layui-btn layui-btn-xs" lay-event="option">选项管理</a>
        @{{# } }}
    </script>
    <script type="text/html" id="is_show">
        <input type="checkbox" name="is_show" value="@{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="is_show" @{{ d.is_show == 1 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="is_basis">
        <input type="checkbox" name="is_basis" value="@{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="is_basis" @{{ d.is_basis == 1 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="order">
        <input name="@{{d.id}}" data-id="@{{d.id}}" class="list_order layui-input" value=" @{{d.sort}}" size="10"/>
    </script>
    <script type="text/html" id="type">

        @{{# if(d.type == 0){ }}
        字符型
        @{{#  } else if(d.type == 1) { }}
        单选有无型
        @{{#  } else if(d.type == 2) { }}
        单选自定型

        @{{#  } else if(d.type == 3){ }}
        多选型

        @{{#  } }}

    </script>
    <script>
        layui.use('table', function(){
            var table = layui.table,form = layui.form, $ = layui.jquery;

            table.render({
                elem: '#list'
                ,url:'{{url("admin/CarParam/index")}}'
                ,method:'post'
                ,cols: [[
                    {field:'id', width:80, title: 'ID'},
                    {field: 'ltitle',align:'left', title: '名称', width: 200},
                    {field: 'is_show',align: 'center', title: '显示', width: 150,toolbar: '#is_show'},
                    {field: 'type',align: 'center', title: '类型', width: 150,toolbar: '#type'},
                    //{field: 'is_basis',align: 'center', title: '基础参数', width: 150,toolbar: '#is_basis'},

                    {field: 'sort',align: 'center', title: '排序', width: 80, edit: 'text'},
                    {width: 400,align: 'center',title: '操作', toolbar: '#action'}
                ]]
                ,page: false
                //,limit: 10 //每页默认显示的数量
            });

            table.on('edit(list)', function(obj){
                var value = obj.value //得到修改后的值
                        ,data = obj.data //得到所在行所有键值
                        ,field = obj.field; //得到字段
                //layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
                $.post('{{url("admin/CarParam/sort")}}',{id:data.id,sort:value},function(res){
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
                        key: $('#key').val()
                    }
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                });
            });
            form.on('switch(is_show)', function(obj){
                loading =layer.load(1, {shade: [0.1,'#fff']});
                var id = this.value;
                var is_show = obj.elem.checked===true?1:0;
                $.post('{{url("admin/CarParam/isShow")}}',{'id':id,'is_show':is_show},function (res) {
                    layer.close(loading);
                    if (res.code==1) {
                        tableIn.reload();
                    }else{
                        layer.msg(res.msg,{time:1000,icon:2});
                        return false;
                    }
                })
            });
            {{--form.on('switch(is_basis)', function(obj){--}}
                {{--loading =layer.load(1, {shade: [0.1,'#fff']});--}}
                {{--var id = this.value;--}}
                {{--var is_basis = obj.elem.checked===true?1:0;--}}
                {{--$.post('{{url("admin/CarParam/isBasis")}}',{'id':id,'is_basis':is_basis},function (res) {--}}
                    {{--layer.close(loading);--}}
                    {{--if (res.code==1) {--}}
                        {{--tableIn.reload();--}}
                    {{--}else{--}}
                        {{--layer.msg(res.msg,{time:1000,icon:2});--}}
                        {{--return false;--}}
                    {{--}--}}
                {{--})--}}
            {{--});--}}
            //监听行工具事件
            table.on('tool(list)', function(obj){
                var data = obj.data;

                if(obj.event === 'del'){
                    layer.confirm('确定要删除吗？', function(index){
                        var loading = layer.load(1, {shade: [0.1, '#fff']});
                        $.post('{{url("admin/CarParam/del")}}',{id:data.id},function(res){
                            layer.close(loading);
                            if(res.code === 1){
                                layer.msg(res.msg, {time: 1000, icon: 1});

                                layer.close(index);
                                if(data.pid == 0){
                                    location.href = "{{url('admin/CarParam/index')}}";
                                }else{
                                    obj.del();
                                }
                            }else{
                                layer.msg(res.msg,{time:1000,icon:2});
                            }
                        })

                    });
                }else if(obj.event === 'edit'){
                    location.href = "{{url('admin/CarParam/edit')}}?id="+data.id;
                }else if(obj.event === 'option'){
                    layer.open({
                        title:"添加【"+data.title+"】参数选项",
                        type:2,
                        area:['95%','90%'],
                        content:"{{url("admin/CarParamOption/index")}}?param_id="+data.id
                    })
                }
            });
        });
    </script>
    </body>
@endsection