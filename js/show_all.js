/**
 * Created by junwenz on 2017/12/30.
 */
function reload_content(curr_page){
    var container = $('.col-md-8');
    container.html("<div>Loading...</div>");
    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'show_all',page:curr_page},
        success: function (result) {
            container.html('');
            result = JSON.parse(result);
            console.log(result);
            var data = result['data'];
            data = JSON.parse(data);
            var page_num = result['page_num'];
            $.each(data, function(i, item) {
                var date = item.write_time;
                var title = item.title;
                var content = item.content;
                var author = item.author_name;
                var email = item.author_email;
                var str = '<article class="post">' +
                            '<header class="entry-header">' +
                                '<h1 class="entry-title"><a>' + title + '</a></h1>' +
                                '<div class="entry-meta">' +
                                  '<span class="post-date"><a><time class="entry-date">' + date + '</time></a></span>' +
                                  '<span class="post-author"><a onclick="goTo(\''+ email + '\',\'' + author + '\')">' + author + '</a></span>' +
                                '</div>' +
                            '</header>' +
                            '<div class="entry-content clearfix">' +
                                '<p class="curr_content short_content">' + content + '</p>' +
                                '<div class="read-more cl-effect-14">' +
                                   '<a onclick="viewMore(this)" class="more-link">Continue reading ' +
                                      '<span class="meta-nav">→</span>' +
                                   '</a>' +
                                '</div>' +
                            '</div>';
                 container.append(str);
            })
            container.append('<nav class="pagination" role="navigation" aria-label="Pagination">');
            var container1 = $('.pagination');
            for(var i=1;i<=page_num;i++){
                if(i == curr_page){
                    var str1 = '<li class ="pagination-number"><a id="current_page" href="javascript:void(0)"' +
                        ' onclick=reload_content(' + i + ')>' + i + '</a></li>';
                    container1.append(str1);
                } else {
                    var str2 = '<li class ="pagination-number"><a href="javascript:void(0)"' +
                        ' onclick=reload_content(' + i + ')>' + i + '</a></li>';
                    container1.append(str2);
                }
            }
        }
    })
}

function goTo(email,author){
    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'showLogin'},
        success: function (username) {
            if (username) {
                var author_info = new Object();
                author_info.name = author;
                author_info.email = email;
                author_info = JSON.stringify(author_info)
                window.localStorage.setItem('author',author_info);
                window.location.href = 'personal_blog.php';
            } else {
                $('.login').fadeToggle('slow');
            }
        },
    })

}

function viewMore(e) {
    var container = $(e);
    container = container.parent().prev();
    console.log(container);
    container.removeClass("short_content");
}

reload_content(1);

$('#create').click(function (){
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

$(document).mouseup(function (e) {
    var container = $(".more-link");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        $('.curr_content').addClass("short_content");
    }
});
