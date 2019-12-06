<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
    @parent
<body class="main_body">
<link rel="stylesheet" href="{{ URL::asset(_ADMIN_.'layui/selects/formSelects-v4.css') }}" media="all" />
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
        <label class="layui-form-label">关注人数</label>
        <div class="layui-input-block">
            <input type="text" name="attention_num" ng-model="field.attention_num" placeholder="请输入关注人数" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">话题使用数</label>
        <div class="layui-input-block">
            <input type="text" name="topic_use_count" ng-model="field.topic_use_count" placeholder="请输入话题使用数" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="submit">提交</button>
            <a href="{{url('admin/Topic/index')}}" class="layui-btn layui-btn-primary">返回</a>
        </div>
    </div>


</div>
<script src="{{ URL::asset(_ADMIN_.'js/angular.min.js') }}"></script>
<!--引用富文本-->
<script type="text/javascript" src="{{ URL::asset(_ADMIN_.'ueditor/ueditor.config.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset(_ADMIN_.'ueditor/ueditor.all.js') }}"></script>
<script src="{{ URL::asset(_ADMIN_.'layui/selects/formSelects-v4.js') }}" type="text/javascript" charset="utf-8"></script>
<script>
var m = angular.module('hd',[]);

m.controller('ctrl',['$scope',function($scope) {

    $scope.field = '{!!$info!!}'!='null'? {!!$info!!} :{topic_use_count:0,attention_num:0};
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
        var formSelects = layui.formSelects;



        //普通图片上传
        var uploadInst = upload.render({
            elem: '#adBtn'
            , url: '{{config("common.upload_url")}}'
            , before: function (obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function (index, file, result) {
                    $('#adPic').attr('src', result); //图片链接（base64）
                });
            },
            done: function (res) {
                if (res.status > 0) {

                    $('#icon').val(res.data.url);
                } else {
                    //如果上传失败
                    return layer.msg('上传失败');
                }
            }
            , error: function () {
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function () {
                    uploadInst.upload();
                });
            }
        });
//        var ua = UE.getEditor('container1', {});
//        ua.addListener("ready", function () {
//            // editor准备好之后才可以使用
//            ua.setContent($scope.field.desc);
//        });
    });
}]);

</script>
</body>

@endsection