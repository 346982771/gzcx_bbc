<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
	@parent
<body class="childrenBody">
<div class="layui-row layui-col-space10">
	<div class="layui-col-md12">
		<blockquote class="layui-elem-quote title">系统基本参数</blockquote>
		<table class="layui-table magt0">
			<colgroup>
				<col width="150">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<td>当前版本</td>
				<td class="version"></td>
			</tr>
			<tr>
				<td>开发作者</td>
				<td class="author"></td>
			</tr>
			<tr>
				<td>网站首页</td>
				<td class="homePage"></td>
			</tr>
			<tr>
				<td>服务器环境</td>
				<td class="server"></td>
			</tr>
			<tr>
				<td>数据库版本</td>
				<td class="dataBase"></td>
			</tr>
			<tr>
				<td>最大上传限制</td>
				<td class="maxUpload"></td>
			</tr>
			<tr>
				<td>当前用户权限</td>
				<td class="userRights"></td>
			</tr>
			</tbody>
		</table>

	</div>

</div>



</body>
@endsection
