{% extends '../layouts/business_base.volt' %}
{% block title %}业务管理首页{% endblock %}
{% block content %}
    {{ content }} {{ currentUri }}
    <div class="layui-form">
        <table class="layui-table">
            <colgroup>
                <col width="30%">
                <col width="30%">
            </colgroup>
            <thead>
            <tr>
                <th>指标</th>
                <th>数据</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>昨天新增骑行者</td>
                <td>{{ riders_count }}人</td>
            </tr>
            <tr>
                <td>昨天新增修理者</td>
                <td>{{ repairer_count }}人</td>
            </tr>
            <tr>
                <td>昨天新增二手车</td>
                <td>{{ shb_count }}人</td>
            </tr>
            <tr>
                <td>昨天新增丢失车辆</td>
                <td>{{ lost_count }}人</td>
            </tr>
            </tbody>
        </table>
    </div>
{% endblock %}