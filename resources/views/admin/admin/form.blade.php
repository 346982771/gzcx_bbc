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
        @if($auth_group)
        <div class="layui-form-item">
            <label class="layui-form-label">角色</label>
            <div class="layui-input-block">
                <select name="group_id" lay-verify="required">
                    <option value="">请选择角色</option>
                    @foreach($auth_group as $v)
                    <option value="{{$v['group_id']}}" @if(isset($info1) && ($info1['group_id'] == $v['group_id'])) selected @endif>{{$v['title']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @else
        <div class="layui-form-item">
            <a href="#" class="layui-btn"><i class="fa fa-plus" aria-hidden="true"></i>请先添加角色</a>
            <br><br>
        </div>
        @endif
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
                <input type="text" name="loginname" ng-model="field.loginname" required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="text" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">昵称</label>
            <div class="layui-input-block">
                <input type="text" name="username" ng-model="field.username"  lay-verify="required" placeholder="请输入昵称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-block">
                <input type="text" name="mobile" ng-model="field.mobile"  lay-verify="required" placeholder="请输入手机号" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
                <input type="radio" name="sex" ng-model="field.sex" ng-checked="field.sex==0" ng-value="0" title="男" >
                <input type="radio" name="sex" ng-model="field.sex" ng-checked="field.sex==1" ng-value="1" title="女" >
            </div>
        </div>
        @if(!isset($info1))
        <div class="layui-form-item" >
            <label class="layui-form-label">门店管理员<span  style="color: red">*</span></label>
            <div class="layui-input-block">

                <input type="checkbox" @if(isset($info1) && ($info1['shop_id'] > 0)) checked @endif name="is_shop" lay-skin="switch" lay-filter="is_shop"  lay-text="是|否">
            </div>
        </div>

        <div class="layui-form-item" style="z-index: 99999;display: none" id="shop" >
            <label class="layui-form-label">门店<span  style="color: red">*</span></label>
            <div class="layui-input-block" style="z-index: 99999">
                <select name="shop_id" lay-filter="shop_id">
                    @foreach($shops as $shop)
                    <option value="{{$shop['id']}}">{{$shop['title']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        <div class="layui-form-item">
            <label class="layui-form-label">头像</label>
            <input type="hidden" name="img" id="img"  value="@{{field.img}}">
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="adBtn"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="adPic">
                        <p id="demoText"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="submit">提交</button>
                <a href="{{url('admin/admin/index')}}" class="layui-btn layui-btn-primary">返回</a>
            </div>
        </div>
    </form>

</div>
<script src="{{ URL::asset(_ADMIN_.'js/angular.min.js') }}"></script>

<script>
    var m = angular.module('hd',[]);

    m.controller('ctrl',['$scope',function($scope) {

        $scope.field = '{!!$info!!}'!='null'? {!!$info!!} :{group_id:'',username:'',loginname:'',mobile:'',img:'',sex:0};
        if ($scope.field.img) {
            adPic.src =  $scope.field.img;
        }
        layui.use(['form','upload'], function(){
            var form = layui.form,upload = layui.upload,$= layui.jquery;
            form.render();
            //监听提交
            form.on('submit(submit)', function (data) {
                loading =layer.load(1, {shade: [0.1,'#fff']});
                data.field.admin_id = $scope.field.admin_id;
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
            //监听指定开关
            form.on('switch(is_shop)', function(data){
                if(this.checked == true){
                    $("#shop").css("display","block");
                }else{
                    $("#shop").css("display","none");
                }
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
    //Demo

</script>
</body>
@endsection