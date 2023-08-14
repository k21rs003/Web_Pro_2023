<h3>画像付きアカウント詳細</h3>
<?php
require_once('db_inc.php');
$uid  = $_GET['uid']; 
$sql = "SELECT * FROM tbl_user WHERE uid='{$uid}'";
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
$uroles = array(1=>'学生', 2=>'教員', 9=>'管理者' );
$domain = 'kyusan-u.ac.jp';
$row= $rs->fetch_assoc();
if ($row) {
 //list('uid'=>$id, 'uname'=>$name, 'urole'=>$i) = $row;
 $id = $row['uid'];
 $name = $row['uname'];
 $i = $row['urole'];
 $urole = $uroles[$i];
 echo '<img src="img/'. $id .'.png" height="180"><br>';
 echo "{$id} {$name} ({$urole})<br>";
 echo "{$id}@{$domain}";
 echo '<br><a href="?do=usr_edit&uid=' . $uid . '">編集</a>';//if文内に追加
}else{
 echo 'このユーザは存在しません！';
}
?>