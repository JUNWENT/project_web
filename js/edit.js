/**
 * Created by junwenz on 2018/1/1.
 */
$(document).ready(function () {
    var curr = window.localStorage.getItem('current');
    curr = JSON.parse(curr);
    console.log(curr);
    if (curr !== null) {
        var title = curr.title;
        var content = curr.content;
        $('#title').val(title);
        $('#content').text(content);
    }

    $('#save').click(function () {
        var new_title = $('#title').val();
        var new_content = $('#content').val();
        console.log(new_title, new_content);
        if (curr !== null) {
            console.log('rere');
            var id = curr.id;
            $.ajax({
                url: "./display.php",
                type: "POST",
                data: {method: 'update', title: new_title, content: new_content, id: id},
                success: function (result) {
                    if (result) {
                        window.localStorage.removeItem('current');
                        window.location.href = 'personal_blog.php';
                    }
                }
            })
        } else {
            $.ajax({
                url: "./display.php",
                type: "POST",
                data: {method: 'save', title: new_title, content: new_content},
                success: function (result) {
                    if (result) {
                        window.localStorage.removeItem('current');
                        window.location.href = 'personal_blog.php';
                    }
                }
            })
        }
    });

    $('#delete').click(function () {
        if (curr !== null) {
            var id = curr.id;
            $.ajax({
                url: "./display.php",
                type: "POST",
                data: {method: 'delete_article', id: id},
                success: function (result) {
                    if (result) {
                        window.localStorage.removeItem('current');
                        window.location.href = 'personal_blog.php';
                    } else {
                        alert('Delete failed! Try Again!')
                    }
                }
            })
        } else {
            window.location.href = 'personal_blog.php';
        }
    })
})