<h3 class="bg-primary">成績確認</h3>
<?php
require_once('db_inc.php');
$uid = $_SESSION['uid']; //ログイン中のユーザのIDを取得
$sid = strtoupper($uid); //ユーザIDを大文字に変換し学籍番号を求める

// 一覧データを検索するSQL文
$sql = "SELECT * FROM tbl_student WHERE sid='{$sid}'";
//データベースへ問合せのSQL文($sql)を実行する・・・
$rs= $conn -> query($sql);
if(!$rs) die('エラー : '. $conn -> error);


// 問合せ結果を表形式で出力する。
echo '<table class="table table-bordered table-hover">';
echo '<tr><th>学籍番号</th><th>氏名</th><th>性別</th><th>GPA</th><th>取得単位数</th></tr>';
$row= $rs->fetch_assoc();
while ($row) {
//学籍番号(sid)、氏名(sname)、性別(sex)、GPA(gpa)、修得単位数(credit)を表示
 echo '<tr>';
 echo '<td>' . $row['sid'] . '</td>';
 echo '<td>' . $row['sname']. '</td>';
 if($row['sex'] == 1){
    echo '<td>男</td>'; 
}else{
   echo '<td>女</td>';
}
 echo '<td>' . $row['gpa']. '</td>';
 echo '<td>' . $row['credit']. '</td>';
 echo '</tr>';
 $row = $rs->fetch_assoc();//次の行へ
}
echo '</table>';

?>