{% extends '../layouts/business_base.volt' %}

{% block title %}业务管理首页{% endblock %}
{% block content %}

    <span class="layui-breadcrumb">
      <a href="">后台</a>
      <a href="">建议</a>
      <a><cite>总览</cite></a>
    </span>

    <table class="layui-table">
        <colgroup>
            <col width="120">
            <col width="150">
            <col width="200">
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
            </tr>
        {% endfor %}
        </tbody>
    </table>
    <div id="page"></div>
{% endblock %}
{% block scripts %}
    <script>
        layui.use(['laypage'], function () {
            var laypage = layui.laypage;
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
        });
    </script>
{% endblock %}
