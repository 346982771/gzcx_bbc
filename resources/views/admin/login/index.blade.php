<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
@parent
<body class="loginBody">
	<form class="layui-form" method="post">
		<!--<div class="login_face"><img src="../../images/face.jpg" class="userAvatar"></div>-->
		<div style="height: 80px; line-height: 80px; text-align: center"><h1>后台登录</h1></div>
		<div class="layui-form-item input-item">
			<label for="userName">用户名</label>
			<input type="text" placeholder="请输入用户名" name="username" autocomplete="off" id="username" class="layui-input" lay-verify="required">
		</div>
		<div class="layui-form-item input-item">
			<label for="password">密码</label>
			<input type="password" placeholder="请输入密码" name="password" autocomplete="off" id="password" class="layui-input" lay-verify="required">
		</div>
		<div class="layui-form-item input-item" id="imgCode">
			<label for="code">验证码</label>
			<input type="text" placeholder="请输入验证码" name="captcha" autocomplete="off" id="code" class="layui-input">

				<img src="{{captcha_src()}}" id="captcha_src" style="cursor: pointer" onclick="this.src='{{captcha_src()}}'+Math.random()">


		</div>
		{{--<div class="layui-form-item">--}}
			{{--<select name="is_shop" lay-filter="is_shop">--}}
				{{--<option value="0">系统管理员</option>--}}
				{{--<option value="1">门店管理员</option>--}}
			{{--</select>--}}
		{{--</div>--}}
		<div class="layui-form-item">
			<button class="layui-btn layui-block" lay-filter="login" lay-submit>登录</button>
		</div>
		<!--<div class="layui-form-item layui-row">-->
			<!--<a href="javascript:;" class="seraph icon-qq layui-col-xs4 layui-col-sm4 layui-col-md4 layui-col-lg4"></a>-->
			<!--<a href="javascript:;" class="seraph icon-wechat layui-col-xs4 layui-col-sm4 layui-col-md4 layui-col-lg4"></a>-->
			<!--<a href="javascript:;" class="seraph icon-sina layui-col-xs4 layui-col-sm4 layui-col-md4 layui-col-lg4"></a>-->
		<!--</div>-->
	</form>
</body>

@endsection
@section('js')
@parent
<script type="text/javascript">
	layui.use(['form','layer','jquery'],function(){
		var form = layui.form,
				layer = parent.layer === undefined ? layui.layer : top.layer
		$ = layui.jquery;


		//登录按钮
		form.on("submit(login)",function(data){

			loading =layer.load(1, {shade: [0.1,'#fff'] });//0.1透明度的白色背景

			$.post('{{url("admin/login/index")}}',data.field,function(res){
				layer.close(loading);
				if(res.code == 1){
					layer.msg(res.msg, {icon: 1, time: 1000}, function(){
						location.href = res.url;
					});
				}else{
					$('#captcha').val('');
					layer.msg(res.msg, {icon: 2, anim: 6, time: 1000});
					$('#captcha_src').attr('src','{{captcha_src()}}'+Math.random());
				}
			});
			return false;
			//setTimeout(function(){
			//    window.location.href = "/layuicms2.0";
			//},1000);
			//return false;
		})

		//表单输入效果
		$(".loginBody .input-item").click(function(e){
			e.stopPropagation();
			$(this).addClass("layui-input-focus").find(".layui-input").focus();
		})
		$(".loginBody .layui-form-item .layui-input").focus(function(){
			$(this).parent().addClass("layui-input-focus");
		})
		$(".loginBody .layui-form-item .layui-input").blur(function(){
			$(this).parent().removeClass("layui-input-focus");
			if($(this).val() != ''){
				$(this).parent().addClass("layui-input-active");
			}else{
				$(this).parent().removeClass("layui-input-active");
			}
		})
	})

</script>
<script type="text/javascript" src="{{ URL::asset(_ADMIN_.'js/cache.js') }}"></script>
@endsection