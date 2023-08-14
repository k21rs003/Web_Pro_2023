<h3 class="bg-primary">配属決定画面</h3>
<style>
    .blue{
        color: #FFF;
        background-color: #0099ff;
        border-radius: 6px;
    }
</style>

<?php
//---ここから--実行権限チェック---
if (!isset($_SESSION['urole'])){
  die ('<h3>エラー：この機能はログインしないと利用できません</h3>');
}elseif($_SESSION['urole'] != 2 ){
  die ('<h3>エラー：この機能は教員でないと利用できません</h3>');
}
//---ここまで--実行権限チェック---

require_once('db_inc.php');
$sid = $_GET['sid'];

$pid = 0;
$reason = '';

// 学生の希望状況を調べ、変数に$pid, $reasonに代入
$sql = "SELECT * FROM tbl_wish WHERE sid='{$sid}'";
$rs = $conn->query($sql);
$row= $rs->fetch_assoc();
if ($row){
  $pid = $row['pid'];
  $reason = $row['reason'];
}

// 学生情報を検索するSQL文
$sql = "SELECT * FROM tbl_student WHERE sid='{$sid}'";
$rs = $conn->query($sql);
// 問合せ結果を表形式で出力する。
//学籍番号(sid)、氏名(sname)、性別(sex)、GPA(gpa)、修得単位数(credit), 本人希望($pid)の一覧表示
?>
<table class="table table-bordered table-hover">
<tr><th>学籍番号</th><th>氏名</th><th>性別</th><th>GPA</th><th>修得単位数</th><th>本人希望</th><th>操作</th></tr>
<form action="?do=eps_decide_save" method="post">
<input type="hidden" name="sid" value="<?=$sid?>">
<?php 
$row= $rs->fetch_assoc();
if ($row){ // 最大1行しかないので、while文の代わり、if文を使う
  echo '<tr>';
  echo '<td>' . $row['sid'] . '</td>';
  //残り項目の出力・・・
  echo '<td>' . $row['sname']. '</td>';
  if($row['sex'] == 1){
    echo '<td>男</td>'; 
  }else{
    echo '<td>女</td>';
  }
  echo '<td>' . $row['gpa']. '</td>';
  echo '<td>' . $row['credit']. '</td>';
  if($pid == 1){
      echo '<td>総合教育</td>';
  }else if($pid == 2){
      echo '<td>応用教育</td>';
  }else{
      echo '<td></td>';
  }
  echo '<td>';
  // 配属決定のラジオボタン(name="decided")
  $decided= $row['decided'];
  $codes = array(
    1=>'総合教育', 
    2=>'応用教育', 
  );
  // foreach文で選択肢となるラジオボタンを出力する
  //・・・・
  foreach($codes as $key => $value){
      echo '<input type="radio" name="decided" value="'.$key.'" checked>'.$value;
  }
  echo '</td>';
  echo '</tr>';
}
?>

<tr>
<td><a href="?do=eps_list" class="btn btn-default">< 戻る</a></td><td colspan="5"></td>
<td><input type="submit" value="送信" class="btn btn-primary">&nbsp;
    <input type="reset" value="取消" class="btn btn-danger">
</td>
</tr>
</form>
</table>