layui.use(['form', 'layer', 'jquery'], function () {
    var form = layui.form;
    var layer = layui.layer;
    var $ = layui.$;
    form.on('submit', function (data) {
        data.field.login = jQuery.sha1(data.field.login);
        layer.load();
        $.ajax({
            url: "/admin/login",
            type: "POST",
            data: {
                data: data.field
            },
            dataType: 'json',
            success: function (res) {
                console.log(res);
                layer.closeAll('loading');
            },
            error: function (res) {
                console.log(res);
                layer.closeAll('loading');
            }
        })
    });
})