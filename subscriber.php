<?php

include_once 'db.php';

$subSQL = $dbh->prepare('INSERT INTO subscribers (`email`, `date`) VALUES (:email, :current_date)');
$subSQL->bindValue(":email", $_POST['email']);
$subSQL->bindValue(":current_date", date('Y-m-d'));
$subSQL->execute();

$lastNews = $dbh->query('SELECT * FROM news ORDER BY id DESC')->fetch();

$to      = 'nobody@example.com';
$subject = 'Thanks for subscribe';
$message = 'Thanks for subscribe. You can check our latest news - ' . $lastNews['name'];
$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

header('Location: /');