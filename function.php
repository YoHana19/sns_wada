<?php
function getFileNameFromUri() {
  $uri_arr = explode('/', $_SERVER['REQUEST_URI']);
  $last = end($uri_arr);
  $file_name = explode('?', $last);
  $file_name = $file_name[0];
  return $file_name;
}

// 上記関数を基に引数に与えられたファイル名と$file_nameが一致するかどうかを判定しtrue or falseをreturnする関数isFileName()を作成しfooter.phpで実行する。

// 時刻を日本式に変換する関数

function japaneseClock($time) {
  $time = explode(" ", $time);
  // ここで$time[0]には2016-04-01みたいなのが、$time[1]には08:45:35みたいなのが入っているはず。
  // $timestamp[1]を更にexplodeしてhourをいただく。

  $j_time = explode(":", $time[1]);
  
  $hour = $j_time[0];
  // $minute = $time[1];
  $hour = intval($hour);
  // echo $hour;
// echo $minute;

  switch ($hour) {
    case 23:
      $j_hour = '子';
      break;
    case 0:
      $j_hour = '子';
      break;
    case 1:
      $j_hour = '丑';
      break;
    case 2:
      $j_hour = '丑';
      break;
    case 3:
      $j_hour = '寅';
      break;
    case 4:
      $j_hour = '寅';
      break;
    case 5:
      $j_hour = '卯';
      break;
    case 6:
      $j_hour = '卯';
      break;
    case 7:
      $j_hour = '辰';
      break;
    case 8:
      $j_hour = '辰';
      break;
    case 9:
      $j_hour = '巳';
      break;
    case 10:
      $j_hour = '巳';
      break;
      case 11:
      $j_hour = '午';
      break;
    case 12:
      $j_hour = '午';
      break;
    case 13:
      $j_hour = '未';
      break;
    case 14:
      $j_hour = '未';
      break;
    case 15:
      $j_hour = '申';
      break;
    case 16:
      $j_hour = '申';
      break;
    case 17:
      $j_hour = '酉';
      break;
    case 18:
      $j_hour = '酉';
      break;
    case 19:
      $j_hour = '戌';
      break;
    case 20:
      $j_hour = '戌';
      break;
    case 21:
      $j_hour = '亥';
      break;
    case 22:
      $j_hour = '亥';
      break;
    default:
      $j_hour = 'エラー';
      break;

    $j_images = array();
    $j_images['子'] = array('image' => 'ne');
    $j_images['丑'] = array('image' => 'ushi');
    $j_images['寅'] = array('image' => 'tora');
    $j_images['卯'] = array('image' => 'u');
    $j_images['辰'] = array('image' => 'tatsu');
    $j_images['巳'] = array('image' => 'mi');
    $j_images['午'] = array('image' => 'uma');
    $j_images['未'] = array('image' => 'hitsuji');
    $j_images['申'] = array('image' => 'saru');
    $j_images['酉'] = array('image' => 'tori');
    $j_images['戌'] = array('image' => 'inu');
    $j_images['亥'] = array('image' => 'i');
  }

  return $j_hour;
}

function etoImage($time) {

  $time = explode(" ", $time);
  // ここで$time[0]には2016-04-01みたいなのが、$time[1]には08:45:35みたいなのが入っているはず。
  // $timestamp[1]を更にexplodeしてhourをいただく。

  $j_time = explode(":", $time[1]);
  
  $hour = $j_time[0];
  // $minute = $time[1];
  $hour = intval($hour);
  // echo $hour;
// echo $minute;

  $j_hour = array();

  switch ($hour) {
    case 23:
      $j_hour = array('name' => '子', 'image' => 'ne');
      break;
    case 0:
      $j_hour = array('name' => '子', 'image' => 'ne');
      break;
    case 1:
      $j_hour = array('name' => '丑', 'image' => 'ushi');
      break;
    case 2:
      $j_hour = array('name' => '丑', 'image' => 'ushi');
      break;
    case 3:
      $j_hour = array('name' => '寅', 'image' => 'tora');
      break;
    case 4:
      $j_hour = array('name' => '寅', 'image' => 'tora');
      break;
    case 5:
      $j_hour = array('name' => '卯', 'image' => 'u');
      break;
    case 6:
      $j_hour = array('name' => '卯', 'image' => 'u');
      break;
    case 7:
      $j_hour = array('name' => '卯', 'image' => 'tatsu');
      break;
    case 8:
      $j_hour = array('name' => '卯', 'image' => 'tatsu');
      break;
    case 9:
      $j_hour = array('name' => '卯', 'image' => 'mi');
      break;
    case 10:
      $j_hour = array('name' => '卯', 'image' => 'mi');
      break;
      case 11:
      $j_hour = array('name' => '卯', 'image' => 'uma');
      break;
    case 12:
      $j_hour = array('name' => '卯', 'image' => 'uma');
      break;
    case 13:
      $j_hour = array('name' => '卯', 'image' => 'hitsuji');
      break;
    case 14:
      $j_hour = array('name' => '卯', 'image' => 'hitsuji');
      break;
    case 15:
      $j_hour = array('name' => '卯', 'image' => 'saru');
      break;
    case 16:
      $j_hour = array('name' => '卯', 'image' => 'saru');
      break;
    case 17:
      $j_hour = array('name' => '卯', 'image' => 'tori');
      break;
    case 18:
      $j_hour = array('name' => '卯', 'image' => 'tori');
      break;
    case 19:
      $j_hour = array('name' => '卯', 'image' => 'inu');
      break;
    case 20:
      $j_hour = array('name' => '卯', 'image' => 'inu');
      break;
    case 21:
      $j_hour = array('name' => '卯', 'image' => 'i');
      break;
    case 22:
      $j_hour = array('name' => '卯', 'image' => 'i');
      break;
    default:
      $j_hour = 'エラー';
      break;
    
  }
  echo $j_hour['image'];
}

function japaneseDate($day) {
  $time = explode(" ", $day);
  // ここで$time[0]には2016-04-01みたいなのが、$time[1]には08:45:35みたいなのが入っているはず。
  // $timestamp[1]を更にexplodeしてhourをいただく。

  $time = explode("-", $time[0]);

  $month = intval($time[1]);
  $date = intval($time[2]);

  switch ($month) {
    case 1:
      $j_month = '睦月';
      break;
    case 2:
      $j_month = '如月';
      break;
    case 3:
      $j_month = '弥生';
      break;
    case 4:
      $j_month = '卯月';
      break;
    case 5:
      $j_month = '皐月';
      break;
    case 6:
      $j_month = '水無月';
      break;
    case 7:
      $j_month = '文月';
      break;
    case 8:
      $j_month = '葉月';
      break;
    case 9:
      $j_month = '長月';
      break;
    case 10:
      $j_month = '神無月';
      break;
    case 11:
      $j_month = '霜月';
      break;
    case 12:
      $j_month = '師走';
      break;

    default:
      $j_month = 'エラー';
      break;
  }


  switch ($date) {
    case 1:
      $j_date = '一';
      break;
    case 2:
      $j_date = '二';
      break;
    case 3:
      $j_date = '三';
      break;
    case 4:
      $j_date = '四';
      break;
    case 5:
      $j_date = '五';
      break;
    case 6:
      $j_date = '六';
      break;
    case 7:
      $j_date = '七';
      break;
    case 8:
      $j_date = '八';
      break;
    case 9:
      $j_date = '九';
      break;
    case 10:
      $j_date = '十';
      break;
    case 11:
      $j_date = '十一';
      break;
    case 12:
      $j_date = '十二';
      break;
    case 13:
      $j_date = '十三';
      break;
    case 14:
      $j_date = '十四';
      break;
    case 15:
      $j_date = '十五';
      break;
    case 16:
      $j_date = '十六';
      break;
    case 17:
      $j_date = '十七';
      break;
    case 18:
      $j_date = '十八';
      break;
    case 19:
      $j_date = '十九';
      break;
    case 20:
      $j_date = '二十';
      break;
    case 21:
      $j_date = '二十一';
      break;
    case 22:
      $j_date = '二十二';
      break;
    case 23:
      $j_date = '二十三';
      break;
    case 24:
      $j_date = '二十四';
      break;
    case 25:
      $j_date = '二十五';
      break;
    case 26:
      $j_date = '二十六';
      break;
    case 27:
      $j_date = '二十七';
      break;
    case 28:
      $j_date = '二十八';
      break;
    case 29:
      $j_date = '二十九';
      break;
    case 30:
      $j_date = '三十';
      break;
    case 31:
      $j_date = '三十一';
      break;
    default:
      $j_date = 'エラー';
      break;
  }

  $f_date = $j_month . ' ' . $j_date;
  return $f_date;
}

?>