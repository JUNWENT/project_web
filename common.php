<?php
session_start();
/**
 * Created by PhpStorm.
 * User: junwenz
 * Date: 2017/12/27
 * Time: 上午11:15
 *
 * @param $username
 * @param $email
 */

function set_mysession ($username,$email){
  $_SESSION['login'] = TRUE;
  $_SESSION['username'] = $username;
  $_SESSION['email'] = $email;
}

function get_username_session () {
  if (isset($_SESSION['login']) && $_SESSION['login'] === TRUE) {
    return $_SESSION['username'];
  } else {return NULL;}
}

function get_username_db ($email,$conn) {
  $query = "SELECT username FROM users WHERE email = '$email'";
  $result = $conn->query($query)->fetch_row();
  return $result[0];
}

function get_email_session () {
  if (isset($_SESSION['login']) && $_SESSION['login'] === TRUE) {
    return $_SESSION['email'];
  } else {return NULL;}
}

function get_author($blog_id,$conn){
  return $conn->query("SELECT author_id FROM blogs WHERE id = '{$blog_id}'");
}

function get_selfimg($username,$conn){
  return $conn->query("SELECT img FROM users WHERE username= '{$username}'");
}

function follow($followee,$conn){
  $follower = get_email_session();
  return $conn->query("INSERT INTO follow(followee,follower) VALUES ('$followee','$follower')");
}

function unfollow($followee,$conn){
  $follower = get_email_session();
  $query = "DELETE FROM follow WHERE followee = '{$followee}' AND follower = '{$follower}'";
  return $conn->query($query);
}

function checkfollow($conn,$followee){
  $follower = get_email_session();
  $query = "SELECT COUNT(id) AS num FROM follow WHERE follower = '{$follower}' AND followee = '{$followee}'";
  $result = $conn->query($query);
  while ($row = $result->fetch_assoc()) {
    $num = $row['num'];
  }
  if(isset($num) && $num == 1){
    return TRUE;
  } else {
    return False;
  }
}

function checkValid($conn,$email,$pwd){
  $options = array('cost' => 11);
  $checkQuery = "SELECT pwd FROM users WHERE email = '{$email}'";
  $result = $conn->query($checkQuery)->fetch_row();
  while ($result) {
    if(password_verify($pwd,$result[0])){
      if(password_needs_rehash($result[0],PASSWORD_DEFAULT, $options)){
        $newPwd = password_hash($result[0],PASSWORD_DEFAULT, $options);
      }
      //update the new password
      $updateQuery = "UPDATE login SET password = '{$newPwd}'
      WHERE email = '{$email}' ";
      $conn->query($updateQuery);
      return TRUE;
    } else {
      return FALSE;
    }
  }
  return False;
}

function create_user($username,$pwd,$conn,$email){
  $checkExclusive = "SELECT username FROM users WHERE username='{$username}'
   OR email='{$email}'";
  $exclusiveResult = $conn->query($checkExclusive)->fetch_row();
  // if the DB does not has this username or email address store the user data
  if(empty($exclusiveResult)){
    //get the time of the user signin
    $ltime = time();
    $pwd = password_hash($pwd, PASSWORD_DEFAULT);
    $insertQuery = "INSERT INTO users (username,pwd,email,create_time)
                    VALUES ('{$username}','{$pwd}','{$email}',{$ltime})";
    $insertResult = $conn->query($insertQuery);
    if($insertResult === TRUE) {
      return TRUE;
    } else {
      return FALSE;
    }
  } else {
    return FALSE;
  }
}

function get_articles($conn){
  $query = "SELECT count(id) AS num FROM blogs";
  $result = $conn->query($query);
  while ($row = $result->fetch_assoc()) {
    $num = $row['num'];
  }
  return $num;
}


function get_author_article($conn,$author_email){
  $query = "SELECT * FROM blogs WHERE author_email='{$author_email}'
                                ORDER BY id DESC";
  $result = $conn ->query($query);
  return $result;
}

function save($conn,$email,$name,$title,$content){
  $ltime = time();
  $query = "INSERT INTO blogs (author_name,title,content,write_time,author_email)
            VALUES ('{$name}','{$title}','{$content}',{$ltime},'{$email}')";
  $insertResult = $conn->query($query);
  if($insertResult === TRUE) {
    return TRUE;
  } else {
    return FALSE;
  }
}

function update($conn,$id,$title,$content){
  $ltime = time();
  $query="UPDATE blogs SET title='{$title}',content='{$content}',write_time={$ltime}
          WHERE id = {$id}";
  $updateResult = $conn->query($query);
  if($updateResult === TRUE) {
    return TRUE;
  } else {
    return FALSE;
  }
}

function changeinfo($conn,$email,$username_new,$pwd_new){
  $pwd_new = password_hash($pwd_new, PASSWORD_DEFAULT);
  $query="UPDATE users SET username='{$username_new}',pwd='{$pwd_new}' WHERE email = '{$email}'";
  $updateResult = $conn ->query($query);
  $query="UPDATE blogs SET author_name = '{$username_new}' WHERE author_email = '{$email}'";
  $updateResult2 = $conn ->query($query);
  if($updateResult === TRUE && $updateResult2 === TRUE) {
    return TRUE;
  } else {
    return FALSE;
  }
}

function delete_user($conn,$email){
  $query = "DELETE FROM users WHERE email = '{$email}'";
  $deleteResult = $conn ->query($query);
  if($deleteResult === TRUE) {
    return TRUE;
  } else {
    return FALSE;
  }
}

function show_curr_page($conn,$startindex){
  $pagesize=6;
  $query="SELECT * FROM blogs ORDER BY id LIMIT $startindex,$pagesize";
  $result = $conn->query($query);
  return $result;
}

function search($conn,$email,$search_content){
  $query = "SELECT * FROM blogs WHERE author_email = '{$email}'
                                  AND (title LIKE '%{$search_content}%'
                                  OR content LIKE '%{$search_content}%')";
  $result = $conn->query($query);
  return $result;
}

function fetch_assoc($row) {
  return $row->fetch_assoc;
}

function delete_article($conn,$id){
  $query = "DELETE FROM blogs WHERE id = '{$id}'";
  $deleteResult = $conn ->query($query);
  if($deleteResult === TRUE) {
    return TRUE;
  } else {
    return FALSE;
  }
}

function loop($result){
  $article = array();
  while ($row = $result->fetch_assoc()) {
    $row['write_time'] = date('Y-m-d H:i:s',(int)$row['write_time']);
    $article[] = $row;
  }
  return json_encode($article,JSON_UNESCAPED_UNICODE);
}

function delete_all($conn,$email){
  $query = "DELETE FROM blogs WHERE author_email = '{$email}'";
  $deleteResult = $conn ->query($query);
  $query = "DELETE FROM follow WHERE follower = '{$email}'";
  $deleteResult1 = $conn ->query($query);
  if($deleteResult === TRUE && $deleteResult1 === TRUE) {
    return TRUE;
  } else {
    return FALSE;
  }
}


