<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
    @parent
<body class="main_body">
<div style="margin-left: 20px;"  ng-app="hd" ng-controller="ctrl" class="layui-form layui-form-pane form_padding layui-anim layui-anim-upbit">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>{{$title}}</legend>
    </fieldset>
    <form>

        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" ng-model="field.title" required  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">价格</label>
            <div class="layui-input-block">
                <input type="text" name="price" ng-model="field.price" required  lay-verify="required" placeholder="请输入价格/元" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" ng-model="field.content" name="content" class="layui-textarea"></textarea>
            </div>

        </div>
        @if(empty($info1))
        <input type="hidden" name="car_id" value="{{$car_id}}">
        @else
            <input type="hidden" name="car_id" value="{{$info1['car_id']}}">
        @endif

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" ng-model="field.sort" name="sort" value="50" placeholder="请输入排序" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="submit">提交</button>
                @if(empty($info1))
                <a href="{{url('admin/CarOptionalPackage/index')}}?car_id={{$car_id}}" class="layui-btn layui-btn-primary">返回</a>
                @else
                    <a href="{{url('admin/CarOptionalPackage/index')}}?car_id={{$info1['car_id']}}" class="layui-btn layui-btn-primary">返回</a>
                @endif
            </div>
        </div>
    </form>

</div>

<script src="{{ URL::asset(_ADMIN_.'js/angular.min.js') }}"></script>

<script>
    var m = angular.module('hd',[]);

    m.controller('ctrl',['$scope',function($scope) {

        $scope.field = '{!!$info!!}'!='null'? {!!$info!!} :{group_id:'',username:'',loginname:'',mobile:'',img:'',sort:50};
        if ($scope.field.icon) {
            adPic.src =  $scope.field.icon;
        }
        layui.use(['form','upload'], function(){
            var form = layui.form,upload = layui.upload,$= layui.jquery;
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
    //Demo

</script>
</body>
@endsection