{% extends '../layouts/business_base.volt' %}

{% block title %}业务管理首页{% endblock %}
{% block content %}

    <span class="layui-breadcrumb">
      <a href="">后台</a>
      <a href="">建议</a>
      <a><cite>待审核</cite></a>
    </span>

    <table class="layui-table">
        <colgroup>
            <col width="120">
            <col width="150">
            <col width="200">
            <col width="150">
            <col width="150">
            <col width="150">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>ID</th>
            <th>类型</th>
            <th>内容</th>
            <th>用户名</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% for suggestion in data %}
            <tr>
                <td>{{ suggestion['id'] }}</td>
                <td>{{ typeDesc[suggestion['type']] }}</td>
                <td>{{ suggestion['content'] }}</td>
                <td>{{ suggestion['real_name'] }}</td>
                <td>{{ suggestion['created_at'] }}</td>
                <td>
                    <button class="layui-btn layui-btn-normal pass" data-id="{{ suggestion['id'] }}">通过</button>
                    <button class="layui-btn layui-btn-danger refuse" data-id="{{ suggestion['id'] }}">拒绝</button>
                </td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
    <div id="page"></div>
{% endblock %}

{% block scripts %}
    <script>
        layui.use(['laypage', 'jquery'], function () {
            var laypage = layui.laypage;
            var $ = layui.$;
            //执行一个laypage实例
            laypage.render({
                elem: 'page'
                , count: {{ total }}
                , limit: 20
                , curr:{{ page }}
                , jump: function (obj, first) {
                    if (!first) {
                        window.location.href = "/admin/business/suggestion/list?page=" + obj.curr
                    }
                }
            });

            $(".pass").click(function(){
                var suggestion_id = $(this).data('id');
                var layer_load = layer.load();
                $.ajax({
                    url: "/admin/business/suggestion/audit",
                    data:{
                        'suggestion_id':suggestion_id,
                        'type':'pass'
                    },
                    method: "POST",
                    success: function (res) {
                        if(res.status){
                            layer.msg('修改成功',function () {
                                window.location.reload();
                            });
                        }else{
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

            $(".refuse").click(function(){
                var suggestion_id = $(this).data('id');
                layer.prompt({title: '拒绝原因', formType: 2}, function (text, index) {
                    var layer_load = layer.load();
                    $.ajax({
                        url: "/admin/business/suggestion/audit",
                        data:{
                            'suggestion_id':suggestion_id,
                            'type':'refuse',
                            'reason':text
                        },
                        type: "POST",
                        success: function (res) {
                            if(res.status){
                                layer.msg('修改成功',function () {
                                    window.location.reload();
                                });
                            }else{
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
            })
        });
    </script>
{% endblock %}
