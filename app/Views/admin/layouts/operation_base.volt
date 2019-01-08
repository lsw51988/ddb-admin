{% extends '../layouts/base.volt' %}

{% block sidebar %}
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree">
            <li class="layui-nav-item layui-this"><a href="/admin/operation/index">首页</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">积分管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="/admin/operation/point">总览</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">数据分析</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;">总览</a></dd>
                </dl>
            </li>
        </ul>
    </div>
{% endblock %}