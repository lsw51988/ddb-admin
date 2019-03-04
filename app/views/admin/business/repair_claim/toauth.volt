{% extends '../layouts/business_base.volt' %}

{% block title %}业务管理首页{% endblock %}

{% block content %}
    <span class="layui-breadcrumb">
      <a href="">后台</a>
      <a href="">维修点申领</a>
      <a><cite>待审核</cite></a>
    </span>
    <fieldset class="layui-elem-field">
        <legend>
            搜索框
        </legend>
        <form id="form" class="layui-form layui-container" action="">
            <div class="layui-row layui-form-item">
                <div class="layui-col-md12">
                    <label class="layui-form-label" style="width: 100px;">区域</label>
                    <div class="layui-col-md2" style="margin: 0 10px 0 10px;">
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
            <col width="80">
            <col width="250">
            <col width="120">
            <col width="200">
            <col width="200">
            <col width="200">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>ID</th>
            <th>维修点名称</th>
            <th>申领人名称</th>
            <th>地址</th>
            <th>详细地址</th>
            <th>手机</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for item in data %}
            <tr>
                <td>{{ item['id'] }}</td>
                <td>{{ item['repair_name'] }}</td>
                <td>{{ item['name'] }}</td>
                <td>{{ item['province_name'] }}{{ item['city_name'] }}{{ item['district_name'] }}</td>
                <td>{{ item['address'] }}</td>
                <td>{{ item['mobile'] }}</td>
                <td>{{ item['created_at'] }}</td>
                <td>
                    <button class="layui-btn photo" data-id="{{ item['id'] }}">查看照片</button>
                    <button class="layui-btn layui-btn-warm pass" data-id="{{ item['id'] }}">通过</button>
                    <button class="layui-btn layui-btn-danger refuse" data-id="{{ item['id'] }}">拒绝</button>
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
                        window.location.href = "/admin/business/repairClaim/list?page=" + obj.curr + "&status=1"
                    }
                }
            });

            $(".photo").click(function () {
                $("#viewer").empty();
                var repair_claim_id = $(this).data('id');
                $.ajax({
                    url: "/admin/business/repairClaim/" + repair_claim_id + "/imgs",
                    type: "GET",
                    success: function (res) {
                        if (res.status) {
                            var data = res.data;
                            if (data.length == 0) {
                                layer.msg("无照片");
                                return;
                            }
                            for (var i = 0; i < data.length; i++) {
                                $("#viewer").append('<li><img class="img" src=' + data[i] + '></li>')
                            }
                            layer.open({
                                type: 1,
                                area: ['500px', '200px'],
                                content: $("#viewer")
                            });
                            $("#viewer").show();
                            $('#viewer').viewer();
                            $(".layui-layer-shade").removeClass('layui-layer-shade');
                        } else {
                            layer.msg(res.msg);
                        }
                    },
                    error: function () {
                        layer.msg("请求错误")
                    }
                })
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
                window.location.href = "/admin/business/repairClaim/list?status=1";
            });

            $(".pass").click(function () {
                var repair_claim_id = $(this).data('id');
                var layer_load = layer.load();
                $.ajax({
                    url: "/admin/business/repairClaim/auth",
                    data: {
                        'type': 'pass',
                        'repair_claim_id': repair_claim_id
                    },
                    type: "POST",
                    success: function (res) {
                        if (res.status) {
                            layer.msg('修改成功', function () {
                                window.location.reload();
                            });
                        } else {
                            layer.close(layer_load);
                            layer.msg(res.msg);
                        }
                    },
                    error: function () {
                        layer.close(layer_load);
                        layer.msg("请求错误,请联系大帅比李少文")
                    }
                })
            });

            $(".refuse").click(function () {
                var repair_claim_id = $(this).data('id');
                var layer_load = layer.load();
                $.ajax({
                    url: "/admin/business/repairClaim/auth",
                    data: {
                        'type': 'refuse',
                        'repair_claim_id': repair_claim_id
                    },
                    type: "POST",
                    success: function (res) {
                        if (res.status) {
                            layer.msg('修改成功', function () {
                                window.location.reload();
                            });
                        } else {
                            layer.close(layer_load);
                            layer.msg(res.msg);
                        }
                    },
                    error: function () {
                        layer.close(layer_load);
                        layer.msg("请求错误,请联系大帅比李少文")
                    }
                })
            })
        });
    </script>
{% endblock %}
