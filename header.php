<?php session_start();

function return_index(){
    header('Location: index.php');
    die();
};

if(!isset($_COOKIE['LOGGED_USER'])){
    if (basename($_SERVER["PHP_SELF"]) != 'index.php'){
        if (basename($_SERVER["PHP_SELF"]) != 'login.php'){
            if (basename($_SERVER["PHP_SELF"]) != 'register.php'){
                return_index();
            };
        };
    };
};

if(isset($_COOKIE['LOGGED_USER'])){
    if (basename($_SERVER["PHP_SELF"]) === 'login.php'){
        return_index();
    };
    if (basename($_SERVER["PHP_SELF"]) === 'register.php'){
        return_index();
    };
};
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz - Header</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="left">
            <a href="index.php" class="btn highlight header">Quizz</a>
        </div>
        <?php if(isset($_COOKIE['LOGGED_USER'])): ?>
        <div class="right">
            <a href="profile.php" class="btn right-img"><img src="assets/profile.png"></a>
            <?php if($_COOKIE['LOGGED_USER_ID'] == 1): ?>
            <a href="add_categorie.php" class="btn right-img"><img src="assets/add.png"></a>
            <?php endif; ?>
            <button onclick="window.location.href='logout.php'" class="btn right-img"><img src="assets/logout.png"></button>
        </div>
        <?php endif;?>
    </header>
</body>
</html>