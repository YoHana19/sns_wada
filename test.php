<?php

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<button type="button" id="test-button">増やす</button>
<div id="test">
  <?php for ($i=0; $i < 2; $i++) { ?> 
    <h1>hoge</h1>
  <?php } ?>
  <div style="position: fixed; top: 200px; left: 200px; background-color: yellow; z-index: 20;" ><h1>hugahuga</h1></div>
</div>

<div style="width: 300px; height: 300px; position: fixed; top: 150px; left: 150px; background-color: green; z-index: 4;">
  huge
</div>

<div class="hoge" style="background-color: red; width: 100%; height: 50px; margin-top: 30px;"></div>

<script src="assets/js/jquery-3.1.1.js"></script>
<script src="assets/js/jquery-migrate-1.4.1.js"></script>

<script>
  function colHeight() {
    var height = $('body').outerHeight();
    console.log(height);
  }
</script>

<script type="text/javascript">
  colHeight();
  var ws = $(window).height();
  console.log(ws);
  var footer_height = $('.hoge').outerHeight(true);
  console.log(footer_height);
  $('#test-button').click(function() {
    $('#test').append('<h1>huga</h1>');
    colHeight();
  });
</script>

</body>
</html>