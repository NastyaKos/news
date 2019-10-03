<?php
session_start();
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

include_once 'db.php';

$page = 1;
if(!empty($_GET['page'])) {
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    if(false === $page) {
        $page = 1;
    }
}

if(isset($_SESSION['news_per_page'])){
    $items_per_page = $_SESSION['news_per_page'];
}else{
    $items_per_page = 3;
}

$offset = ($page - 1) * $items_per_page;
$sql = "SELECT * FROM news";

if(isset($_SESSION['category']) && $_SESSION['category'] !== "all"){
    $sql .= " WHERE category='". $_SESSION['category'] . "'";
}

if(isset($_SESSION['sort'])){
    $sql .= " ORDER BY " . $_SESSION['sort'] . " DESC ";
}

$sql .= " LIMIT " . $offset . "," . $items_per_page;
$news = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

    <form name="search" method="post" action="search.php">
        <input type="search" name="query" placeholder="Search">
        <button type="submit">Find name</button>
    </form>
    <br>
    <form id="params" method="POST" action="variable.php">
        <label for="sort">Sort by:</label>
        <select name="sort" id="sort">
            <option value="views"<?php echo ($_SESSION['sort'] == "views") ? "selected" : "" ; ?>>Views</option>
            <option value="name"<?php echo ($_SESSION['sort'] == "name") ? "selected" : "" ; ?>>Name</option>
            <option value="category"<?php echo ($_SESSION['sort'] == "category") ? "selected" : "" ; ?>>Category</option>

        </select>

        <br>

        <label for="category">Category :</label>
        <select name="category" id="category">
            <option value="all"<?php echo ($_SESSION['category'] == "all") ? "selected" : "" ; ?>>All</option>
            <option value="politic"<?php echo ($_SESSION['category'] == "poitic") ? "selected" : "" ; ?>>Politic</option>
            <option value="games"<?php echo ($_SESSION['category'] == "games") ? "selected" : "" ; ?>>Games</option>

        </select>

        <br>

        <label for="news_per_page">News per page:</label>
        <select name="news_per_page" id="news_per_page">
            <option value="3"<?php echo ($_SESSION['news_per_page'] == "3") ? "selected" : "" ; ?>>3</option>
            <option value="10"<?php echo ($_SESSION['news_per_page'] == "10") ? "selected" : "" ; ?>>10</option>
            <option value="25"<?php echo ($_SESSION['news_per_page'] == "25") ? "selected" : "" ; ?>>25</option>
        </select>
        <br>
        <input type="submit" value="Apply">
    </form>
    <br>

    <?php
        foreach($news as $n){
            echo '<div>
                        <h2>'.$n['name'].'</h2>
                        <p>'.$n['description'].'</p>
                        <p style="color:grey;font-size:13px">views: <b>'.$n['views'].'</b>, category: <b>'.$n['category'].'</b></p>
                    </div>
                    <hr>';
        }
    
        $news = $dbh->query('SELECT * FROM news')->fetchAll(PDO::FETCH_ASSOC);
        $row_count = count($news);
        
        $page_count = (int)ceil($row_count / $items_per_page);
        
        for ($i = 1; $i <= $page_count; $i++) {
            if ($i === $page) { // если это текущая страница
                echo $i;
            } else { // вывод ссылок
                echo '<a href="?page=' . $i . '">' . $i . '</a>';
            }
        }
?>


<h3>Подписка на рассылку:</h3>
<form action="subscriber.php" method="POST">
    <input type="email" name="email" placeholder="example@gmail.com">
    <input type="submit" value="OK">
</form>
</body>
</html>