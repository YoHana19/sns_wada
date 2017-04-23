<?php
session_start();
require('dbconnect.php');

$test1 = array('a' => '1',
               'b' => '2',
               'c' => '3'
              );

$test2 = array('d' => '1',
               'e' => '2',
               'f' => '3'
              );

var_dump($test1);
var_dump($test2);

$tests = array($test1, $test2);

foreach ($tests as $test) {
  $test += array('g' => '4',
                 'h' => '5'
                 );
  $tests['0'] = $test;
}

var_dump($tests);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <ul id="posts">
    <?php for ($i=0; $i < 40; $i++) { ?> 
      <li>
        <article>content</article>
      </li>
    <?php } ?>
    <li>
        <article>content_last</article>
    </li>
  </ul>

  <p id="loading">
    <img src="assets/images/loading.gif" alt="Loading…" style="display: none;">
  </p>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      var win = $(window);

      // Each time the user scrolls
      win.scroll(function() {
        // End of the document reached?
        if ($(document).height() - win.height() == win.scrollTop()) {
          $('#loading').show();
              var a = 1;
              <?php $b = '<script type="text/javascript">document.write(a);</script>'; ?>
              $('#posts').append("<p><?php if ($b==1) : ?><?php echo 'hello'; ?><?php endif ; ?></p>");
              }
                
              $('#loading').hide();
            
      });
    });
  </script>
</body>
</html>