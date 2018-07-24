{% extends '../layouts/business_base.volt' %}

{% block title %}业务管理首页{% endblock %}

{% block content %}
    <span class="layui-breadcrumb">
      <a href="">后台</a>
      <a href="">骑行者</a>
      <a><cite>总览</cite></a>
    </span>
    <fieldset class="layui-elem-field">
        <legend>
            搜索框
        </legend>
        <form id="form" class="layui-form layui-container" action="">
            <div class="layui-row layui-form-item ">
                <div class="layui-col-md4">
                    <label class="layui-form-label">姓名</label>
                    <div class="layui-input-block">
                        <input type="text" name="real_name" placeholder="请输入姓名" autocomplete="off" class="layui-input"
                               value="{{ search['real_name'] }}">
                    </div>
                </div>
                <div class="layui-col-md4">
                    <label class="layui-form-label">手机号</label>
                    <div class="layui-input-block">
                        <input type="text" name="mobile" placeholder="请输入手机号" autocomplete="off" class="layui-input"
                               value="{{ search['mobile'] }}">
                    </div>
                </div>
            </div>
            <div class="layui-row layui-form-item">
                <div class="layui-col-md12">
                    <label class="layui-form-label">区域</label>
                    <div class="layui-col-md2" style="margin-right: 10px;">
                        <select lay-filter="province" name="province" class="province" value="{{ search['province'] }}">
                        </select>
                    </div>
                    <div class="layui-col-md2" style="margin-right: 10px;">
                        <select lay-filter="city" name="city" class="city" value="{{ search['city'] }}">
                        </select>
                    </div>
                    <div class="layui-col-md2">
                        <select name="district" class="district" value="{{ search['district'] }}">
                        </select>
                    </div>
                </div>
            </div>
            <div class="layui-row layui-form-item ">
                <div class="layui-col-md12">
                    <label class="layui-form-label">类型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="type" value="1" title="骑行者"
                               {% if search['type']==1 %}checked{% endif %}>
                        <input type="radio" name="type" value="2" title="修理者"
                               {% if search['type']==2 %}checked{% endif %}>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
                    <button type="reset" id="reset" lay-filter="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </fieldset>

    <table class="layui-table">
        <colgroup>
            <col width="120">
            <col width="150">
            <col width="120">
            <col width="150">
            <col width="120">
            <col width="120">
            <col width="120">
            <col width="120">
            <col width="150">
            <col width="120">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>ID</th>
            <th>姓名</th>
            <th>性别</th>
            <th>手机号</th>
            <th>类型</th>
            <th>省</th>
            <th>市</th>
            <th>区</th>
            <th>照片</th>
            <th>提交时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for member in data %}
            <tr>
                <td>{{ member['id'] }}</td>
                <td>{{ member['real_name'] }}</td>
                <td>{{ member['gender']=="1"?"男":"女" }}</td>
                <td>{{ member['mobile'] }}</td>
                <td>{{ member['type']=="1"?"骑行者":"修理者" }}</td>
                <td>{{ member['province_name'] }}</td>
                <td>{{ member['city_name'] }}</td>
                <td>{{ member['district_name'] }}</td>
                <td>{{ member['updated_at'] }}</td>
                <td>
                    <button class="layui-btn photo" data-id="{{ member['id'] }}">查看照片</button>
                </td>
                <td>
                    <a href="https://www.baidu.com/">
                        <button class="layui-btn detail" data-id="{{ member['id'] }}">详情</button>
                    </a>
                </td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
    <div id="page"></div>

    <ul id="viewer" style="display:none;padding:20px;height:80px;">
    </ul>

{% endblock %}

{% block css %}
    <style type="text/css">
        .img {
            width: 80px;
            height: 80px;
            display: inline-block;
            float: left;
            margin-right: 10px;
            cursor: pointer;
        }
    </style>
{% endblock %}
{% block scripts %}
    <script>
        $(document).ready(function () {

        });
        layui.use(['laypage', 'jquery', 'form', 'layer'], function () {
            var laypage = layui.laypage;
            var form = layui.form;
            var layer = layui.layer;
            var $ = layui.$;

            laypage.render({
                elem: 'page'
                , count: {{ total }}
                , limit: 20
                , curr:{{ page }}
                , jump: function (obj, first) {
                    if (!first) {
                        window.location.href = "/admin/business/member/list?page=" + obj.curr
                    }
                }
            });
            var requestFlag = false;
            $(".photo").click(function () {
                var member_id = $(this).data('id');
                if(!requestFlag){
                    $.ajax({
                        url: "/admin/business/member/" + member_id + "/imgs",
                        method: "GET",
                        success: function (res) {
                            requestFlag = true;
                            var data = res.data;
                            for (var i = 0; i < data.length; i++) {
                                $("#viewer").append('<li><img class="img" src=' + data[i] + '></li>')
                            }
                            layer.open({
                                type: 1,
                                area: '500px',
                                content: $("#viewer")
                            });
                            $("#viewer").show();
                            $('#viewer').viewer();
                            $(".layui-layer-shade").removeClass('layui-layer-shade');
                        },
                        error: function () {
                            layer.msg("请求错误")
                        }
                    })
                }else{
                    layer.open({
                        type: 1,
                        area: '500px',
                        content: $("#viewer")
                    });
                    $("#viewer").show();
                    $('#viewer').viewer();
                    $(".layui-layer-shade").removeClass('layui-layer-shade');
                }
            });

            function getProvinces() {
                $.ajax({
                    type: 'get',
                    url: '/area/provinces',
                    dataType: 'json',
                }).done(function (data, textStatus, jqXHR) {
                    if (data.status) {
                        $('.province').empty();
                        $('.province').append('<option value="">省</option>');
                        var data = data.data;
                        for (var i = 0; i < data.length; i++) {
                            $('.province').append('<option value="' + data[i].code + '">' + data[i].name + '</option>');
                        }
                        form.render();
                    }
                })
            }

            function getCities(id) {
                if (!id || 0 == id.length) {
                    return;
                }
                $.ajax({
                    type: 'get',
                    url: '/area/province/' + id,
                    dataType: 'json'
                }).done(function (data, textStatus, jqXHR) {
                    if (data.status) {
                        $('.district').empty();
                        $('.district').append('<option value="">区</option>');
                        $('.city').empty();
                        $('.city').append('<option value="">市</option>');
                        var data = data.data;
                        for (var i = 0; i < data.length; i++) {
                            $('.city').append('<option value="' + data[i].code + '">' + data[i].name + '</option>');
                        }
                        form.render();
                        var city = $('.city').val();
                        if (city) {
                            $('.city').val(city);
                            getDistricts(city);
                        }
                    }
                })
            }

            function getDistricts(id) {
                if (!id || 0 == id.length) {
                    return;
                }
                $.ajax({
                    type: 'get',
                    url: '/area/city/' + id,
                    dataType: 'json'
                }).done(function (data, textStatus, jqXHR) {
                    if (data.status) {
                        $('.district').empty();
                        $('.district').append('<option value="">区</option>');
                        var data = data.data;
                        for (var i = 0; i < data.length; i++) {
                            $('.district').append('<option value="' + data[i].code + '">' + data[i].name + '</option>');
                        }
                        form.render();
                        var district = $('.district').val();
                        if (district) {
                            $('.district').val(district);
                        }
                    }
                })
            }

            getProvinces();

            form.on("select(province)", function (data) {
                var id = data.value
                getCities(id);
            })
            form.on("select(city)", function (data) {
                var id = data.value
                getDistricts(id);
            })
            $("#reset").click(function () {
                window.location.href = "/admin/business/member/list";
            });
        });
    </script>
{% endblock %}
