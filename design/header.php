<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
  <nav class="navbar navbar-webmaster" style="width:'auto'; height: 80px">
    <div class=""></div>
    <div class="header-bk">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">和だ</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar">
        <form class="navbar-form navbar-right search-form form-horizontal" role="search">
          <!-- 検索フォーム -->
          <div id="custom-search-input">
            <div class="input-group">
              <input type="text" class="search-query form-control" placeholder="search">
              <span class="input-group-btn">
                <button class="btn btn-danger" type="button">
                  <span class="glyphicon glyphicon-search" style="color: #dcdddd"></span>
                </button>
              </span>
            </div>
          </div>
          <input type="button" class="btn btn-info haiku-input" value="詠む">
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="#">友達リクエスト<span class="sr-only">(current)</span></a></li>
          <li class="active"><a href="#">個人ページ<i class="fa fa-user-circle-o" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
          <li class="active"><a href="#">chat<span class="sr-only">(current)</span></a></li>
          <li class="active"><a href="#">友達一覧<span class="sr-only">(current)</span></a></li>
          <li class="active"><a href="#">ランク・コラム<span class="sr-only">(current)</span></a></li>
          <li id="logout" class=""><a href="#logoutModal" data-toggle="modal" data-target="#logoutModal">ログアウト</a></li>
        </ul>
      </div>
    </div>
  </nav>
	</nav>

	<script src="../assets/js/bootstrap.js"></script>
	<!-- <script src="../assets/js/chart.js"></script>-->
</body>
</html>