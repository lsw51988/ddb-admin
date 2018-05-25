<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" href="/layui/css/layui.css"/>
    <script src="/layui/layui.js"></script>
    <link rel="stylesheet" href="/css/admin/index/login.css">
    <script type="text/javascript" src="/js/admin/login.js"></script>
    <script type="text/javascript" src="/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="/js/jQuery.sha1.js"></script>
</head>
<body>
<div class="login">
    <h2>后台登录</h2>
    <form class="layui-form" onsubmit="return false;">
        <div class="layui-form-item">
            <input name="login" placeholder="请输入账号" class="layui-input">
        </div>
        <div class="layui-form-item">
            <input name="password" placeholder="请输入密码" type="password" class="layui-input">
        </div>
        <div class="layui-form-item">
            <button class="layui-btn" lay-submit lay-filter="formSubmit">登录</button>
        </div>
    </form>
</div>
</body>
</html>