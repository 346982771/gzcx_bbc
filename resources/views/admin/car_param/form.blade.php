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
            <label class="layui-form-label">参数名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" ng-model="field.title" required  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">类型</label>
            <div class="layui-input-block">
                <select name="type" lay-verify="required" lay-filter="type">
                    <option value="0" @if(isset($info1) && $info1['type'] == 0) selected @endif>文字型</option>
                    <option value="1" @if(isset($info1) && $info1['type'] == 1) selected @endif>单选有无型</option>
                    <option value="2" @if(isset($info1) && $info1['type'] == 2) selected @endif>单选自定型</option>
                    <option value="3" @if(isset($info1) && $info1['type'] == 3) selected @endif>多选型</option>
                    {{--<option value="4" @if(isset($info1) && $info1['type'] == 4) selected @endif>范围型</option>--}}
                </select>
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">父级</label>
            <div class="layui-input-block">
                <select name="pid" lay-verify="required" lay-filter="pid">
                    <option value="0">一级</option>
                    @if(!empty($p_list))
                        @foreach($p_list as $p_list_s)
                    <option value="{{$p_list_s['id']}}" @if(isset($info1) && $info1['pid'] == $p_list_s['id']) selected @endif>{{$p_list_s['title']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否展示</label>
            <div class="layui-input-block">
                <input type="radio" name="is_show" ng-model="field.is_show" ng-checked="field.is_show==0" ng-value="0" title="否" >
                <input type="radio" name="is_show" ng-model="field.is_show" ng-checked="field.is_show==1" ng-value="1" title="是" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否搜索</label>
            <div class="layui-input-block">
                <input type="radio" name="is_search" ng-model="field.is_search" ng-checked="field.is_search==0" ng-value="0" title="否" >
                <input type="radio" name="is_search" ng-model="field.is_search" ng-checked="field.is_search==1" ng-value="1" title="是" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">基础参数</label>
            <div class="layui-input-block">
                <input type="radio" name="is_basis" ng-model="field.is_basis" ng-checked="field.is_basis==0" ng-value="0" title="否" >
                <input type="radio" name="is_basis" ng-model="field.is_basis" ng-checked="field.is_basis==1" ng-value="1" title="是" >
            </div>
        </div>
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">是否输入</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="radio" name="is_input" ng-model="field.is_input" ng-checked="field.is_input==0" ng-value="0" title="否" >--}}
                {{--<input type="radio" name="is_input" ng-model="field.is_input" ng-checked="field.is_input==1" ng-value="1" title="是" >--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" ng-model="field.sort" name="sort" placeholder="请输入排序" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="submit">提交</button>
                <a href="{{url('admin/CarParam/index')}}" class="layui-btn layui-btn-primary">返回</a>
            </div>
        </div>


</div>
<script src="{{ URL::asset(_ADMIN_.'js/angular.min.js') }}"></script>
<script>
    var m = angular.module('hd',[]);

    m.controller('ctrl',['$scope',function($scope) {

        $scope.field = '{!!$info!!}'!='null'? {!!$info!!} :{sort:0,is_search:0,is_input:0,is_show:1,is_basis:0};

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