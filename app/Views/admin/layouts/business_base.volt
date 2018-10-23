{% extends '../layouts/base.volt' %}

{% block sidebar %}
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree">
            <li class="layui-nav-item layui-this"><a href="/admin">首页</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">用户</a>
                <dl class="layui-nav-child">
                    <dd><a href="/admin/business/member/list" class="/admin/business/member/list">总览</a></dd>
                    <dd><a href="/admin/business/member/to_auth" class="/admin/business/member/to_auth">待审核</a></dd>
                    {#<dd><a href="/admin/business/member/authed" class="/admin/business/member/authed">审核通过</a></dd>#}
                    {#<dd><a href="/admin/business/member/auth_denied" class="/admin/business/member/auth_denied">审核拒绝</a></dd>#}
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">求助</a>
                <dl class="layui-nav-child">
                    <dd><a href="/admin/business/appeal/list">总览</a></dd>
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
                    <dd><a href="/admin/business/shb/list">总览</a></dd>
                    <dd><a href="/admin/business/shb/to_auth">待审核</a></dd>
                    <dd><a href="/admin/business/shb/trading">交易中</a></dd>
                    <dd><a href="/admin/business/shb/traded">交易完成</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">新车</a>
                <dl class="layui-nav-child">
                    <dd><a href="/admin/business/nb/list">总览</a></dd>
                    <dd><a href="/admin/business/nb/to_auth">待审核</a></dd>
                    <dd><a href="/admin/business/nb/authed">审核通过</a></dd>
                    <dd><a href="/admin/business/nb/auth_denied">审核拒绝</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">维修点</a>
                <dl class="layui-nav-child">
                    <dd><a href="/admin/business/repair/list">总览</a></dd>
                    <dd><a href="/admin/business/repair/to_auth">待审核</a></dd>
                </dl>
            </li>
        </ul>
    </div>
{% endblock %}