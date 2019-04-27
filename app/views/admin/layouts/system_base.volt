{% extends '../layouts/base.volt' %}

{% block sidebar %}
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree">
            <li class="layui-nav-item layui-this"><a href="/admin/index">首页</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">权限管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="/admin/system/user/list">管理员管理</a></dd>
                    <dd><a href="javascript:;">角色管理</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">日志管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;">管理员日志</a></dd>
                </dl>
            </li>
        </ul>
    </div>
{% endblock %}