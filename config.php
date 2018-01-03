<?php
/**
 * Created by PhpStorm.
 * User: junwenz
 * Date: 2017/12/27
 * Time: 上午10:03
 */
// connect to DB
$serverName = '127.0.0.1';
$username = 'root';
$password = 'root';
$databaseName = 'blog';
date_default_timezone_set('Asia/Shanghai');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$conn = new mysqli($serverName,$username,$password);
//create database if not exist
$conn->query('CREATE DATABASE IF NOT EXISTS ' . $databaseName);
$conn->select_db($databaseName);
if(!$conn) {
  die('Database connect error');
}

