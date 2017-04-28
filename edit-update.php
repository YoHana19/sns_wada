<?php
session_start();
require('dbconnect.php');

// $_SESSION['nick_name'] = $nick_name;
// $_SESSION['email'] = 'nexseed.mail.com';
// $_SESSION['user_picture_path'] = 'wada@jpg';
// $_SESSION['back_picture_path'] = 'taka';
// $_SESSION['self_intro_1'] = 'あの鐘をね';
// $_SESSION['self_intro_2'] = '鳴らすのはね';
// $_SESSION['self_intro_3'] = 'あなただよ';
// $_SESSION['login_member_id'] = 1;


  if (empty($_SESSION['errors'])) {
    $sql = 'UPDATE  `members` SET `nick_name`=?,
                                  `email`=?,
                                  `user_picture_path`=?,
                                  `back_picture_path`=?,
                                  `self_intro_1`=?,
                                  `self_intro_2`=?,
                                  `self_intro_3`=?
                              WHERE `member_id`=?';
    $data = array(
                  $_SESSION['nick_name']
                 ,$_SESSION['email']
                 ,$_SESSION['user_picture_path']
                 ,$_SESSION['back_picture_path']
                 ,$_SESSION['self_intro_up']
                 ,$_SESSION['self_intro_middle']
                 ,$_SESSION['self_intro_down']
                 ,$_SESSION['login_member_id']
                 );
    $stmt=$dbh->prepare($sql);
    $stmt->execute($data);
    header('Location:profile.php');
    exit();
  }


  ?>