<?php
/**
 * Created by PhpStorm.
 * User: junwenz
 * Date: 2017/12/28
 * Time: 上午10:23
 */
include 'common.php';
include 'config.php';

$username = $_POST['username'];
$email = $_POST['email'];
$pwd = $_POST['pwd'];
$method = $_POST['method'];
$author_email = $_POST['author_email'];
$title = $_POST['title'];
$content = $_POST['content'];
$id = $_POST['id'];
$pwd_ori = $_POST['pwd_ori'];
$username_new = $_POST['username_new'];
$pwd_new = $_POST['pwd_new'];
$page = $_POST['page'];
$search_content = $_POST['search_content'];
$followee = $_POST['followee'];


if ($method === 'showLogin') {
  $username = get_username_session();
  print $username;
}

if ($method === 'checkLogin') {
  if(isset($_SESSION['email'])){
    print TRUE;
  } else {
    print FALSE;
  }
}

if ($method === 'login') {
  if (checkValid($conn, $email, $pwd)) {
    $username = get_username_db($email, $conn);
    set_mysession($username, $email);
    print $username;
  }
}

if ($method === 'signup') {
  if (create_user($username, $pwd, $conn, $email)) {
    set_mysession($username, $email);
    print $username;
  }
}

if ($method === 'logout') {
  unset($_SESSION['login']);
  unset($_SESSION['username']);
  unset($_SESSION['email']);
  session_destroy();
}

if ($method === 'show_all') {
  $pagesize = 6;
  $startindex=($page-1)*$pagesize;
  $total_num = get_articles($conn);
  $result = show_curr_page($conn,$startindex);
  $all = array();
  $data = loop($result);
  $all['data'] = $data;
  $page_num = ceil($total_num/$pagesize);
  $all['page_num'] = $page_num;
  print json_encode($all,JSON_UNESCAPED_UNICODE);
}

if ($method === 'show_author'){
  if ($author_email === 'use session'){
    $author_email = get_email_session();
  }
  $result = get_author_article($conn,$author_email);
  print loop($result);
}

if ($method === 'save'){
  $username = get_username_session();
  $email = get_email_session();
  print save($conn,$email,$username,$title,$content);
}

if($method === 'update'){
  print update($conn,$id,$title,$content);
}

if ($author_email === 'use session'){
  $author_email = get_email_session();
}

if ($method === 'checkValid'){
  $email = get_email_session();
  print checkValid($conn,$email,$pwd_ori);
}

if ($method === 'changeinformation'){
  $email = get_email_session();
  if($result = changeinfo($conn,$email,$username_new,$pwd_new)){
    set_mysession($username_new, $email);
  }
  print $result;
}

if($method === 'delete'){
  $email = get_email_session();
  if(delete_user($conn,$email) && delete_all($conn,$email)){
    unset($_SESSION['login']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    session_destroy();
    print True;
  } else {
    print False;
  }
}

if($method === 'search') {
  if($author_email === 'user session'){
    $author_email = get_email_session();
  }
  $result = search($conn,$author_email,$search_content);
  print loop($result);
}

if($method === 'delete_article'){
  if(delete_article($conn,$id)){
    print True;
  } else {
    print False;
  }
}

if($method === 'follow'){
  if(follow($followee,$conn)){
    print True;
  } else {
    print False;
  }
}

if($method === 'unfollow'){
  if(unfollow($followee,$conn)){
    print True;
  } else {
    print False;
  }
}

if($method === 'checkFollow'){
  if(checkfollow($conn,$followee)){
    print True;
  } else {
    print False;
  }
}




