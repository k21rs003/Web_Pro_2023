<?php
//---ここから--実行権限チェック---
if (!isset($_SESSION['urole'])){
  die ('<h3>エラー：この機能はログインしないと利用できません</h3>');
}elseif($_SESSION['urole'] != 1 ){
  die ('<h3>エラー：この機能は学生でないと利用できません</h3>');
}
//---ここまで--実行権限チェック---

require_once('db_inc.php');

$uid = $_SESSION['uid']; //ログイン中のユーザのIDを取得
$sid = strtoupper($uid); //学籍番号（ユーザIDの大文字変換）を求める

// 変数の初期化。新規登録か編集かにより異なる。
$act = 'insert';// 新規登録の場合
$pid = 0;
$reason = '';

// 現在の希望を調べ、変数$pid、$reasonに代入
$sql = "SELECT * FROM tbl_wish WHERE sid='{$sid}'";
$rs = $conn->query($sql);
$row= $rs->fetch_assoc();
if ($row){ 
  $act = 'update';
  $pid = $row['pid'];
  $reason = $row['reason'];
}
?>

<h3 class="bg-primary">希望提出画面</h3>
<table class="table table-bordered table-hover">
 <tr><th>学籍番号</th><th>希望コース</th><th>理由</th></tr>
 <form action="?do=eps_save" method="post">
 <input type="hidden" name="act" value="<?=$act?>">
 <tr><td>
 <?php
 echo '<input type="hidden" name="sid" value="'.$sid.'">';//非表示送信
 echo "<b>$sid</b>";
 ?>
 </td>
 <td>
 <?php
  $codes = array(1=>'総合教育', 2=>'応用教育');
  foreach ($codes as $key => $value){
    echo '<input type="radio" name="pid" value="' . $key . '" checked>'.$value;
  }
?>  
 </td>
 <td>
 <!--<input type="textarea" name="reason" rows="2" clos="40" value="<?=$reason?>">-->
 <textarea name="reason" rows="2" cols="40"></textarea>
 </td>
 </tr>
</table>
<input type="submit" value="送信" class="btn btn-primary">&nbsp;
<input type="reset" value="取消" class="btn btn-danger">
</form>