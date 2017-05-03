<?php
session_start();
require('../dbconnect.php');

// 各入力値を保持する変数を用意
$nick_name = '';
$email = '';
$password = '';

// エラー格納用の配列を用意
$errors = array();



?>