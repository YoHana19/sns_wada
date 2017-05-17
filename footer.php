<footer class="footer" bgproperties="fixd">
  <div class="footer-1">© 2017 SNS_wada, All rights reserved.
    <a href="#" title="facebook" target="_blank" style="color: #3b5998"><i class="fa fa-facebook"></i></a>
    <a href="#" title="twitter" target="_blank" style="color: #00a1e9"><i class="fa fa-twitter"></i></a>
  </div>
</footer>

<!-- コンテンツが少ない時のfooterの位置調整 -->
<script type="text/javascript">
  // ウィンドウの高さ取得
  var ws = $(window).height();
  // コンテンツの高さ取得
  var con_h = $('body').outerHeight(true);
  if (ws - con_h > 0) { // コンテンツの高さがウィンドウサイズに満たない時
    $('.footer').css({position : 'fixed'}); // footerをウィンドウの一番下に表示
  } else {
    $('.footer').css({position : 'relative'});
  }
</script>
