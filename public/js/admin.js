$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

$(".post-audit").click(function () {
    // target = $(event.target);
    // var post_id = target.attr("post-id");
    // var status = target.attr("post-action-status");
    var self = this;
    var post_id = $(this).attr("post-id");
    var status = $(this).attr("post-action-status");

    $.ajax({
        url: "/admin/posts/" + post_id + "/status",
        method: "POST",
        data: { "status": status },
        dataType: "json",
        success: function success(data) {

            console.log('ok', data);

            if (data.error != 0) {
                alert(data.msg);
                return;
            }

            $(self).parent().parent().remove();
        },
        error: function error(err) {
            console.log('fail', err.responseJSON.status[0]);
        }
    });
});

$(".resource-delete").click(function (event) {
    if (confirm("确定执行删除操作么?") == false) {
        return;
    }

    var target = $(event.target);
    event.preventDefault();
    var url = $(target).attr("delete-url");
    $.ajax({
        url: url,
        method: "POST",
        data: { "_method": 'DELETE' },
        dataType: "json",
        success: function success(data) {
            if (data.error != 0) {
                alert(data.msg);
                return;
            }

            window.location.reload();
        }
    });
});