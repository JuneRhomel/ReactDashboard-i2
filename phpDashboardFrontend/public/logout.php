<?php
include_once('../library.php');
global $rootpath;
session_start();
session_destroy();
$accountCode = $_SESSION['accountcode_enc']; // Retrieve the session variable
$redirectURL = $rootpathecho . "/?acctcode=" . $accountCode;
// Use the header function to perform the redirection
header("Location: $redirectURL");