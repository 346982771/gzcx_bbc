<!-- 继承layouts模板 -->
@extends('admin.common.admin')
@section('content')
    @parent
    <link rel="stylesheet" href="{{ URL::asset(_ADMIN_.'layui/selects/formSelects-v4.css') }}" media="all" />
<body class="main_body">

<div style="margin-left: 20px;"  ng-app="hd" ng-controller="ctrl" class="layui-form layui-form-pane form_padding layui-anim layui-anim-upbit">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>{{$title}}</legend>
    </fieldset>

        <div class="layui-form-item">
            <label class="layui-form-label">上市时间</label>
            <div class="layui-input-block">
                <input type="text" name="market_time" ng-model="field.market_time" class="layui-input" id="date1">
            </div>
        </div>
        @if(!isset($info1))
            <div class="layui-form-item">
                <label class="layui-form-label">车系</label>
                <div class="layui-input-inline" style="z-index: 1002">
                    <select name="brand" lay-verify="required" lay-filter="brand" lay-search="">
                        <option value="">直接选择或搜索选择</option>
                        @if(!empty($brand))
                            @foreach($brand as $brands)
                                <option value="{{$brands['id']}}" @if(isset($info1) && $info1['brand'] == $brands['id']) selected @endif>{{$brands['ltitle']}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <button class="layui-btn" onclick="get_info()">提取同型号参数</button>
            </div>
        @endif
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" ng-model="field.title"   lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">指导价</label>
            <div class="layui-input-block">
                <input type="text" name="guide_price" ng-model="field.guide_price"   lay-verify="required" placeholder="请输入指导价/万元" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">参考价</label>
            <div class="layui-input-block">
                <input type="text" name="reference_price" ng-model="field.reference_price"   lay-verify="required" placeholder="请输入参考价/万元" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">汽车类型</label>
            <div class="layui-input-block" style="z-index: 100">
                <select name="type" id="type" lay-filter="type">
                    @if(!empty($type))
                        @foreach($type as $types)
                            <option value="{{$types['id']}}" @if(isset($info1) && $info1['type'] == $types['id']) selected @endif>{{$types['title']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">销售状态</label>
            <div class="layui-input-block" style="z-index: 98">
                <select name="status" id="status" lay-verify="required" lay-filter="status">
                    <option value="0" @if(isset($info1) && $info1['status'] == 0) selected @endif>在售</option>
                    <option value="1" @if(isset($info1) && $info1['status'] == 1) selected @endif>停产在售</option>
                    <option value="2" @if(isset($info1) && $info1['status'] == 2) selected @endif>停售</option>
                    <option value="3" @if(isset($info1) && $info1['status'] == 3) selected @endif>即将销售</option>
                </select>
            </div>
        </div>

        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">最大功率</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="max_power" ng-model="field.max_power" placeholder="请输入最大功率" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">最大扭矩</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="max_torque" ng-model="field.max_torque" placeholder="请输入最大扭矩" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">发动机</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="engin" ng-model="field.engin" placeholder="请输入发动机" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">变速箱</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="gearbox" ng-model="field.gearbox" placeholder="请输入变速箱" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">车身结构</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="car_body" ng-model="field.car_body" placeholder="请输入车身结构" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">最高车速</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="max_speed" ng-model="field.max_speed" placeholder="请输入最高车速km/h" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">长*宽*高</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="car_size" ng-model="field.car_size" placeholder="请输入车身长宽高" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">官百里加速</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="official_second_0_100" ng-model="field.official_second_0_100" placeholder="请输入官方0-100km加速/s" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">实百里加速</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="measured_second_0_100" ng-model="field.measured_second_0_100" placeholder="请输入实测0-100km加速/s" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">实测制动</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="braking_distance" ng-model="field.braking_distance" placeholder="请输入实测制动/m" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">工信部油耗</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="official_fuel_consumption" ng-model="field.official_fuel_consumption" placeholder="请输入工信部油耗L/100KM" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">实测油耗</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="measured_fuel_consumption" ng-model="field.measured_fuel_consumption" placeholder="请输入实测油耗L/100KM" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">整车质保</label>--}}
            {{--<div class="layui-input-block">--}}
                {{--<input type="text" name="vehicle_warranty" ng-model="field.vehicle_warranty" placeholder="请输入整车质保" class="layui-input">--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="layui-form-item">
            <div class="clear"><label class="layui-form-label" style="width: 100%; text-align: left">外观颜色</label></div>
            <div style="clear: both"></div>
            <div class="layui-input-4">
                <select name="exterior_color" lay-filter="exterior_color" xm-select="method-value-exterior-color">
                    @if(!empty($color))
                        @foreach($color as $colors)
                            <option value="{{$colors['id']}}">{{$colors['title']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="layui-form-item">

            <div class="clear"><label class="layui-form-label" style="width: 100%; text-align: left">内饰颜色</label></div>
            <div style="clear: both"></div>
            <div class="layui-input-4">
                <select name="interior_color" lay-filter="interior_color" xm-select="method-value-interior-color">
                    @if(!empty($color))
                        @foreach($color as $colors)
                            <option value="{{$colors['id']}}">{{$colors['title']}}</option>
                        @endforeach
                    @endif
                </select>
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
                <a href="{{url('admin/Car/index')}}" class="layui-btn layui-btn-primary">返回</a>
            </div>
        </div>


</div>
<script src="{{ URL::asset(_ADMIN_.'js/angular.min.js') }}"></script>
<script src="{{ URL::asset(_ADMIN_.'layui/selects/formSelects-v4.js') }}" type="text/javascript" charset="utf-8"></script>
<script>
    var m = angular.module('hd',[]);

    m.controller('ctrl',['$scope',function($scope) {

        $scope.field = '{!!$info!!}'!='null'? {!!$info!!} :{sort:50,max_power:'-',max_torque:'-',engin:'-',gearbox:'-',
            car_body:'-',max_speed:'-',car_size:'-',official_second_0_100:'-',measured_second_0_100:'-',braking_distance:'-',official_fuel_consumption:'-',measured_fuel_consumption:'-'};

        layui.use(['form','upload','laydate'], function(){
            var form = layui.form,upload = layui.upload,$= layui.jquery,laydate = layui.laydate;
            var formSelects = layui.formSelects;



            if($scope.field.exterior_color != null && $scope.field.exterior_color != ''){
                formSelects.value('method-value-exterior-color', $scope.field.exterior_color.split(","));
            }
            if($scope.field.interior_color != null && $scope.field.interior_color != ''){
                formSelects.value('method-value-interior-color', $scope.field.interior_color.split(","));
            }
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
            //年月选择器
            laydate.render({
                elem: '#date1'
                ,type: 'month'
                ,format: 'yyyy.MM'
            });
            window.get_info = function ()
            {
                market_time = $('input[name="market_time"]').val();
                brand = $('select[name="brand"]').val();
                if(!brand ){
                    layer.msg('请选择车系', {time: 1800, icon: 2});
                    return false;
                }
                $.post('{{url("admin/Car/getInfo")}}',{'brand':brand,'market_time':market_time},function (res) {

                    if (res.code==1) {
                        //$("select[name='status']").find("option:"+res.data.status).attr("selected", "selected");
                        $("select[name='status']").val(res.data.status);
                        $("select[name='type']").val(res.data.type);
                        if(res.data.exterior_color != null && res.data.exterior_color != ''){
                            formSelects.value('method-value-exterior-color', res.data.exterior_color.split(","));
                        }
                        if(res.data.interior_color != null && res.data.interior_color != ''){
                            formSelects.value('method-value-interior-color', res.data.interior_color.split(","));
                        }
                        form.render();
                        $('input[name="market_time"]').val(res.data.market_time);
                        $('input[name="title"]').val(res.data.title);
                        $('input[name="guide_price"]').val(res.data.guide_price);
                        $('input[name="reference_price"]').val(res.data.reference_price);

//                        $('input[name="max_power"]').val(res.data.max_power);
//                        $('input[name="max_torque"]').val(res.data.max_torque);
//                        $('input[name="engin"]').val(res.data.engin);
//                        $('input[name="gearbox"]').val(res.data.gearbox);
//                        $('input[name="car_size"]').val(res.data.car_size);
//                        $('input[name="official_second_0_100"]').val(res.data.official_second_0_100);
//                        $('input[name="measured_second_0_100"]').val(res.data.measured_second_0_100);
//                        $('input[name="official_fuel_consumption"]').val(res.data.official_fuel_consumption);
//                        $('input[name="measured_fuel_consumption"]').val(res.data.measured_fuel_consumption);
//                        $('input[name="braking_distance"]').val(res.data.braking_distance);
//                        $('input[name="car_body"]').val(res.data.car_body);
//                        $('input[name="max_speed"]').val(res.data.max_speed);
//
//                        $('input[name="vehicle_warranty"]').val(res.data.vehicle_warranty);

                    }else{
                        layer.msg(res.msg,{time:1000,icon:2});
                        return false;
                    }
                })

            }
        });
    }]);

</script>
</body>
@endsection