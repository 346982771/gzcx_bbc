<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
    @parent
<body class="main_body">
<div style="margin-left: 20px;"  ng-app="hd" ng-controller="ctrl" class="layui-form layui-form-pane form_padding layui-anim layui-anim-upbit">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>{{$title}}</legend>
    </fieldset>

        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" ng-model="field.title" required  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-block">
                <input type="text" name="desc" ng-model="field.desc" required  lay-verify="required" placeholder="请输入描述" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="submit">提交</button>
                <a href="{{url('admin/AuthGroup/index')}}" class="layui-btn layui-btn-primary">返回</a>
            </div>
        </div>


</div>
<script src="{{ URL::asset(_ADMIN_.'js/angular.min.js') }}"></script>
<script>
    var m = angular.module('hd',[]);

    m.controller('ctrl',['$scope',function($scope) {

        $scope.field = '{!!$info!!}'!='null'? {!!$info!!} :{group_id:'',username:'',loginname:'',mobile:'',img:'',sex:0};

        layui.use(['form','upload'], function(){
            var form = layui.form,upload = layui.upload,$= layui.jquery;
            form.render();
            //监听提交
            form.on('submit(submit)', function (data) {
                loading =layer.load(1, {shade: [0.1,'#fff']});
                data.field.group_id = $scope.field.group_id;
                $.post("", data.field, function (res) {
                    layer.close(loading);
                    if (res.code > 0) {
                        layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                            location.href = res.url;
                        });
                    } else {
                        layer.msg(res.msg, {time: 1800, icon: 2});
                    }
                });
            });

        });
    }]);
    //Demo

</script>
</body>
@endsection