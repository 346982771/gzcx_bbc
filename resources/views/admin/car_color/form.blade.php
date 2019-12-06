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
            <label class="layui-form-label">颜色数量</label>
            <div class="layui-input-block" style="z-index: 1002">
                <select name="type" lay-verify="required" lay-filter="type">

                    <option value="1" @if(isset($info1) && $info1['type'] == 1) selected @endif>单色</option>
                    <option value="2" @if(isset($info1) && $info1['type'] == 2) selected @endif>双色</option>

                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" ng-model="field.title"   lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">颜色</label>
            <div class="layui-input-inline">
                <input type="text" id="color" name="color" ng-model="field.color"   lay-verify="required" placeholder="请输入颜色" autocomplete="off" class="layui-input">
            </div>
            <div id="choose_color"></div>
        </div>
        <div id="color_2" @if((isset($info1) && $info1['type'] != 2) || !isset($info1))style="display: none"@endif>

            <div class="layui-form-item" style="">
                <label class="layui-form-label">颜色</label>
                <div class="layui-input-inline">
                    <input type="text" id="color2" name="color2" ng-model="field.color2" placeholder="请输入颜色" autocomplete="off" class="layui-input">
                </div>
                <div id="choose_color2"></div>
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" ng-model="field.sort" name="sort" value="50" placeholder="请输入排序" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="submit">提交</button>
                <a href="{{url('admin/CarColor/index')}}" class="layui-btn layui-btn-primary">返回</a>
            </div>
        </div>


</div>
<script src="{{ URL::asset(_ADMIN_.'js/angular.min.js') }}"></script>
<script>
    var m = angular.module('hd',[]);

    m.controller('ctrl',['$scope',function($scope) {

        $scope.field = '{!!$info!!}'!='null'? {!!$info!!} :{group_id:'',username:'',loginname:'',mobile:'',img:'',sort:50};

        layui.use(['form','upload','colorpicker'], function(){
            var form = layui.form,upload = layui.upload,$= layui.jquery,colorpicker = layui.colorpicker;
            //常规使用
            colorpicker.render({
                elem: '#choose_color' //绑定元素
                //,color: '#2ec770'
                ,done: function(color){ //颜色改变的回调
//                    layer.tips('选择了：'+ color, this.elem, {
//                        tips: 1
//                    });
                    $('#color').val(color);
                }
            });
            colorpicker.render({
                elem: '#choose_color2' //绑定元素
                ,done: function(color){ //颜色改变的回调
                    $('#color2').val(color);
                }
            });
            form.on('select(type)', function (data) {

                if(data.value == '1'){
                    $('#color_2').css('display','none');
                }else if(data.value == '2'){
                    $('#color_2').css('display','block');

                }
                return false;
            });
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