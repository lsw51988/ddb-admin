<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{% block title %}{% endblock %}</title>
    <link rel="stylesheet" href="/layui/css/layui.css"/>
    <link rel="stylesheet" href="/viewer/viewer.css"/>
    <link rel="stylesheet" href="/viewer/viewer.min.css"/>
    <link rel="stylesheet" href="/css/base.css"/>
    <link rel="stylesheet" href="/css/web/index.css"/>
    <script src="https://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="/layui/layui.js"></script>
    <script src="/viewer/viewer.js"></script>
    <script src="/viewer/viewer.min.js"></script>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    {% block css %}{% endblock %}
</head>
<body class="layui-layout-body">
<div class="layui-header">
    <ul class="layui-nav text-center layui-bg-red" style="font-size: 25px;">
        <li class="layui-nav-item business"><a href="#">电动帮</a></li>
        <li class="layui-nav-item business"><a href="#">我要买车</a></li>
        <li class="layui-nav-item system"><a href="#">我要卖车</a></li>
        <li class="layui-nav-item system"><a href="#">丢失求助</a></li>
        <li class="layui-nav-item system"><a href="#">新车</a></li>
        <li class="layui-nav-item operation"><a href="#">登录</a></li>
    </ul>
</div>
<div class="layui-container">
    {% block content %}{% endblock %}
</div>

<div class="index-footer">
    <div class="layui-container">
        <div class="web-about">
            备案号：苏ICP备18012552号 <a href="/business_license_img" target="_blank" style="color: white;">营业执照</a>
        </div>
        <div class="links">
            <label style="padding-right: 20px;">友情链接</label>
            <a class="ddc-gw" href="http://www.yadea.com.cn/" target="_blank">雅迪电动车官网</a>
            <a class="ddc-gw" href="https://www.aimatech.com/" target="_blank">爱玛电动车官网</a>
            <a class="ddc-gw" href="https://www.niu.com/" target="_blank">小牛电动车官网</a>
            <a class="ddc-gw" href="http://www.jbking.cn/" target="_blank">杰宝电动车官网</a>
            <a class="ddc-gw" href="http://www.lvneng.com/pc/index.html" target="_blank">绿能电动车官网</a>
            <a class="ddc-gw" href="http://www.luyuan.cn/" target="_blank">绿源电动车官网</a>
            <a class="ddc-gw" href="http://www.xinri.com/" target="_blank">新日电动车官网</a>
            <a class="ddc-gw" href="http://www.xdebike.com/" target="_blank">小刀电动车官网</a>
            <a class="ddc-gw" href="http://www.wxjinjian.com/" target="_blank">金箭电动车官网</a>
            <a class="ddc-gw" href="http://www.jsxianglong.com/" target="_blank">祥龙电动车官网</a>
            <a class="ddc-gw" href="http://www.tailg.com.cn/" target="_blank">台铃电动车官网</a>
            <a class="ddc-gw" href="http://www.haojue.com/" target="_blank">SUZUKI豪爵电动车官网</a>
            <a class="ddc-gw" href="http://www.woqudiandong.com/" target="_blank">沃趣电车官网</a>
            <a class="ddc-gw" href="http://www.opai.cn/" target="_blank">欧派电动车官网</a>
            <a class="ddc-gw" href="http://www.julongddc.cn/" target="_blank">巨龙电动车官网</a>
            <a class="ddc-gw" href="http://www.shanghailima.com/" target="_blank">上海立马电动车官网</a>
        </div>
        <div>

        </div>

    </div>
</div>

<script>
    //JavaScript代码区域
    layui.use(['element', 'jquery', 'layer', 'form'], function () {

    });
</script>
{% block scripts %}{% endblock %}
{% block css %}{% endblock %}
</body>
</html>
