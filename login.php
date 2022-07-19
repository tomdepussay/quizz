<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
} catch (Exception $e) {
    die('Erreur : ' . $e -> getMessage());
};
#$categoriesStatement = $db -> prepare('SELECT * FROM categories');
#$choicesStatement = $db -> prepare('SELECT * FROM choices');
#$questionsStatement = $db -> prepare('SELECT * FROM questions');
$usersStatement = $db -> prepare('SELECT * FROM users');
#$user_scoresStatement = $db -> prepare('SELECT * FROM user_scores');

#$categoriesStatement->execute();
#$choicesStatement->execute();
#$questionsStatement->execute();
$usersStatement->execute();
#$user_scoresStatement->execute();

#$categories = $categoriesStatement->fetchAll();
#$choices = $choicesStatement->fetchAll();
#$questions = $questionsStatement->fetchAll();
$users = $usersStatement->fetchAll();
#$user_scores = $user_scoresStatement->fetchAll();


if (isset($_POST['email']) && isset($_POST['password'])) {
    foreach ($users as $user) {
        if ($user['email'] === $_POST['email'] && $user['password'] === $_POST['password']) {
            setcookie ("LOGGED_USER",$user['pseudo'],time()+ 365 * 24 * 3600);
            setcookie ("LOGGED_USER_ID",$user['user_id'],time()+ 365 * 24 * 3600);
            setcookie ("LOGGED_USER_EMAIL",$user['email'],time()+ 365 * 24 * 3600);
            header('Location:index.php');
            die();
        };
    };  
    if(!isset($_COOKIE['LOGGED_USER'])){
        $message_error = "Identifiant incorrect.";
    };
};
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz - Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <?php include_once('header.php') ?>
    <div class="container">
        <div class="flex-center flex-column">
            <h1>Veuillez-vous connecté :</h1>
            <div class="error">
                <p>
                    <?php if(isset($message_error)){echo $message_error;}?>
                </p>
            </div>
            <form action="login.php" method="post">
                <div class="field">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" name="email" class="form-input">
                </div>
                <div class="field">
                    <label for="password" class="form-label">Mot de passe : </label>
                    <input type="password" name="password" class="form-input">
                </div>
                <div id="error">
                </div>
                <div id="center">
                    <button class="btn highlight" id="submit" type="submit">Envoyé</button>
                </div>
            </form>
            <div class="flex-center flex-column">
                <p id="register-link">Ou <a href="register.php">cliquer ici</a> pour créer un nouveau compte.</p>
            </div>
        </div>
    </div>
</body>
</html>