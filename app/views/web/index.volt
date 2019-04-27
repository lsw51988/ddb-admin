{% extends '/layouts/base.volt' %}
{% block title %}电动帮{% endblock %}
{% block content %}
    <div class="index">
        <div class="layui-row align-center pdb-20">
            <div class="layui-col-md6 layui-col-md-offset3">
                <input type="text" name="search" placeholder="请输入关键词，例如：雅迪" autocomplete="off"
                       class="layui-input inline-block" style="width: 400px;height: 50px"><button type="button" class="layui-btn layui-btn-normal search-btn" style="height:50px;width:80px;">搜索</button>
            </div>
        </div>
    </div>
{% endblock %}
{% block scripts %}
<script>
    $(function(){
        $(".search-btn").click(function(){
            var search = $("input[name=search]").val();
            window.location.href = "#";
        });
    });
</script>
{% endblock %}