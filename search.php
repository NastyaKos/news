<?php
include_once 'db.php';

$newsSQL = $dbh->prepare('SELECT * FROM news WHERE `name` LIKE :name OR `description` LIKE :descr');
$newsSQL->bindValue(":name", '%'.$_POST['query'].'%');
$newsSQL->bindValue(":descr", '%'.$_POST['query'].'%');
$newsSQL->execute();

$news = $newsSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
    if(!empty($news)){
        echo "<h2>Find:</h2>";
        foreach($news as $n){
            echo '<p>'.$n['name'].'</p><hr>';
        }
    }else{
        echo "<h2>Nothing</h2>";
    }

    ?>
</body>
</html>
