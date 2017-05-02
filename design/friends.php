<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/> -->
  <link rel="stylesheet" type="text/css" href="../assets/css/left_sideber.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/friends.css">
</head>

<body>

  <div class="container">
    <div class="row content">
      <div class="col-md-3 left-content">
        <?php require('friends_left.php'); ?>
      </div>

      <div class="col-md-8 right-content">
        <?php require('friends_ranking.php'); ?>
      </div>
    </div>
  </div>

</body>
</html>