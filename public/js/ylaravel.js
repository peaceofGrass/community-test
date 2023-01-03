$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

var editor = new wangEditor('content');

if (editor.config) {
    editor.config.uploadImgUrl = "/posts/image/upload";

    // 设置 headers（举例）
    editor.config.uploadHeaders = {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    };

    editor.create();
}

// 取消，关注
$(".like-button").click(function(event){

    // var self = $(this);
    var self = $(event.target);
    var current_like = self.attr("like-value");
    var like_user = self.attr("like-user");

    if (current_like == 1) {
        // 取消关注
        $.ajax({
            url: '/user/' + like_user + '/unfan',
            method: 'POST',
            dataType: 'json',
            success: function(data) {
                if (data.error != 0) {
                    alert(data.msg);
                    return;
                }
                self.attr('like-value', 0);
                self.text('关注');
            }
        });
    } else {
        // 关注
        $.ajax({
            url: '/user/' + like_user + '/fan',
            method: 'POST',
            dataType: 'json',
            success: function(data) {
                if (data.error != 0) {
                    alert(data.msg);
                    return;
                }
                self.attr('like-value', 1);
                self.text('取消关注');
            }
        });
    }
});

$(".file-loading").change(function() {
    var formdata = new FormData();
    formdata.append('pic', $(this)[0].files[0]);
    // console.log(formdata);
    $.ajax({
        type: "post",
        url: "/user/avatar/upload",
        data: formdata,
        contentType:false,
        processData:false,
        success: function(data) {
            $(".preview_img").attr('src', data);
            $(".avatar_input").val(data);
        },
        error: function() {
            alert('图片上传错误！');
        }
    });
});
