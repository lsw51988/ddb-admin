{% extends '../layouts/business_base.volt' %}

{% block title %}业务管理首页{% endblock %}

{% block content %}
    <span class="layui-breadcrumb">
      <a href="">后台</a>
      <a href="">维修点</a>
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
                        <input type="text" name="name" placeholder="请输入姓名" autocomplete="off" class="layui-input"
                               value="{{ search['name'] }}">
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
                        <input type="radio" name="type" value="0" title="电动车维修点"
                               {% if search['type']==0 %}checked{% endif %}>
                        <input type="radio" name="type" value="1" title="电动车维修兼销售点"
                               {% if search['type']==1 %}checked{% endif %}>
                        <input type="radio" name="type" value="2" title="便民开锁点"
                               {% if search['type']==2 %}checked{% endif %}>
                    </div>
                </div>
            </div>
            <div class="layui-row layui-form-item ">
                <div class="layui-col-md12">
                    <label class="layui-form-label">审核状态</label>
                    <div class="layui-input-block">
                        <input type="radio" name="status" value="99" title="全部"
                               {% if search['status']==99 %}checked{% endif %}>
                        <input type="radio" name="status" value="2" title="通过"
                               {% if search['status']==2 %}checked{% endif %}>
                        <input type="radio" name="status" value="3" title="拒绝"
                               {% if search['status']==3 %}checked{% endif %}>
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
            <col width="120">
            <col width="120">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>ID</th>
            <th>维修点名称</th>
            <th>归属人名称</th>
            <th>类型</th>
            <th>手机</th>
            <th>备注</th>
            <th>状态</th>
            <th>拒绝原因</th>
            <th>创建时间</th>
            <th>创建者类型</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for repair in data %}
            <tr>
                <td>{{ repair['id'] }}</td>
                <td>{{ repair['name'] }}</td>
                <td>{{ repair['belonger_name'] }}</td>
                <td>{{ repair['type']=="0"?"电动车维修点":repair['type']=="1"?"电动车维修兼销售点":"便民开锁点" }}</td>
                <td>{{ repair['mobile'] }}</td>
                <td>{{ repair['remark'] }}</td>
                <td>{{ repair['status'] }}</td>
                <td>{{ repair['refuse_reason'] }}</td>
                <td>{{ repair['created_at'] }}</td>
                <td>{{ repair['create_by_type'] }}</td>
                <td>
                    <button class="layui-btn photo" data-id="{{ repair['id'] }}">查看照片</button>
                    <button class="layui-btn layui-btn-normal edit" data-id="{{ repair['id'] }}">修改</button>
                </td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
    <div id="page"></div>

    <ul id="viewer" style="display:none;padding:20px;height:80px;">
    </ul>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="top:300px;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">编辑</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="repair_id">
                    <label for="name">维修单名称</label>
                    <input type="text" class="form-control" id="name">
                    <label for="mobile">维修点手机</label>
                    <input type="text" class="form-control" id="mobile">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" id="submit">提交</button>
                </div>
            </div>
        </div>
    </div>

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
                        window.location.href = "/admin/business/repair/list?page=" + obj.curr
                    }
                }
            });

            $(".photo").click(function () {
                $("#viewer").empty();
                var repair_id = $(this).data('id');
                $.ajax({
                    url: "/admin/business/repair/" + repair_id + "/imgs",
                    method: "GET",
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
                                area: '500px',
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
                window.location.href = "/admin/business/repair/list";
            });
            $('.edit').click(function () {
                var repair_id = $(this).data('id');
                $('#myModal').modal();
                $('.modal-backdrop').removeClass('modal-backdrop');
                $("#repair_id").val(repair_id);
            })
            $("#submit").click(function () {
                var mobile = $("#mobile").val();
                var name = $("#name").val();
                var repair_id = $("#repair_id").val();
                var layer_load = layer.load();
                $.ajax({
                    url: "/admin/business/repair",
                    method: "POST",
                    data: {
                        'mobile': mobile,
                        'name': name,
                        'repair_id': repair_id
                    },
                    success: function (res) {
                        $('#myModal').modal('hide');
                        if (res.status) {
                            layer.msg("修改成功", function () {
                                window.location.reload();
                            });
                        } else {
                            layer.close(layer_load);
                            layer.msg(res.msg);
                        }
                    },
                    error: function () {
                        layer.close(layer_load);
                        layer.msg("请求错误")
                    }
                })
            })
        });
    </script>
{% endblock %}
