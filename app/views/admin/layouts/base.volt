<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{% block title %}{% endblock %}</title>
    <link rel="stylesheet" href="/layui/css/layui.css"/>
    <link rel="stylesheet" href="/viewer/viewer.css"/>
    <link rel="stylesheet" href="/viewer/viewer.min.css"/>
    <link rel="stylesheet" href="/css/base.css"/>
    <script src="https://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="/layui/layui.js"></script>
    <script src="/viewer/viewer.js"></script>
    <script src="/viewer/viewer.min.js"></script>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    {% block css %}{% endblock %}
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">电动帮后台</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item business"><a href="/admin/business/index">业务管理</a></li>
            <li class="layui-nav-item system"><a href="/admin/system/index">系统管理</a></li>
            <li class="layui-nav-item operation"><a href="/admin/operation/index">运营管理</a></li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    阿德
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="">退出</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        {% block sidebar %}{% endblock %}
    </div>

    <div class="layui-body pd-20">
        {% block content %}{% endblock %}
    </div>

    <div class="layui-footer">
        @ddb.com 电动帮
    </div>
</div>
<script>
    //JavaScript代码区域
    layui.use(['element', 'jquery', 'layer', 'form'], function () {
        var element = layui.element;
        var $ = layui.$,
            layer = layui.layer;
        var currentUri = "{{ currentUri }}";
        var model = "";
        if (currentUri.indexOf("?") != -1) {
            currentUri = currentUri.substring(0, currentUri.indexOf("?"));
            model = currentUri.substring(7, currentUri.indexOf('/', 7));
        } else {
            model = currentUri;
        }

        $("a[href='" + currentUri + "']").siblings(".layui-nav-item").removeClass("layui-this");
        $("a[href='" + currentUri + "']").addClass("layui-this");
        $(".layui-nav-tree .layui-nav-item").removeClass("layui-this");
        $("a[href='" + currentUri + "']").addClass("layui-this");
        $("a[href='" + currentUri + "']").closest(".layui-nav-item").addClass("layui-nav-itemed");
    });
</script>
{% block scripts %}{% endblock %}
{% block css %}{% endblock %}
</body>
</html>
