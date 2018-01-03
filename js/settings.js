/**
 * Created by junwenz on 2018/1/1.
 */
function changeinformation(){
    var name_new = $('#username_new').val();
    var pwd_new = $('#pwd_new').val();
    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'changeinformation',pwd_new:pwd_new,username_new:name_new},
        success: function (result) {
            if(result) {
                $('#id').text(name_new);
                $('#error_info').html('You have successfully change your information!');
            } else {
                $('#error_info').html('Change Failed! Try again');
            }
        }
    })
}

function delete_user(){
    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'delete'},
        success: function (result) {
            if(result) {
                window.location.href='index.php'
            } else {
                $('#error_info').html('Delete Failed!!!');
            }
        }
    })
}

$('#save_button').click(function (){
    if($('#pwd_original').val() === ''){
        $('#error_info').html('You must enter your original password first!');
    } else {
        var pwd_ori = $('#pwd_original').val();
        $.ajax({
            url: "./display.php",
            type: "POST",
            data: {method: 'checkValid',pwd_ori:pwd_ori},
            success: function (result) {
                if(result) {
                    changeinformation();
                } else {
                    $('#error_info').html('Wrong original password!');
                }
            }
        })
    }
})

$('#delete_button').click(function (){
    if($('#pwd_original').val() === ''){
        $('#error_info').html('You must enter your original password first!');
    } else {
        var pwd_ori = $('#pwd_original').val();
        $.ajax({
            url: "./display.php",
            type: "POST",
            data: {method: 'checkValid',pwd_ori:pwd_ori},
            success: function (result) {
                if(result) {
                    delete_user();
                } else {
                    $('#error_info').html('Wrong original password!');
                }
            }
        })
    }
})
