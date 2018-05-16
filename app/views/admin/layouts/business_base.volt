{% extends '../layouts/base.volt' %}

{% block sidebar %}
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree">
            <li class="layui-nav-item layui-this"><a href="/admin/index">首页</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">骑行者</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;">总览</a></dd>
                    <dd><a href="javascript:;">待审核</a></dd>
                    <dd><a href="javascript:;">审核通过</a></dd>
                    <dd><a href="javascript:;">审核拒绝</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">修理者</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;">总览</a></dd>
                    <dd><a href="javascript:;">待审核</a></dd>
                    <dd><a href="javascript:;">审核通过</a></dd>
                    <dd><a href="javascript:;">审核拒绝</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">求助</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;">总览</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">应助</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;">总览</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">二手车</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;">总览</a></dd>
                    <dd><a href="javascript:;">待审核</a></dd>
                    <dd><a href="javascript:;">交易中</a></dd>
                    <dd><a href="javascript:;">交易完成</a></dd>
                </dl>
            </li>
        </ul>
    </div>
{% endblock %}