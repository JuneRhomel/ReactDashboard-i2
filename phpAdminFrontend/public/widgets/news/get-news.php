<?php
header('Content-Type: application/json; charset=utf-8');
$news = $ots->execute('news','get-news',$_POST);
echo $news;