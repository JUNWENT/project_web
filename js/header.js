function showLoginHeader(username) {
    $('#regbar').html("<div class=\"personal\">" +
                         "<p id='id'>" + username + "</p>" +
                         "<ul>" +
                           "<li><a href=\"./index.php\">Home</a></li>" +
                           "<li><a href=\"./setting.php\">Settings</a></li>" +
                           "<li><a href=\"./personal_blog.php\">My Home Page</a></li>" +
                           "<button onclick='logout()' id='logout'>Logout</button>" +
                         "</ul>" +
                      "</div>");
}

function logout() {
    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'logout'},
        success: function (result) {
            window.location.href='index.php';
        }
    })
}

$.ajax({
    url: "./display.php",
    type: "POST",
    data: {method: 'showLogin'},
    success: function (username) {
        if (username) {
            showLoginHeader(username);
            console.log('here');
        }
    },
})

//click otherplace to cancel showing
$(document).mouseup(function (e) {
    var container = $(".login");

    if (!container.is(e.target)
        && container.has(e.target).length === 0)
    {
        container.hide();
        $('#email_login').val('');
        $('#pwd_login').val('');
        $('#error').remove();
    }
})

$(document).mouseup(function (e) {
    var container = $(".signup");

    if (!container.is(e.target)
        && container.has(e.target).length === 0)
    {
        container.hide();
        $('#email_signup').val('');
        $('#pwd_signup').val('');
        $('#username_signup').val('');
        $('#error').remove();
    }
});

$('#login_button').click(function () {
    var email = $('#email_login').val();
    var pwd = $('#pwd_login').val();
    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'login', email: email, pwd: pwd},
        success: function (result) {
            console.log(result);
            if (result) {
                showLoginHeader(result);
                $('.login').css('display', 'none');
            } else {
                $('fieldset').append("<p id='error'>Login fail!</p>");
            }
        },
    })
})

$('#signup_button').click(function () {
    var email = $('#email_signup').val();
    var username = $('#username_signup').val();
    var pwd = $('#pwd_signup').val();

    $.ajax({
        url: "./display.php",
        type: "POST",
        data: {method: 'signup', email: email, pwd: pwd, username: username},
        success: function (result) {
            if (result) {
                showLoginHeader(result);
                $('.signup').css('display', 'none');
            } else {
                $('fieldset').append("<p id='error'>Register fail!</p>");
            }
        },
    })
})

$('#login').click(function(){
    $('.login').fadeToggle('slow');
});

$('#signup').click(function(){
    $('.signup').fadeToggle('slow');
});
