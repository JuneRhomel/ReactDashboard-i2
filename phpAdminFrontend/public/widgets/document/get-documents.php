<?php
header('Content-Type: application/json; charset=utf-8');
$documents = $ots->execute('document','get-documents',$_POST);
echo $documents;