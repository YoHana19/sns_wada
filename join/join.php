<?php
session_start();
require('../dbconnect.php');

// 各入力値を保持する変数を用意
$nick_name = '';
$email = '';
$password = '';

// エラー格納用の配列を用意
$errors = array();

if (!empty($_POST)) {

    $nick_name = $_POST['nick_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // ページ内バリデーション
    if ($nick_name == '') {
        //ニックネームのフォームが空のため、画面にエラーを出力
        $errors['nick_name'] = 'blank'; 
        // blank部分はどんな文字列でも良い
    }
    if ($email == '') {
        //ニックネームのフォームが空のため、画面にエラーを出力
        $errors['email'] = 'blank'; 
        // blank部分はどんな文字列でも良い
    }
    if ($password == '') {
        //ニックネームのフォームが空のため、画面にエラーを出力
        $errors['password'] = 'blank'; 
        // blank部分はどんな文字列でも良い
    } elseif (strlen($password) < 4) {
        $errors['password'] = 'length';
    }

// メールアドレスの重複チェック
    if(empty($errors)){
      // DBのmembersテーブルに入力されたメールアドレスがあるかどうか検索し取得
      try{
          $sql = 'SELECT COUNT(*) AS `cnt` FROM `members` WHERE `email` = ?';
          // COUNT(*) AS `cnt` 前者を後者として使用するということ
          $data = array($email);
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);
          $record = $stmt->fetch(PDO::FETCH_ASSOC);
          var_dump($record);
          if ($record['cnt'] > 0) {
            // 同じメールアドレスがDB内に存在したため
            $errors['email'] = 'duplicate';
          }

      } catch(PDOException $e){
          echo 'SQL文実行時エラー : ' . $e->message();
      }
    }

    //エラーがなかった場合の処理
    if (empty($errors)) {
        header('Location: check.php');
        exit();
    }

} // if (!empty($_POST))の終わり
?>