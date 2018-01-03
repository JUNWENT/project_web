<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Note Edit</title>
    <link rel="stylesheet" href="css/edit.css"/>
    <link rel="stylesheet" href="css/header.css"/>
</head>
<body>
<?php
include 'header.php';
?>
<img src="img/edit.png" id="save">
<img src="img/delete.png" id="delete">
<div id="notebook-paper">
    <header>
        <input type="text" id="title" placeholder="标题" style="outline:none;" name="title"/>
    </header>
    <div id="show">
        <textarea rows="10" cols="100" id="content" placeholder="内容" style="outline:none;" name="content"></textarea>
    </div>
</div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="./js/header.js"></script>
<script src="./js/edit.js"></script>