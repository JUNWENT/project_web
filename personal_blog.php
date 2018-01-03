<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <title>MY BLOG</title>
  <link rel="stylesheet" href="css/skel.css"/>
  <link rel="stylesheet" href="css/style.css"/>
  <link rel="stylesheet" href="css/style-wide.css"/>
  <link rel="stylesheet" href="css/header.css"/>
  <link
    href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css"
    rel="stylesheet">
</head>
<body class="landing">
<?php
include 'header.php';
?>
<div class="search bar7">
  <input type="text" placeholder="知道你懒过来搜吧～" id="search_content">
  <button type="button" id="search"></button>
</div>
<img src="img/rollup.png" id="rollup" onclick="rollup()">
<div id="img"></div>
<section id="banner">
  <h2 id='author_name'></h2>
</section>
<div id="main_body"></div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="./js/header.js"></script>
<script src="./js/personal_blog.js"></script>

