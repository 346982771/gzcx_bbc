<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
@parent
    <body class="childrenBody">
    <div class="admin-main layui-anim layui-anim-upbit">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>权限列表</legend>
        </fieldset>
        <blockquote class="layui-elem-quote">
            <a href="{{url('admin/AuthRule/index')}}" class="layui-btn">重置</a>
            <a href="{{url('admin/AuthRule/add')}}" class="layui-btn layui-btn-sm" style="float:right;">添加权限</a>
            <div style="clear: both;"></div>
        </blockquote>
        <table class="layui-table" id="list" lay-filter="list"></table>
    </div>
    <script type="text/html" id="auth">
        <input type="checkbox" name="authopen" value="@{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="authopen" @{{ d.authopen == 0 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="status">
        <input type="checkbox" name="menustatus" value="@{{d.id}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="menustatus" @{{ d.menustatus == 1 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="order">
        <input name="@{{d.id}}" data-id="@{{d.id}}" class="list_order layui-input" value=" @{{d.sort}}" size="10"/>
    </script>
    <script type="text/html" id="icon">
        <span class="icon @{{d.icon}}"></span>
    </script>
    <script type="text/html" id="action">
        <a href="{{url('admin/AuthRule/edit')}}?id=@{{d.id}}" class="layui-btn layui-btn-xs">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script>
        layui.use(['table','form'], function() {
            var table = layui.table,form = layui.form, $ = layui.jquery;
            tableIn = table.render({
                elem: '#list',
                url: '{{url("admin/AuthRule/index")}}',
                method: 'post',
                cols: [[
                    {field: 'id', title: 'id', width: 70, fixed: true},
                    //{field: 'icon', align: 'center',title: '{:lang("icon")}', width: 60,templet: '#icon'},
                    {field: 'ltitle', title: '权限名称', width: 200},
                    {field: 'href', title: '控制器/方法', width: 200},
                    {field: 'authopen',align: 'center', title: '是否验证权限', width: 150,toolbar: '#auth'},
                    {field: 'menustatus',align: 'center',title: '菜单显示', width: 150,toolbar: '#status'},
                    {field: 'sort',align: 'center', title: '排序', width: 80, edit: 'text'},
                    {width: 160,title:'操作',align: 'center', toolbar: '#action'}
                ]]
            });
            table.on('edit(list)', function(obj){
                var value = obj.value //得到修改后的值
                        ,data = obj.data //得到所在行所有键值
                        ,field = obj.field; //得到字段
                //layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
                $.post('{{url("admin/AuthRule/sort")}}',{id:data.id,sort:value},function(res){
                    if(res.code==1){
                        layer.msg(res.msg,{time:1000,icon:1});
                    }else{
                        layer.msg(res.msg,{time:1000,icon:2});
                    }
                })

            });
            form.on('switch(authopen)', function(obj){
                loading =layer.load(1, {shade: [0.1,'#fff']});
                var id = this.value;
                var authopen = obj.elem.checked===true?0:1;
                $.post('{{url("admin/AuthRule/authOpen")}}',{'id':id,'authopen':authopen},function (res) {
                    layer.close(loading);
                    if (res.code==1) {
                        tableIn.reload();
                    }else{
                        layer.msg(res.msg,{time:1000,icon:2});
                        return false;
                    }
                })
            });
            form.on('switch(menustatus)', function(obj){
                loading =layer.load(1, {shade: [0.1,'#fff']});
                var id = this.value;
                var menustatus = obj.elem.checked===true?1:0;
                $.post('{{url("admin/AuthRule/menuStatus")}}',{'id':id,'menustatus':menustatus},function (res) {
                    layer.close(loading);
                    if (res.code==1) {
                        tableIn.reload();
                    }else{
                        layer.msg(res.msg,{time:1000,icon:2});
                        return false;
                    }
                })
            });
            table.on('tool(list)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    layer.confirm('您确定要删除该记录吗？', function(index){
                        var loading = layer.load(1, {shade: [0.1, '#fff']});
                        $.post("{{url("admin/AuthRule/del")}}",{id:data.id},function(res){
                            layer.close(loading);
                            if(res.code==1){
                                layer.msg(res.msg,{time:1000,icon:1});
                                obj.del();
                            }else{
                                layer.msg(res.msg,{time:1000,icon:2});
                            }
                        });
                        layer.close(index);
                    });
                }
            });

        })
    </script>
    </body>
@endsection