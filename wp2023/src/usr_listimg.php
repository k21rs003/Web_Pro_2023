<h3>画像付きアカウント一覧</h3>
<style>
th, td {
  border-bottom: 1px solid #555;
}
</style>
<?php
require_once('db_inc.php');
$sql = "SELECT * FROM tbl_user ORDER BY urole,uid";
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

$uroles= [1=>'学生', 2=>'教員', 9=>'管理者']; 
$domain = 'kyusan-u.ac.jp';
echo '<table>';
while ($row= $rs->fetch_assoc()) {
 list('uid'=>$uid, 'uname'=>$uname, 'urole'=>$i) = $row;
 printf('<tr><td><img src="img/%s.png" height="120"></td>',$uid);
 printf('<td>%s<br>%s<br>%s@%s<br>%s</td></tr>', $uid, $uname, $uid, $domain, $uroles[$i]);
}
echo '</table>';
?>