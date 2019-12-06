<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
@parent
    <body class="childrenBody">
    <div style="margin-left: 20px;"  ng-app="hd" ng-controller="ctrl" class="layui-form layui-form-pane form_padding layui-anim layui-anim-upbit">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>添加权限</legend>
        </fieldset>
        <blockquote class="layui-elem-quote">
            1、《控/方》：意思是 控制器/方法; 例如 admin/Sys/sysList<br/>
            <!--2、图标名称为左侧导航栏目的图标样式，具体可查看<a href="http://fontawesome.io/icons/" target="_blank">FontAwesome</a>图标CSS样式-->
        </blockquote>
            @if(!isset($info1))
            <div class="layui-form-item">
                <label class="layui-form-label">父级</label>
                <div class="layui-input-block">
                    <select name="pid" lay-verify="required" lay-filter="pid" >
                        <option value="0">默认顶级</option>
                        @foreach($auth_rule as $v)
                        <option value="{{$v['id']}}">{{$v['ltitle']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            <div class="layui-form-item">
                <label class="layui-form-label">权限名称</label>
                <div class="layui-input-block">
                    <input type="text" name="title" ng-model="field.title" lay-verify="required" placeholder="请输入权限名称" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">控制器/方法</label>
                <div class="layui-input-block">
                    <input type="text" name="href" ng-model="field.href" lay-verify="required" placeholder="请输入控制器/方法" class="layui-input">
                </div>
            </div>
            @if(!isset($info1))
            <!--<div class="layui-form-item">-->
            <!--<label class="layui-form-label">图标名称</label>-->
            <!--<div class="layui-input-4">-->
            <!--<input type="text" name="icon" placeholder="{:lang('pleaseEnter')}图标名称" class="layui-input">-->
            <!--</div>-->
            <!--</div>-->
            <input type="hidden" name="menustatus" lay-filter="menustatus" value="1" title="开启">
            <!--<div class="layui-form-item">-->
            <!--<label class="layui-form-label">菜单状态</label>-->
            <!--<div class="layui-input-block">-->
            <!--<input type="radio" name="menustatus" lay-filter="menustatus" checked value="1" title="开启">-->
            <!--<input type="radio" name="menustatus" lay-filter="menustatus" value="0" title="关闭">-->
            <!--</div>-->
            <!--</div>-->
            <div class="layui-form-item">
                <label class="layui-form-label">验证权限</label>
                <div class="layui-input-block">
                    <input type="radio" name="authopen" lay-filter="authopen" checked value="0" title="开启">
                    <input type="radio" name="authopen" lay-filter="authopen" value="1" title="关闭">
                </div>
            </div>
            @endif
            <div class="layui-form-item">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-block">
                    <input type="text" ng-model="field.sort" name="sort" value="50" placeholder="请输入排序" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">立即提交</button>
                    <a href="{{url('admin/AuthRule/index')}}" class="layui-btn layui-btn-primary">返回</a>
                </div>
            </div>

    </div>
    <script src="{{ URL::asset(_ADMIN_.'js/angular.min.js') }}"></script>
    <script>
        var m = angular.module('hd',[]);

        m.controller('ctrl',['$scope',function($scope) {

            $scope.field = '{!!$info!!}'!='null'? {!!$info!!} :{sort:50,href : 'javascript:;'};
            if ($scope.field.img) {
                adPic.src =  $scope.field.img;
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

                            $('#img').val(res.data.url);
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
            });
        }]);
    </script>
    </body>
@endsection