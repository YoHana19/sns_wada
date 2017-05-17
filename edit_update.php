<?php
session_start();
require('dbconnect.php');

  if (empty($_SESSION['errors'])) {
    $sql = 'UPDATE  `members` SET `nick_name`=?,
                                  `email`=?,
                                  `self_intro_1`=?,
                                  `self_intro_2`=?,
                                  `self_intro_3`=?
                              WHERE `member_id`=?';
    $data = array($_SESSION['nick_name'],
                  $_SESSION['email'],
                  $_SESSION['self_intro_1'],
                  $_SESSION['self_intro_2'],
                  $_SESSION['self_intro_3'],
                  $_SESSION['login_member_id']
                 );
    $stmt=$dbh->prepare($sql);
    $stmt->execute($data);
    header('Location:profile.php');
    exit();
  } else {
    header('Location:profile.php');
    exit();
  }

 ?>