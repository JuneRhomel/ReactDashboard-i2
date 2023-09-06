<?php
include('../../config/config.php');
include('mailer.class.php');

$recipients = ['arnel@inventi.ph','virna.ong@inventi.ph'];
$recipients = ['arnel@inventi.ph'];


//fignvine
//figvineteam@gmail.com jidqyzhwalphzrvh
$username = 'sales@figvinefloralstudio.com';
$password = 'LegitMail_FNV-21';
$host = 'smtp.gmail.com';

$username = 'property-management@wilcon.com.ph';
$password = 'h4BR9.LV7dfE';
$host = 'gator3407.hostgator.com';

$username = 'customercare_mutualfund@atram.com.ph';
$password = 'Cust0m3rC9r3@2021';
$host = 'smtp.office365.com';
$port = 587;

$mailer = new Mailer([
        'host' => $host,
        'username' => $username,
        'password' => $password,
        'port'=>587,
        'secure'=> 'tls',
        'debug' => 1
]);


//$mailer = new Mailer([]);

$send = $mailer->send([
                'subject'=>'test',
                'body'=>'test email',
                'recipients'=> $recipients,
                'sender_email'=>$username,
                'sender_name'=>$username,
        ]);


var_dump($send);
