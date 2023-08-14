<!DOCTYPE html>
<html lang="ja"><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>EPS:教育プログラム配属希望調査</title>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="navbar navbar-inverse bg-primary">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">ナビゲーションの切替</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">HOME</a>
    </div>  <!-- /.navbar-header -->
    <div class="navbar-collapse collapse">
    <ul class="nav navbar-nav navbar-right">
<?php
if (isset($_SESSION['urole'])){
  $menu = array();
  if ($_SESSION['urole']==1){  //学生
    $menu = array(   //学生メニュー
      '成績確認'  => 'eps_grade',
      '希望登録'  => 'eps_submit',
      '配属結果'  => 'eps_result',
    );
  }
  if($_SESSION['urole']==2) { //教員
    $menu = array(   //教員メニュー
      '希望一覧・配属決定'  => 'eps_list',
      '未登録者'  => 'eps_noentry',
      '希望集計'  => 'eps_summary',
    );
  }
  if($_SESSION['urole']==9) { //管理者
    $menu = array(   //管理者メニュー
      'アカウント一覧'  => 'usr_list',
      'アカウント登録'  => 'usr_edit',
    );
  }
  foreach($menu as $label=>$action){ 
    echo  '<li><a href="?do=' . $action . '">' . $label . '</a></li>' ;
  }
  echo  '<li><a href="?do=sys_logout">ログアウト</a></li>' ;
}else{
  echo  '<li><a href="?do=sys_login">ログイン</a></li>' ;
}
?>
    </ul>
    </div>
  </div>
</div>
<div class="container">