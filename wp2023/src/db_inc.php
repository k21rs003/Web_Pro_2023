<?php 
//  $conn = new mysqli("localhost", "root", "", "wp2023");//＜開発時の環境設定＞
  $conn = new mysqli("localhost","k21rs003", "ksu/2023", "wdb23k21rs003");//＜運用時の環境設定＞
  if ($conn->connect_errno) die($conn->connect_error);
  $conn->set_charset('utf8'); //文字コードをutf8に設定（文字化け対策）
?>