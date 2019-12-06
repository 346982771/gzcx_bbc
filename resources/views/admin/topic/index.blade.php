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
            <a href="{{url('admin/Topic/index')}}" class="layui-btn">重置</a>
            <a href="{{url('admin/Topic/add')}}"class="layui-btn" style="float:right;">添加信息</a>
            <div style="clear: both;"></div>
        </div>

        <table class="layui-table" id="list" lay-filter="list"></table>
    </div>


    <script type="text/html" id="action">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script type="text/html" id="hide">
        <input type="checkbox" name="hide" value="@{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="hide" @{{ d.hide == 0 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="recommend">
        <input type="checkbox" name="recommend" value="@{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="recommend" @{{ d.recommend == 1 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="order">
        <input name="@{{d.id}}" data-id="@{{d.id}}" class="list_order layui-input" value=" @{{d.sort}}" size="10"/>
    </script>
    <script type="text/html" id="type">

        @{{# if(d.type == 1){ }}
        普通话题
        @{{#  } else if(d.type == 2){ }}
        车型话题
        @{{#  } }}

    </script>
    <script>
        layui.use('table', function(){
            var table = layui.table,form = layui.form, $ = layui.jquery;

            table.render({
                elem: '#list'
                ,url:'{{url("admin/Topic/index")}}'
                ,method:'post'
                ,cols: [[
                    {field:'id', width:80, title: 'ID'},

                    {field: 'title',align:'left', title: '名称', width: 300},
                    {field: 'attention_num',align:'center', title: '关注人数', width: 100},
                    {field: 'topic_use_count',align:'center', title: '使用数', width: 100},
                    //{field: 'type',align:'center', title: '类型', width: 100,toolbar:'#type'},
                    //{field: 'sort',align: 'center', title: '排序', width: 80, edit: 'text'},
                    {width: 400,align: 'center',title: '操作', toolbar: '#action'}
                ]]
                ,page: true
                ,limit: {{ config('common.pageSize') }} //每页默认显示的数量
            });

            {{--table.on('edit(list)', function(obj){--}}
                {{--var value = obj.value //得到修改后的值--}}
                        {{--,data = obj.data //得到所在行所有键值--}}
                        {{--,field = obj.field; //得到字段--}}
                {{--//layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);--}}
                {{--$.post('{{url("admin/Topic/sort")}}',{id:data.brand_id,sort:value},function(res){--}}
                    {{--if(res.code==1){--}}
                        {{--layer.msg(res.msg,{time:1000,icon:1});--}}
                    {{--}else{--}}
                        {{--layer.msg(res.msg,{time:1000,icon:2});--}}
                    {{--}--}}
                {{--})--}}

            {{--});--}}


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
            {{--form.on('switch(recommend)', function(obj){--}}
                {{--loading =layer.load(1, {shade: [0.1,'#fff']});--}}
                {{--var brand_id = this.value;--}}
                {{--var recommend = obj.elem.checked===true?1:0;--}}
                {{--$.post('{{url("admin/CarBrand/recommend")}}',{'id':brand_id,'recommend':recommend},function (res) {--}}
                    {{--layer.close(loading);--}}
                    {{--if (res.code==1) {--}}
                        {{--layer.msg(res.msg,{time:1000,icon:1});--}}
                        {{--tableIn.reload();--}}
                    {{--}else{--}}
                        {{--layer.msg(res.msg,{time:1000,icon:2});--}}
                        {{--return false;--}}
                    {{--}--}}
                {{--})--}}
            {{--});--}}
            {{--form.on('switch(hide)', function(obj){--}}
                {{--loading =layer.load(1, {shade: [0.1,'#fff']});--}}
                {{--var brand_id = this.value;--}}
                {{--var hide = obj.elem.checked===true?0:1;--}}
                {{--$.post('{{url("admin/CarBrand/hide")}}',{'id':brand_id,'hide':hide},function (res) {--}}
                    {{--layer.close(loading);--}}
                    {{--if (res.code==1) {--}}
                        {{--layer.msg(res.msg,{time:1000,icon:1});--}}
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
                        $.post('{{url("admin/Topic/del")}}',{id:data.id},function(res){
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
                    location.href = "{{url('admin/Topic/edit')}}?id="+data.id;
                }
            });
        });
    </script>
    </body>
@endsection