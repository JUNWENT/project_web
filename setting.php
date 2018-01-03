<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MY BLOG | SETTINGS</title>
  <link rel="stylesheet" href="css/settings.css"/>
  <link rel="stylesheet" href="css/header.css"/>
</head>
<body>
<?php
include 'header.php';
?>
<div id="empty" style="height:67px;"></div>
<img src="img/settings.png" id="watch">
<fieldset>
  <label>Change Username</label>
  <input type="text" id="username_new" name="username" placeholder="your new username"/>
  <label id="red">Change your password:</label><br>
  <label>Enter your original password:</label>
  <input type="password" id="pwd_original" name="pwd_ori" placeholder="your original password"/>
  <label>Enter your new password:</label>
  <input type="password" id="pwd_new" name="pwd_new" placeholder="your new password"/>
  <input type="submit" value="Save" id="save_button"/>
  <input type="submit" value="Delete" id="delete_button"/>
  <label id = 'error_info'></label>
</fieldset>
</body>
</html>
<script src = "https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="./js/header.js"></script>
<script src="./js/settings.js"></script>
