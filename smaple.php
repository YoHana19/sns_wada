<?php
$test = array('a', 'b', 'c');
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <button type="submit" id="sample"></button>
  
  <div id="target">
    <p>ターゲットだゆん</p>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>

  <script type="text/javascript">
    var test = ['b', 'c'];
    $('#sample').click(function() // inputタグがクリックされたら実行
    {
      $('#target').prepend('<p>' + test['1'] + '</p>');
    });
  </script>
</body>
</html>