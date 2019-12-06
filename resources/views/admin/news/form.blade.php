<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
    @parent

    <body class="main_body">
    <div style="margin-left: 20px;"  ng-app="hd" ng-controller="ctrl" class="layui-form layui-form-pane form_padding layui-anim layui-anim-upbit">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>{{$title}}</legend>
        </fieldset>
        <div style="z-index: 9999; position: fixed ! important; left: 0px; top: 40px; width: 100%; height: 45px;" id="adBtn_all">
            <div class="layui-form-item" id="uploadVideo">
                <button type="button" class="layui-btn layui-btn-primary" onclick="add(2,'','')"><i class="icon icon-upload3"></i>添加文字</button>
                <button type="button" class="layui-btn layui-btn-primary" {{--id="adBtn_video"--}} @click="vExampleAdd3"><i class="icon icon-upload3"></i>添加视频</button>
                <button type="button" class="layui-btn layui-btn-primary" {{--id="adBtn_img"--}} @click="vExampleAdd"><i class="icon icon-upload3"></i>添加图片</button>
                <button type="button" class="layui-btn layui-btn-primary" {{--id="adBtn_cover"--}} @click="vExampleAdd4"><i class="icon icon-upload3"></i>设置封面</button>
                <form ref="vExample">
                    <input type="file" style="display:none;" ref="vExampleFile" @change="vExampleUpload($event)" id="videoFileId" accept=""/>
                </form>
                <form ref="vExample3">
                    <input type="file" style="display:none;" ref="vExampleFile3" @change="vExampleUpload3($event)" id="videoFileId3" accept=""/>
                </form>
                <form ref="vExample4">
                    <input type="file" style="display:none;" ref="vExampleFile4" @change="vExampleUpload4($event)" id="videoFileId4" accept=""/>
                </form>
            </div>
        </div>
        <div style="height: 45px;"></div>
        {{--<div id="uploadVideo" style="margin-left: 40px; margin-top: 20px; height: 300px;">--}}
            {{--<input type="hidden" id="teachingVideo" />--}}
            {{--<form ref="vExample">--}}
                {{--<input type="file" style="display:none;" ref="vExampleFile" @change="vExampleUpload($event)" id="videoFileId" accept="--}}{{--video/mp4--}}{{--"/>--}}
            {{--</form>--}}
            {{--<div class="btn btn-app btn-default btn-sm pr" style="width: 160px; ">--}}
                {{--<span @click="vExampleAdd" class="ace-icon fa fa-cloud-upload bigger-200" style="font-size: 20px">上传视频</span>--}}
            {{--</div>--}}
        {{--</div>--}}


            {{--<div class="center-in-center" id="txUploadProgress" style="display: none"></div>--}}



        <div class="layui-form-item">
            <label class="layui-form-label">用户</label>
            <div class="layui-input-block">
                <select name="publisher_id" lay-verify="required">
                    @foreach($user_list as $v)
                        <option value="{{$v['id']}}">{{$v['username']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" ng-model="field.title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">话题</label>
            <div class="layui-input-block" style="height: 1px;">
                <input type="text" id="topic_input" name="topic_input" oninput="getNewsTopicList()" placeholder="请输入话题" autocomplete="off" class="layui-input">
                {{--<input type="hidden" name="n_topic" id="n_topic">--}}
                {{--<input type="hidden" name="o_topic" id="o_topic">--}}
                <input type="hidden" name="topic" id="topic">
            </div>
            <div class="layui-input-block" id="topic_select">
                <div style="width: 100%;line-height: 30px;position: absolute; z-index: 10; background-color: white; overflow-y:scroll;margin-top: 3px;">
                    <ul style="max-height: 200px;">

                    </ul>
                </div>
            </div>
        </div>
        <div class="layui-form-item" style="margin-top: -20px;">
            <div class="layui-input-block" id="topic_text">

            </div>
        </div>
        <div id="front_cover">
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" lay-verify="required" name="content" class="layui-textarea"></textarea>
            </div>

        </div>
        <hr class="layui-bg-green">

        <div id="content">



            <input name="num" id="num" type="hidden" value="0">
        </div>


        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="submit">提交</button>
                <a href="{{url('admin/News/index')}}" class="layui-btn layui-btn-primary">返回</a>
            </div>
        </div>


    </div>


    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.21/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
    <script src="https://unpkg.com/vod-js-sdk-v6"></script>

    {{--<script src="{{ URL::asset(_ADMIN_.'vod-js-sdk-v6') }}"></script>--}}
    <script src="{{ URL::asset(_ADMIN_.'js/angular.min.js') }}"></script>
    <script>


        var m = angular.module('hd',[]);

        m.controller('ctrl',['$scope',function($scope) {

            $scope.field = '{!!$info!!}'!='null'? {!!$info!!} :{group_id:'',username:'',loginname:'',mobile:'',status:1};
            if ($scope.field.icon) {
                adPic.src =  $scope.field.icon;
            }
            layui.use(['form','upload'], function(){


                var form = layui.form,upload = layui.upload,$ = layui.jquery;
                $(window).scroll(function () {//为页面添加页面滚动监听事件
                    var wst = $(window).scrollTop(); //滚动条距离顶端值
                    $('#adBtn_all').css("top",(wst+40)+'px');
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
                //普通图片上传
                {{--upload.render({--}}
                    {{--elem: '#adBtn_img'--}}
                    {{--, url: '{{config("common.upload_url")}}'--}}
                    {{--, before: function (obj) {--}}
                        {{--loading =layer.load(1, {shade: [0.1,'#fff']});--}}
                    {{--}, done: function (res) {--}}
                        {{--layer.close(loading);--}}
                        {{--if (res.status > 0) {--}}

                            {{--add(1,res.data.url);--}}

                        {{--} else {--}}
                            {{--//如果上传失败--}}
                            {{--return layer.msg('上传失败');--}}
                        {{--}--}}
                    {{--}--}}
                    {{--, error: function () {--}}
                        {{--layer.close(loading);--}}
                        {{--return layer.msg('上传失败');--}}
                    {{--}--}}
                {{--});--}}
                //封面图片上传
                {{--upload.render({--}}
                    {{--elem: '#adBtn_cover'--}}
                    {{--, url: '{{config("common.upload_url")}}'--}}
                    {{--, before: function (obj) {--}}
                        {{--loading =layer.load(1, {shade: [0.1,'#fff']});--}}
                    {{--}, done: function (res) {--}}
                        {{--layer.close(loading);--}}
                        {{--if (res.status > 0) {--}}
                            {{--add(4,res.data.url);--}}
                        {{--} else {--}}
                            {{--//如果上传失败--}}
                            {{--return layer.msg('上传失败');--}}
                        {{--}--}}
                    {{--}--}}
                    {{--, error: function () {--}}
                        {{--layer.close(loading);--}}
                        {{--return layer.msg('上传失败');--}}
                    {{--}--}}
                {{--});--}}
                {{--upload.render({--}}
                    {{--elem: '#adBtn_video'--}}
                    {{--,url: '{{config("common.upload_url")}}'--}}
                    {{--,accept: 'video' //视频--}}
                    {{--, before: function (obj) {--}}
                        {{--loading =layer.load(1, {shade: [0.1,'#fff']});--}}
                    {{--},done: function(res){--}}
                        {{--layer.close(loading);--}}
                        {{--add(3,res.data.url);--}}
                    {{--}, error: function () {--}}
                        {{--layer.close(loading);--}}
                        {{--return layer.msg('上传失败');--}}
                    {{--}--}}
                {{--});--}}

                window.getNewsTopicList = function(){
                    loading =layer.load(1, {shade: [0.1,'#fff']});
                    var value = $("#topic_input").val();
                    value = value.replace(/^\s+|\s+$/g, "");
                    if(value != null && value != '' && value != undefined){
                        $.post('{{url("admin/Topic/getTopicList")}}',{'title':value},function (res) {
                            $('#topic_select ul li').remove();
                            layer.close(loading);
                            if (res.code==1) {
                                $('#topic_select ul').append("<li onclick='close_topic();' style='border-bottom:#E6E6E6 1px solid;padding-left: 10px; text-align: right; cursor: hand;'>关闭</li>");
                                $.each(res.data,function(index,item){
                                    $('#topic_select ul').append("<li onclick='set_topic(\""+item.title+"\","+item.id+","+item.type+");' style='border-bottom:#E6E6E6 1px solid;padding-left: 10px;'>"+item.title+"</li>");
                                });

                            }else{
                                $('#topic_select ul').append("<li onclick='close_topic();' style='border-bottom:#E6E6E6 1px solid;padding-left: 10px; text-align: right; cursor: hand;'>关闭</li>");
                                $('#topic_select ul').append("<li onclick='set_topic(\""+value+"\",0,1);' style='border-bottom:#E6E6E6 1px solid;padding-left: 10px;'>添加新话题</li>");

                            }
                        });
                    }else{
                        $('#topic_select ul li').remove();
                        layer.close(loading);
                    }


                };
                window.set_topic = function(title,id,type){
                    loading =layer.load(1, {shade: [0.1,'#fff']});
                    title = title.replace(/^\s+|\s+$/g,"");
                    if(title == undefined || title == '' || title == null){
                        layer.close(loading);
                        close_topic();
                        return false;
                    }
                    $('#topic_select ul li').remove();
                    {{--if(id == undefined || id == null || id == ''){--}}
                        {{--$.post('{{url("admin/Topic/newsFormAdd")}}',{'title':title},function (res) {--}}
                            {{--if (res.code==1) {--}}
                                {{--$('#n_topic').val($('#n_topic').val()+res.data+"#"+1+"#"+title+",");--}}
                                {{--$('#topic_text').append('<span id="topic'+res.data+'" style="padding: 10px; border: 1px solid #E6E6E6; margin-left: 10px;" onclick="del_topic('+res.data+',1,1);">#'+title+'</span>');--}}
                            {{--}else{--}}
                                {{--layer.msg(res.msg, {time: 1800, icon: 2});--}}
                            {{--}--}}
                            {{--return false;--}}
                        {{--});--}}
                        {{--$('#n_topic').val($('#n_topic').val()+"0#1#"+title+",");--}}
                        {{--$('#topic_text').append('<span id="topic'+res.data+'" style="padding: 10px; border: 1px solid #E6E6E6; margin-left: 10px;" onclick="del_topic(0,1,1);">#'+title+'</span>');--}}

                    {{--}else{--}}
                        {{--$('#o_topic').val($('#o_topic').val()+id+"#"+type+"#"+title+",");--}}
                        {{--$('#topic_text').append('<span id="topic'+id+'" style="padding: 10px; border: 1px solid #E6E6E6; margin-left: 10px;" onclick="del_topic('+id+',0,'+type+');">#'+title+'</span>');--}}
                    {{--}--}}
                    $('#topic_input').val('');
                    topic = $('#topic').val();
                    topic_array = topic.split(","); //字符分割
                    for(let i= 0; i<topic_array.length;i++){
                        if(topic_array[i] == (id+"#"+type+"#"+title)){
                            layer.close(loading);
                            return false;
                        }
                    }
                    $('#topic').val($('#topic').val()+id+"#"+type+"#"+title+",");
                    $('#topic_text').append('<span id="topic'+title+'" style="padding: 10px; border: 1px solid #E6E6E6; margin-left: 10px;" onclick="del_topic('+id+','+type+',\''+title+'\');">#'+title+'</span>');

                    layer.close(loading);
                }
                window.del_topic = function (id,type,title) {
                    $('#topic'+title).remove();
                    topic = $('#topic').val();
                    topic_array = topic.split(","); //字符分割
                    console.log(topic_array);
                    console.log(id+"#"+type+"#"+title);
                    for(let i= 0; i<topic_array.length; i++){
                        if(topic_array[i] == (id+"#"+type+"#"+title) || topic_array[i] == undefined || topic_array[i] == '' || topic_array[i] == null){
                            topic_array.splice(i, 1);
                            break;
                        }
                    }
                    console.log(topic_array);
                    if(topic_array != undefined && topic_array != null && topic_array != ''){
                        $('#topic').val(topic_array.join(','));
                    }else{
                        $('#topic').val('');
                    }
                    {{--if(type == 1){--}}
                        {{--n_topic = $('#n_topic').val();--}}
                        {{--if(n_topic != undefined && n_topic != null && n_topic != ''){--}}
                            {{--n_topic_array = [];--}}
                            {{--n_topic_array = n_topic.split(","); //字符分割--}}
                            {{--for(let i= 0,flag = true; i<n_topic_array.length; flag ? i++ : i){--}}
                                {{--if(n_topic_array[i] == id || n_topic_array[i] == undefined || n_topic_array[i] == '' || n_topic_array[i] == null){--}}
                                    {{--n_topic_array.splice(i, 1);--}}
                                    {{--flag = false;--}}
                                {{--} else {--}}
                                    {{--flag = true;--}}
                                {{--}--}}
                            {{--}--}}
                            {{--if(n_topic_array != undefined && n_topic_array != null && n_topic_array != ''){--}}
                                {{--$('#n_topic').val(n_topic_array.join(','));--}}
                            {{--}else{--}}
                                {{--$('#n_topic').val('');--}}
                            {{--}--}}
                            {{--$.post('{{url("admin/Topic/del")}}',{'id':id},function (res) {});--}}
                        {{--}--}}
                    {{--}else{--}}
                        {{--var o_topic = $('#o_topic').val();--}}
                        {{--if(o_topic != undefined && o_topic != null && o_topic != ''){--}}
                            {{--var o_topic_array = new Array(); //定义一数组--}}
                            {{--o_topic_array = o_topic.split(","); //字符分割--}}
                            {{--for(let i= 0,flag = true; i<o_topic_array.length; flag ? i++ : i){--}}
                                {{--if(o_topic_array[i] == id || o_topic_array[i] == undefined || o_topic_array[i] == '' || o_topic_array[i] == null){--}}
                                    {{--o_topic_array.splice(i, 1);--}}
                                    {{--flag = false;--}}
                                {{--} else {--}}
                                    {{--flag = true;--}}
                                {{--}--}}
                            {{--}--}}
                            {{--if(o_topic_array != undefined && o_topic_array != null && o_topic_array != ''){--}}
                                {{--$('#o_topic').val(o_topic_array.jopin(','));--}}
                            {{--}else{--}}
                                {{--$('#o_topic').val('');--}}
                            {{--}--}}
                        {{--}--}}
                    {{--}--}}
                }

                window.add = function(type,url,video_cloud_id){
                    num = $("#num").val();
                    if(num >= 200){
                        alert('不能点200次！');return false;
                    }
                    if(type == 2){
                        var appendHtml =
                                "<div id=\"add_"+num+"\">"+
                                "<div class=\"layui-form-item layui-form-text\">"+
                                "<label class=\"layui-form-label\">内容</label>"+
                                "<div class=\"layui-input-block\">"+
                                "<textarea placeholder=\"请输入内容\" name=\"desc_"+num+"\" class=\"layui-textarea\"></textarea>"+
                                "</div>"+
                                "<input name=\"sort_"+num+"\" type=\"hidden\" value=\""+num+"\">"+
                                "<input name=\"type_"+num+"\" type=\"hidden\" value=\"2\">"+
                                "<div class=\"layui-input-block\">"+
                                "<button type=\"button\"  class=\"layui-btn layui-btn-danger\" onclick=\"return deleted("+num+");\">删除</button>"+
                                "<button type=\"button\"  class=\"layui-btn\" onclick=\"return move("+num+",'up')\"><i class=\"layui-icon layui-icon-up\">&#xe619;</i></button>"+
                                "<button type=\"button\"  class=\"layui-btn\" onclick=\"return move("+num+",'down')\"><i class=\"layui-icon layui-icon-down\">&#xe61a;</i></button>"+
                                "</div>"+
                                "</div>"+
                                "<hr class=\"layui-bg-green\">"+
                                "</div>";

                    }else if(type == 1){
                        var appendHtml =
                                "<div id=\"add_"+num+"\">"+
                                "<div class=\"layui-form-item layui-form-text\">"+
                                "<div style=\"margin-bottom: 10px;\">"+
                                "<img src=\""+url+"\" style=\"max-height: 400px; max-width: 400px;\">"+
                                "<input type=\"hidden\" value=\""+url+"\" name=\"url_"+num+"\">"+
                                "<input type=\"hidden\" value=\""+video_cloud_id+"\" name=\"video_cloud_id_"+num+"\">"+
                                "</div>"+
                                "<div class=\"layui-input-block\">"+
                                "<textarea placeholder=\"请输入描述\" name=\"desc_"+num+"\" class=\"layui-textarea\"></textarea>"+
                                "</div>"+
                                "<input type=\"hidden\" name=\"sort_"+num+"\">"+
                                "<input name=\"type_"+num+"\" id=\"type_"+num+"\" type=\"hidden\" value=\"1\">"+
                                "<div class=\"layui-input-block\">"+
                                "<button type=\"button\"  class=\"layui-btn layui-btn-danger\" onclick=\"return deleted("+num+");\">删除</button>"+
                                "<button type=\"button\"  class=\"layui-btn\" onclick=\"return move("+num+",'up')\"><i class=\"layui-icon layui-icon-up\">&#xe619;</i></button>"+
                                "<button type=\"button\"  class=\"layui-btn\" onclick=\"return move("+num+",'down')\"><i class=\"layui-icon layui-icon-down\">&#xe61a;</i></button>"+
                                "</div>"+
                                "</div>"+
                                "<hr class=\"layui-bg-green\">"+
                                "</div>";

                    }else if(type == 3){
                        var appendHtml =
                                "<div id=\"add_"+num+"\">"+
                                "<div class=\"layui-form-item layui-form-text\">"+
                                "<div style=\"margin-bottom: 10px;\" id=\"embed_"+num+"\">"+
                                "<embed src=\""+url+"\" style=\"max-height: 400px; max-width: 400px;\"/>"+
                                "</div>"+
                                "<input type=\"hidden\" value=\""+url+"\" name=\"url_"+num+"\">"+
                                "<input type=\"hidden\" value=\""+video_cloud_id+"\" name=\"video_cloud_id_"+num+"\">"+
                                "<div class=\"layui-input-block\">"+
                                "<textarea placeholder=\"请输入描述\" name=\"desc_"+num+"\" class=\"layui-textarea\"></textarea>"+
                                "</div>"+
                                "<input type=\"hidden\" name=\"sort_"+num+"\">"+
                                "<input name=\"type_"+num+"\" type=\"hidden\" value=\"3\">"+
                                "<div class=\"layui-input-block\">"+
                                "<button type=\"button\"  class=\"layui-btn layui-btn-danger\" onclick=\"return deleted("+num+");\">删除</button>"+
                                "<button type=\"button\"  class=\"layui-btn\" onclick=\"return move("+num+",'up')\"><i class=\"layui-icon layui-icon-up\">&#xe619;</i></button>"+
                                "<button type=\"button\"  class=\"layui-btn\" onclick=\"return move("+num+",'down')\"><i class=\"layui-icon layui-icon-down\">&#xe61a;</i></button>"+
                                "</div>"+
                                "</div>"+
                                "<hr class=\"layui-bg-green\">"+
                                "</div>";
                    }else if(type == 4){
                        var appendHtml =
                                "<div>"+
                                "<div class=\"layui-form-item layui-form-text\">"+
                                "<div style=\"margin-bottom: 10px;\">"+
                                "<label class=\"layui-form-label\">封面图</label>"+
                                "<img src=\""+url+"\" style=\"max-height: 400px; max-width: 400px;\">"+
                                "<input type=\"hidden\" value=\""+url+"\" name=\"cover_url\">"+

                                "</div>"+
//                                    "<div class=\"layui-input-inline\">"+
//                                        "<button type=\"button\"  class=\"layui-btn layui-btn-danger\" onclick=\"return deleted("+num+");\">删除</button>"+
//                                    "</div>"+
                                "</div>"+
                                "<hr class=\"layui-bg-green\">"+
                                "</div>";

                        $("#front_cover").html(appendHtml);
                        return false;
                    }

                    $("#content").append(appendHtml);
                    $("#num").val(Number(num) + 1);

                }
                window.close_topic = function(){
                    $('#topic_select ul li').remove();
                }
                window.deleted = function (k){
                    var num = $("#num").val();
                    $("#add_"+k+"").remove();

                }
                window.move = function(num,action){
                    total_num = $("#num").val();
                    if(action == 'up'){
                        for(i=(Number(num) - 1);i>=0;i--){
                            if($("input[name='type_"+i+"']").val() != undefined){
                                var id = i;
                                break;
                            }
                        }
                        //id = Number(num) - 1;
                    }else{
                        total_num = $("#num").val();

                        for(i=(Number(num) + 1);i<total_num;i++){
                            if($("input[name='type_"+i+"']").val() != undefined){
                                var id = i;
                                break;
                            }
                        }
                    }
                    if(id == undefined){
                        return layer.msg('禁止操作');
                    }
                    //console.log('num:'+num+',id:'+id);
                    num_type = $("input[name='type_"+num+"']").val();
                    id_type = $("input[name='type_"+id+"']").val();

                    num_desc = $("textarea[name='desc_"+num+"']").val();
                    id_desc = $("textarea[name='desc_"+id+"']").val();

                    if(num_type != 2){
                        num_url = $("input[name='url_"+num+"']").val();
                        if(num_type == 3){
                            $("#embed_"+num).html("");
                        }
                    }
                    if(id_type != 2){
                        id_url = $("input[name='url_"+id+"']").val();
                        if(id_type == 3){
                            $("#embed_"+id).html("");
                        }
                    }

                    //console.log('num_desc:'+num_desc+',id_desc:'+id_desc);
                    num_content = $("#add_"+num+"").html();

                    num_old_str = num;
                    num_new_str = id;
                    reg_exp_1 = new RegExp(num_old_str,'gm');
                    num_content = num_content.replace(reg_exp_1,num_new_str);
                    id_old_str = id;
                    id_new_str = num;
                    reg_exp_2 = new RegExp(id_old_str,'gm');
                    id_content = $("#add_"+id+"").html();
                    id_content = id_content.replace(reg_exp_2,id_new_str);

                    //console.log('num_content:'+num_content+',id_content:'+id_content);
                    $("#add_"+id+"").html(num_content);
                    $("#add_"+num+"").html(id_content);

                    $("input[name='type_"+num+"']").val(id_type);
                    $("input[name='type_"+id+"']").val(num_type);
                    $("textarea[name='desc_"+num+"']").val(id_desc);
                    $("textarea[name='desc_"+id+"']").val(num_desc);
                    if(num_type != 2){
                        $("input[name='url_"+id+"']").val(num_url);
                        if(num_type == 1){
                            $("#add_"+id+" img").attr('src',num_url);
                        }else if(num_type == 3){
                            //$("#add_"+id+"embed").attr('src',num_url);
                            $("#embed_"+id).html("<embed src=\""+num_url+"\" style=\"max-height: 400px; max-width: 400px;\"/>");
                        }
                    }
                    if(id_type != 2){
                        $("input[name='url_"+num+"']").val(id_url);
                        if(id_type == 1){
                            $("#add_"+num+" img").attr('src',id_url);
                        }else if(id_type == 3){
                            //$("#add_"+num+" embed").attr('src',id_url);
                            $("#embed_"+num).html("<embed src=\""+id_url+"\" style=\"max-height: 400px; max-width: 400px;\"/>");
                        }
                    }
                }

                var progressId = 'txUploadProgress';// 上传进度id
                /**
                 * 加载和上传视频: 页面初始化时调用, 可以直接通过视频url加载视频到页面
                 * 除maxSize字段非必传外, 其他字段均必传, 否则后果自负
                 * @param formId form表单id
                 * @param name 与后端绑定的name字段, 如shortVideo字段, 此字段必须与隐藏域id字段相同, 即id name一致
                 * @param uploadVideoDivId 视频上传相关的div块id
                 * @param videoFileId 视频文件id, 此字段作用是解决vue无法再次上传相同文件的问题, 将此id值清空即可再次上传
                 * @param maxSize 文件大小, M为单位, 不传表示不限制文件大小
                 */
                function loadAndUploadVideo(formId, name, uploadVideoDivId, videoFileId, maxSize) {
                    //loadVideo(uploadVideoDivId, name);
                    uploadVideo(formId, name, uploadVideoDivId, videoFileId, maxSize)
                }
                /**
                 * 加载视频
                 * @param uploadVideoDivId 将视频追加到此id后面
                 * @param name 根据name获取原视频值, 因此id与name字段必须相同才能拿到旧值
                 */
                function loadVideo(uploadVideoDivId, name) {
                    var oldVideoUrl = $("#" + name).val();
                    if (oldVideoUrl != null && oldVideoUrl != ""){
                        var str = '';
                        str += '<div class="video">' ;
                        str += '    <video src="'+oldVideoUrl+'" controls="controls" >';
                        str += '</div>';
                        $("#" + uploadVideoDivId + " .video").remove();
                        $("#" + uploadVideoDivId).append(str);
                    }
                }
                /**
                 * 上传视频, 腾讯云官方demo + 改造
                 * @param formId
                 * @param name
                 * @param uploadVideoDivId
                 * @param videoFileId
                 * @param maxSize 文件大小, M为单位, 不传表示不限制文件大小
                 */
                function uploadVideo(formId, name, uploadVideoDivId, videoFileId, maxSize) {

                    // 获取签名, 腾讯云要求直接上传视频的客户端必须获取签名
                    function getSignature() {
                        return "{{$signature}}";
                    };

                    var app = new Vue({
                        el: '#' + uploadVideoDivId,
                        data: {
                            uploaderInfos: [],
                        },
                        created: function () {
                            this.tcVod = new TcVod.default({
                                getSignature: getSignature
                            })
                        },
                        methods: {
                            vExampleAdd: function () {
                                this.$refs.vExampleFile.click()
                            },
                            vExampleUpload: function (event) {
                                if (!checkVideo(event, maxSize, videoFileId)) {
                                    return;
                                }
                                onVideoSelected();
                                var self = this;
                                var videoFile = this.$refs.vExampleFile.files[0];
                                console.log(this.$refs.vExampleFile.files);
                                var uploader = this.tcVod.upload({
                                    videoFile: videoFile,
                                })
                                uploader.on('video_progress', function (info) {
                                    uploaderInfo.progress = info.percent;
                                    // 上传进度
                                    var percent = Math.floor(uploaderInfo.progress * 100) + '%'
                                    $("#" + progressId).text("正在上传 : " + percent)
                                })
                                uploader.on('video_upload', function (info) {
                                    uploaderInfo.isVideoUploadSuccess = true;
                                })
                                var uploaderInfo = {
                                    videoInfo: uploader.videoInfo,
                                    isVideoUploadSuccess: false,
                                    isVideoUploadCancel: false,
                                    progress: 0,
                                    fileId: '',
                                    videoUrl: '',
                                    cancel: function() {
                                        uploaderInfo.isVideoUploadCancel = true;
                                        uploader.cancel()
                                    },
                                }
                                this.uploaderInfos.push(uploaderInfo)
                                uploader.done().then(function(doneResult) {
                                    uploaderInfo.fileId = doneResult.fileId;
                                    return doneResult.video.url;
                                }).then(function (videoUrl) {
                                    uploaderInfo.videoUrl = videoUrl
                                    onVideoUploaded(formId, name, videoUrl, videoFileId, uploadVideoDivId);
                                    add(1,videoUrl,uploaderInfo.fileId);
                                })
                            },

                            vExampleAdd3: function () {
                                this.$refs.vExampleFile3.click()
                            },
                            vExampleUpload3: function (event) {
                                if (!checkVideo(event, maxSize, videoFileId+"3")) {
                                    return;
                                }
                                onVideoSelected();
                                var self = this;
                                var videoFile = this.$refs.vExampleFile3.files[0];
                                //console.log(this.$refs.vExampleFile.files);
                                var uploader = this.tcVod.upload({
                                    videoFile: videoFile,
                                })
                                uploader.on('video_progress', function (info) {
                                    uploaderInfo.progress = info.percent;
                                    // 上传进度
                                    var percent = Math.floor(uploaderInfo.progress * 100) + '%'
                                    $("#" + progressId).text("正在上传 : " + percent)
                                })
                                uploader.on('video_upload', function (info) {
                                    uploaderInfo.isVideoUploadSuccess = true;
                                })
                                var uploaderInfo = {
                                    videoInfo: uploader.videoInfo,
                                    isVideoUploadSuccess: false,
                                    isVideoUploadCancel: false,
                                    progress: 0,
                                    fileId: '',
                                    videoUrl: '',
                                    cancel: function() {
                                        uploaderInfo.isVideoUploadCancel = true;
                                        uploader.cancel()
                                    },
                                }
                                this.uploaderInfos.push(uploaderInfo)
                                uploader.done().then(function(doneResult) {
                                    uploaderInfo.fileId = doneResult.fileId;
                                    return doneResult.video.url;
                                }).then(function (videoUrl) {
                                    uploaderInfo.videoUrl = videoUrl
                                    onVideoUploaded(formId, name, videoUrl, videoFileId+"3", uploadVideoDivId);
                                    add(3,videoUrl,uploaderInfo.fileId);
                                })
                            },
                            vExampleAdd4: function () {
                                this.$refs.vExampleFile4.click()
                            },
                            vExampleUpload4: function (event) {
                                if (!checkVideo(event, maxSize, videoFileId+"4")) {
                                    return;
                                }

                                onVideoSelected();

                                var self = this;
                                var videoFile = this.$refs.vExampleFile4.files[0];

                                var uploader = this.tcVod.upload({
                                    videoFile: videoFile,
                                })
                                uploader.on('video_progress', function (info) {
                                    uploaderInfo.progress = info.percent;
                                    // 上传进度
                                    var percent = Math.floor(uploaderInfo.progress * 100) + '%'
                                    $("#" + progressId).text("正在上传 : " + percent)
                                })
                                uploader.on('video_upload', function (info) {
                                    uploaderInfo.isVideoUploadSuccess = true;
                                })
                                var uploaderInfo = {
                                    videoInfo: uploader.videoInfo,
                                    isVideoUploadSuccess: false,
                                    isVideoUploadCancel: false,
                                    progress: 0,
                                    fileId: '',
                                    videoUrl: '',
                                    cancel: function() {
                                        uploaderInfo.isVideoUploadCancel = true;
                                        uploader.cancel()
                                    },
                                }
                                this.uploaderInfos.push(uploaderInfo)
                                uploader.done().then(function(doneResult) {
                                    uploaderInfo.fileId = doneResult.fileId;
                                    return doneResult.video.url;
                                }).then(function (videoUrl) {
                                    uploaderInfo.videoUrl = videoUrl
                                    onVideoUploaded(formId, name, videoUrl, videoFileId+"4", uploadVideoDivId);
                                    add(4,videoUrl);
                                })
                            }
                        },
                    })
                }
                /**
                 * 选择视频后显示上传进度
                 */
                function onVideoSelected() {
                    loading = layer.load(1, {shade: [0.1,'#fff']});
                    layer.open({
                        title: '进度'
                        ,content: "<div class=\"center-in-center\" id=\"txUploadProgress\" style=\"display: none\"></div>"
                    });
                    $("#" + progressId).text("正在上传 : 0%");
                    $("#" + progressId).show();

                }

                /**
                 * 视频上传完成
                 * @param formId
                 * @param name
                 * @param videoUrl
                 * @param videoFileId
                 * @param uploadVideoDivId
                 */
                function onVideoUploaded(formId, name, videoUrl, videoFileId, uploadVideoDivId) {
                    //endLoadding();
                    $("#" + progressId).hide();

                    layer.msg("上传完成");
                    layer.close(loading);
                    // 上传完成后清空fileId, 否则vue无法再次选择此文件
                    $("#" + videoFileId).val('');

                    // 将上传成功后的视频url追加到表单
                    //formAppendVideo(formId, name, videoUrl);

//                    if (videoUrl != ""){
//                        var str = '';
//                        str += '<div class="video">';
//                        str += '    <video src="'+videoUrl+'" controls="controls" >';
//                        str += '</div>';
//                        $("#" + uploadVideoDivId + " .video").remove();
//                        $("#" + uploadVideoDivId).append(str);
//                    }
                }

                /**
                 * 删除视频, 删除页面视频只需要uploadVideoDivId字段即可, 但同时还应清空form表单的videoUrl
                 * @param formId
                 * @param uploadVideoDivId
                 * @param name
                 */
                function deleteVideo(formId, uploadVideoDivId, name) {
                    $("#" + uploadVideoDivId + " .video").remove();
                    //formAppendVideo(formId, name, null);
                }

                /**
                 * 追加视频url到form
                 * @param formId
                 * @param name
                 * @param videoUrl
                 */
                function formAppendVideo(formId, name, videoUrl){
                    videoUrl = null == videoUrl ? '' : videoUrl;
                    var form = $('#' + formId);
                    var tmpInput = $('<input type="hidden" name="'+name+'" value="'+videoUrl+'" />');
                    form.append(tmpInput);
                }

                /**
                 * 校验视频格式和大小
                 * @param event
                 * @param maxSize 不传表示不限制文件大小
                 * @returns {boolean}
                 */
                function checkVideo(event, maxSize, videoFileId) {

                    var flag = true;
                    var accept = event.target.accept;
                    var file = event.target.files[0];
                    var type = file.type;
//                    if(accept.indexOf(type) == -1) {
//                        layer.msg('文件格式不正确');
//
//                        $("#" + videoFileId).val('')
//                        flag = false;
//                    }
                    if (maxSize != undefined) {
                        if(file.size > 1024 * 1024 * maxSize) {
                            layer.msg('文件不能大于' + maxSize + 'M');
                            $("#" + videoFileId).val('')
                            flag = false;
                        }
                    }
                    return flag
                }
                loadAndUploadVideo('form_id', 'teachingVideo', "uploadVideo", "videoFileId", 200000);
            });
        }]);
    </script>
    </body>
@endsection
