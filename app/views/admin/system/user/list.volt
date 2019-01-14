{% extends '../layouts/system_base.volt' %}
{% block title %}系统管理-用户管理{% endblock %}
{% block css %}系统管理-用户管理{% endblock %}
{% block content %}
    <blockquote class="layui-elem-quote">
        <span class="layui-breadcrumb">
          <a href="">后台</a>
          <a href="">系统管理</a>
          <a><cite>用户管理</cite></a>
        </span>
    </blockquote>


    <fieldset class="layui-elem-field">
        <legend>搜索</legend>
        <div class="layui-field-box">
            <form class="layui-form" action="">
                <div class="layui-form-item" style="margin-bottom:0;">
                    <div class="layui-inline">
                        <label class="layui-form-label">手机</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="phone" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">名字</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>


    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="150">
            <col width="150">
            <col width="150">
            <col width="150">
            <col width="150">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>ID</th>
            <th>名字</th>
            <th>手机</th>
            <th>状态</th>
            <th>邮箱</th>
            <th>最近一次登录IP</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        {% if data['total'] >0 %}
            {% for row in data['rows'] %}
                <tr>
                    <td>{{ row["id"] }}</td>
                    <td>{{ row["name"] }}</td>
                    <td>{{ row["mobile"] }}</td>
                    <td>{% if row["status"]==1 %}启用{% else %}禁用{% endif %}</td>
                    <td>{{ row["email"] }}</td>
                    <td>{{ row["login_ip"] }}</td>
                    <td>
                        <button class="layui-btn" data-id="{{ row["id"] }}">修改</button>
                        <button class="layui-btn layui-btn-danger">删除</button>
                    </td>
                </tr>
            {% endfor %}
        {% else %}
            暂无数据
        {% endif %}
        </tbody>
    </table>
    <div id="page"></div>
{% endblock %}
{% block scripts %}
    <script>
        layui.use('laypage', function () {
            var laypage = layui.laypage;
            var url = "{{ currentUri }}";
            url = url.substring(0, url.indexOf("?"));
            laypage.render({
                elem: 'page',
                curr:{{ data['current_page'] }},
                count: {{ data['total'] }},
                limit: 20,
                jump: function (obj, first) {
                    if (!first) {
                        location.href = url + "?page=" + obj.curr + "&limit=20";
                    }
                }
            });
        });
    </script>
{% endblock %}