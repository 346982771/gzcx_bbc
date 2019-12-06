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
            <div></div>
        </div>


        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-block">
                <textarea lay-verify="required" name="content" class="layui-textarea">{{$info['content']}}</textarea>
            </div>
        </div>



</div>
<script src="{{ URL::asset(_ADMIN_.'js/angular.min.js') }}"></script>
<script>

</script>
</body>
@endsection
