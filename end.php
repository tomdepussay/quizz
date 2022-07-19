<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
} catch (Exception $e) {
    die('Erreur : ' . $e -> getMessage());
};

$usersStatement = $db -> prepare('SELECT * FROM users');
$user_scoresStatement = $db -> prepare('SELECT * FROM user_scores');
$usersStatement->execute();
$user_scoresStatement->execute();
$users = $usersStatement->fetchAll();
$user_scores = $user_scoresStatement->fetchAll();

$save = true;
foreach($user_scores as $user_score){
    if ($user_score['user_id'] == $_COOKIE['LOGGED_USER_ID'] && $user_score['categorie_id'] == $_GET['categorie']){
        $save = false;
    };
};

if ($save == true   ){
    $sql = "INSERT INTO user_scores (user_id, categorie_id, score) VALUES (:user_id, :categorie_id, :score)";
    $stmt = $db->prepare($sql);
    $stmt->execute(['user_id' => $_COOKIE['LOGGED_USER_ID'], 'categorie_id' => $_GET['categorie'], 'score' => $_GET['score']]);
};
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz - Score</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include_once('header.php') ?>
    <div class="container">
        <div class="flex-center flex-column">
            <h1>Votre score est de : <?= $_GET['score']?></h1>
            <a href="index.php" class="btn">Retour au menu !</a>
        </div>
    </div>
</body>
</html>