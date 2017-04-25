<?php
session_start();
require('dbconnect.php');

$user_id = 3;
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <div>
    <?php if($is_like = $is_like_stmt->fetch(PDO::FETCH_ASSOC)): ?>
      <!-- 申請済み -->
      <input type="submit" value="申請済み" id="<?php echo $user_id; ?>" class="like btn btn-danger btn-xs">
    <?php else: ?>
      <!-- 未申請 -->
      <input type="submit" value="友達申請" id="<?php echo $user_id; ?>" class="like btn btn-primary btn-xs">
    <?php endif; ?>
  </div>
</body>
</html>