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
            <div  style="line-height: 40px;">标题:{{$info['title']}}</div>
            <div  style="line-height: 40px;">话题: {{$info['topic_name']}}</div>
        </div>

        <div class="layui-form-item" style="margin-top: -20px;">
            <div class="layui-input-block" id="topic_text">

            </div>
        </div>
        <div>
            <div class="layui-form-item layui-form-text">
                <div style="margin-bottom: 10px;">
                    <label class="layui-form-label">封面图</label>
                    <img src="{{$info['cover_url']}}" style="max-height: 400px; max-width: 400px;">
                </div>
            </div>
        <hr class="layui-bg-green">
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" lay-verify="required" name="content" class="layui-textarea">{{$info['content']}}</textarea>
            </div>

        </div>
        <hr class="layui-bg-green">
        @if(!empty($info['news_info']))
            @foreach($info['news_info'] as $news_info_s)
            @if($news_info_s['type'] == 2)
                <div>
                    <div class="layui-form-item layui-form-text">
                        <label class=layui-form-label>内容</label>
                        <div class="layui-input-block">
                            <textarea placeholder="请输入内容"  class="layui-textarea">{{$news_info_s['desc']}}</textarea>
                        </div>
                    </div>
                <hr class="layui-bg-green">
                </div>
            @elseif($news_info_s['type'] == 1)
                <div>
                    <div class="layui-form-item layui-form-text">
                        <div style="margin-bottom: 10px;">
                            <img src="{{$news_info_s['url']}}" style="max-height: 400px; max-width: 400px;">
                        </div>
                        <div class="layui-input-block">
                            <textarea class="layui-textarea">{{$news_info_s['desc']}}</textarea>
                        </div>
                    </div>
                    <hr class="layui-bg-green">
                </div>
            @elseif($news_info_s['type'] == 3)
                <div>
                    <div class="layui-form-item layui-form-text">
                        <div style="margin-bottom: 10px;">
                            <embed src="{{$news_info_s['url']}}" style="max-height: 400px; max-width: 400px;"/>
                        </div>
                        <div class="layui-input-block">
                            <textarea class="layui-textarea">{{$news_info_s['desc']}}</textarea>
                        </div>
                    </div>
                <hr class="layui-bg-green">
                </div>
            @endif
            @endforeach
        @endif



</div>
<script src="{{ URL::asset(_ADMIN_.'js/angular.min.js') }}"></script>
<script>

</script>
</body>
@endsection
