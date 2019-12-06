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
            <a href="{{url('admin/CarSeries/index')}}" class="layui-btn">重置</a>
            {{--<a href="{{url('admin/CarSeries/add')}}"class="layui-btn" style="float:right;">添加信息</a>--}}
            <div style="clear: both;"></div>
        </div>

        <table class="layui-table" id="list" lay-filter="list"></table>
    </div>


    <script type="text/html" id="action">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script type="text/html" id="hide">
        <input type="checkbox" name="hide" value="@{{d.brand_id}}" lay-skin="switch" lay-text="是|否" lay-filter="hide" @{{ d.hide == 0 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="recommend">
        <input type="checkbox" name="recommend" value="@{{d.brand_id}}" lay-skin="switch" lay-text="是|否" lay-filter="recommend" @{{ d.recommend == 1 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="order">
        <input name="@{{d.brand_id}}" data-id="@{{d.brand_id}}" class="list_order layui-input" value=" @{{d.sort}}" size="10"/>
    </script>
    <script type="text/html" id="icon">

        @{{# if(!d.icon){ }}
        暂无图片
        @{{#  } else { }}
        <img src="@{{d.icon}}" style="max-width: 30px;max-height: 30px;">
        @{{#  } }}

    </script>

    <script type="text/html" id="maker_type">

        @{{# if(d.maker_type == 1){ }}
        国产
        @{{#  } else if(d.maker_type == 2) { }}
        合资
        @{{#  } else if(d.maker_type == 3) { }}
        进口
        @{{#  } }}

    </script>
    <script>
        layui.use('table', function(){
            var table = layui.table,form = layui.form, $ = layui.jquery;

            table.render({
                elem: '#list'
                ,url:'{{url("admin/CarSeries/index")}}'
                ,method:'post'
                ,cols: [[
                    {field:'series_id', width:80, title: 'ID'},

                    {field: 'series_name',align:'left', title: '名称', width: 300},
                    {field: 'maker_type',align:'left', title: '类型', width: 100, toolbar: '#maker_type'},
                    {field: 'series_group_name',align:'left', title: '厂商', width: 150},

                    //{field: 'icon',align:'center', title: '图标', width: 120,toolbar: '#icon'},
                    {field: 'hide',align: 'center', title: '显示', width: 150,toolbar: '#hide'},
                    {field: 'recommend',align: 'center', title: '推荐', width: 150,toolbar: '#recommend'},
                    {field: 'sort',align: 'center', title: '排序', width: 80, edit: 'text'},
                    //{width: 400,align: 'center',title: '操作', toolbar: '#action'}
                ]]
                ,page: true
                ,limit: {{ config('common.pageSize') }} //每页默认显示的数量
            });

            table.on('edit(list)', function(obj){
                var value = obj.value //得到修改后的值
                        ,data = obj.data //得到所在行所有键值
                        ,field = obj.field; //得到字段
                //layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
                $.post('{{url("admin/CarSeries/sort")}}',{id:data.series_id,sort:value},function(res){
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
            form.on('switch(recommend)', function(obj){
                loading =layer.load(1, {shade: [0.1,'#fff']});
                var series_id = this.value;
                var recommend = obj.elem.checked===true?1:0;
                $.post('{{url("admin/CarSeries/recommend")}}',{'id':series_id,'recommend':recommend},function (res) {
                    layer.close(loading);
                    if (res.code==1) {
                        layer.msg(res.msg,{time:1000,icon:1});
                        tableIn.reload();
                    }else{
                        layer.msg(res.msg,{time:1000,icon:2});
                        return false;
                    }
                })
            });
            form.on('switch(hide)', function(obj){
                loading =layer.load(1, {shade: [0.1,'#fff']});
                var series_id = this.value;
                var hide = obj.elem.checked===true?0:1;
                $.post('{{url("admin/CarSeries/hide")}}',{'id':series_id,'hide':hide},function (res) {
                    layer.close(loading);
                    if (res.code==1) {
                        layer.msg(res.msg,{time:1000,icon:1});
                        tableIn.reload();
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
                        $.post('{{url("admin/CarSeries/del")}}',{id:data.series_id},function(res){
                            layer.close(loading);
                            if(res.code === 1){
                                layer.msg(res.msg, {time: 1000, icon: 1});
                                layer.close(index);
                                obj.del();

                            }else{
                                layer.msg(res.msg,{time:1000,icon:2});
                            }
                        })

                    });
                }else if(obj.event === 'edit'){
                    location.href = "{{url('admin/CarSeries/edit')}}?id="+data.series_id;
                }
            });
        });
    </script>
    </body>
@endsection