<?php

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style>
    .hukidasi{
        width: 300px;
        margin: 0 auto;
        padding: 8px 0;
        border: 1px solid #aaa;
        border-radius: 12px;
        text-align: center;
        position: relative;
    }
    .hukidasi:before{
        content: "";
        border: 12px solid transparent;
        border-top: 12px solid #fff;
        position: absolute;
        right: 30%;
        bottom: -23px;
        z-index: 2;
    }
  </style>
</head>
<body>
<div class="hukidasi">吹き出し</div>

<script src="assets/js/jquery-3.1.1.js"></script>
<script src="assets/js/jquery-migrate-1.4.1.js"></script>



</body>
</html>