/**
 * Created by junwenz on 2018/1/1.
 */
function reload_articles(author_email,flag,flagFollow) {
    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'show_author',author_email:author_email},
        success: function (result) {
            result = JSON.parse(result);
            console.log(result);
            if(result.length == 0){
                $('#main_body').html('你还没有写哦～');
            } else {
                $('#main_body').html('');
                $.each(result, function(i, item) {
                    var content = item.content;
                    var title = item.title;
                    var id = item.id;
                    var str = getStr(title,content,id);
                    $('#main_body').append(str);
                    if(flag && i == 9 && !flagFollow){
                        return false;
                    }
                })
            }
            if(flag){
                $('.title_part').removeAttr('onclick');
            }
        }
    })
}

function checkFollow(followee,flag){
    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'checkFollow',followee:followee},
        success: function (result) {
            if(result){
                reload_articles(followee,flag,true);
                $('#img').html('<img id="unfollow" src="img/thank.png" onclick="unfollow()">');
            } else {
                reload_articles(followee,flag,false);
                $('#img').html('<img id="follow" src="img/follow.png" onclick="follow()">');
            }
        }
    })
}


function goView(title,content,id){
    var curr ={'title':title,'content':content,'id':id};
    curr = JSON.stringify(curr);
    window.localStorage.setItem('current',curr);
    window.location.href = 'edit.php';
}

function getStr(title,content,id){
    var str = '<section id="main" class="container">' +
                 '<section class="box special">' +
                     '<header class="major">'+
                         '<h2 class="title_part" onclick="goView(\'' + title + '\',\'' + content + '\',\'' + id + '\')">' + title + '</h2>' +
                         '<p>' + content + '</p>' +
                     '</header>' +
                 '</section>' +
              '</section>';
    return str;
}

function search_article(){
    if ($('#search_content').val() !== '') {
        var search_content = $('#search_content').val();
        $.ajax({
            url: "./display.php",
            type: "POST",
            data: {
                method: 'search',
                author_email: author_email,
                search_content: search_content
            },
            success: function (result) {
                result = JSON.parse(result);
                console.log(result);
                if(result.length == 0){
                    $('#main_body').html('并没有搜到相关内容');
                } else {
                    $('#main_body').html('');
                    $.each(result, function(i, item) {
                        var content = item.content;
                        var title = item.title;
                        var id = item.id;
                        var str = getStr(title,content,id);
                        $('#main_body').append(str);
                    })
                }
            }
        })
    } else {
        reload_articles(author_email);
    }
}

function follow(){
    var followee = curr_author.email;
    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'follow',followee:followee},
        success: function (result) {
            if(result){
                checkFollow(followee,true);
                $('#img').html('<img id="unfollow" src="img/thank.png" onclick="unfollow()">');
            }
        }
    })
}

function unfollow(){
    var followee = curr_author.email;
    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'unfollow',followee:followee},
        success: function (result) {
            if(result){
                checkFollow(followee,true);
                $('#img').html('<img id="follow" src="img/follow.png"  onclick="follow()">');
            }
        }
    })
}

function rollup(){
    window.location.href = "javascript:scroll(0,0)";
}

var curr_author = window.localStorage.getItem('author');
window.localStorage.removeItem('author');
curr_author = JSON.parse(curr_author);
console.log(curr_author);
if (curr_author !== null){
    var flag = 1;
    author_name = curr_author.name;
    author_email = curr_author.email;
    $('#author_name').text(author_name);
    console.log(curr_author);
    checkFollow(author_email,flag);
} else {
    $('#img').html('<img id="create" src="img/create.png">');
    var flag = 0;
    var flagFollow = 1;
    author_email = 'use session';
    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'showLogin'},
        success: function (result) {
            $('#author_name').text(result);
        }
    })
    reload_articles(author_email,flag,flagFollow);
}


$('#create').click(function (){
    window.localStorage.removeItem('current');
    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'showLogin'},
        success: function (username) {
            if (username) {
                window.location.href='edit.php';
            } else {
                $('.login').fadeToggle('slow');
            }
        },
    })
})

$('#search').click(function (){
   search_article();
})

$('#search_content').on('keydown', function(e) {
    if(e.keyCode == 13){
        search_article();
    }
});



