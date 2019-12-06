<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
    @parent
    <body class="main_body">
    <link rel="stylesheet" href="{{ URL::asset(_ADMIN_.'css/global.css') }}" type="text/css">
<link rel="stylesheet" href="{{ URL::asset(_ADMIN_.'plugins/zTree/css/zTreeStyle.css') }}" type="text/css">

<div class="admin-main layui-anim layui-anim-upbit">
    <fieldset class="layui-elem-field">
        <legend>配置权限</legend>
        <div class="layui-field-box">
            <form class="layui-form layui-form-pane">
                <ul id="treeDemo" class="ztree"></ul>
                <div class="layui-form-item text-center">
                    <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">提交</button>
                    <button class="layui-btn layui-btn-danger" type="button" onclick="window.history.back()">返回</button>
                </div>
            </form>
        </div>
    </fieldset>
</div>

<script type="text/javascript" src="{{ URL::asset(_ADMIN_.'common/js/jquery.2.1.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset(_ADMIN_.'plugins/zTree/js/jquery.ztree.core.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset(_ADMIN_.'plugins/zTree/js/jquery.ztree.excheck.min.js') }}"></script>
<script type="text/javascript">
    var setting = {
        check:{enable: true},
        view: {showLine: false, showIcon: false, dblClickExpand: false},
        data: {
            simpleData: {enable: true, pIdKey:'pid', idKey:'id'},
            key:{name:'title'}
        }
    };
    var zNodes = {!! $data !!};
    function setCheck() {
        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        zTree.setting.check.chkboxType = { "Y":"ps", "N":"ps"};

    }
    $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    setCheck();
    layui.use(['form', 'layer'], function () {
        var form = layui.form, layer = layui.layer;
        form.on('submit(submit)', function () {
            loading =layer.load(1, {shade: [0.1,'#fff']});
            // 提交到方法 默认为本身
            var treeObj=$.fn.zTree.getZTreeObj("treeDemo"),
                nodes=treeObj.getCheckedNodes(true),
                v="";
            for(var i=0;i<nodes.length;i++){
                v+=nodes[i].id + ",";
            }
            var id = "{{$id}}";
            $.post("{{url('admin/AuthGroup/groupAccess')}}", {'rules':v,'group_id':id}, function (res) {
                layer.close(loading);
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                        location.href = res.url;
                    });
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                }
            });
        })
    });
</script>
    </body>
@endsection