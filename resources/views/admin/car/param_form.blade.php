<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
    @parent
<body class="main_body">

<div style="margin-left: 20px;"  ng-app="hd" ng-controller="ctrl" class="layui-form layui-form-pane form_padding layui-anim layui-anim-upbit">
    <div>
        <fieldset class="layui-elem-field layui-field-title">
            <legend></legend>
        </fieldset>

        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" ng-model="field.title"   lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">指导价</label>
            <div class="layui-input-block">
                <input type="text" name="guide_price" ng-model="field.guide_price"   lay-verify="required" placeholder="请输入指导价/万元" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">参考价</label>
            <div class="layui-input-block">
                <input type="text" name="reference_price" ng-model="field.reference_price"   lay-verify="required" placeholder="请输入参考价/万元" autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="submit">提交</button>
                <a  class="layui-btn layui-btn-normal">提取同型数据</a>
            </div>
        </div>


</div>
<script src="{{ URL::asset(_ADMIN_.'js/angular.min.js') }}"></script>
<script>
    var m = angular.module('hd',[]);

    m.controller('ctrl',['$scope',function($scope) {

        $scope.field = '{!!$info!!}'!='null'? {!!$info!!} :{group_id:'',username:'',loginname:'',mobile:'',img:'',sort:50};

        layui.use(['form','upload','laydate'], function(){
            var form = layui.form,upload = layui.upload,$= layui.jquery,laydate = layui.laydate;

            form.render();
            //监听提交
            form.on('submit(submit)', function (data) {
                loading =layer.load(1, {shade: [0.1,'#fff']});
                data.field.id = $scope.field.id;
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
</script>
</body>
@endsection