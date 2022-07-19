<?php
if($_COOKIE['LOGGED_USER_ID'] != 1){
    header("Location: index.php");
    die();
};

try {
    $db = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
} catch (Exception $e) {
    die('Erreur : ' . $e -> getMessage());
};

$categoriesStatement = $db -> prepare('SELECT * FROM categories');
$choicesStatement = $db -> prepare('SELECT * FROM choices');
$questionsStatement = $db -> prepare('SELECT * FROM questions');
$usersStatement = $db -> prepare('SELECT * FROM users');
$user_scoresStatement = $db -> prepare('SELECT * FROM user_scores');

$categoriesStatement->execute();
$choicesStatement->execute();
$questionsStatement->execute();
$usersStatement->execute();
$user_scoresStatement->execute();

$categories = $categoriesStatement->fetchAll();
$choices = $choicesStatement->fetchAll();
$questions = $questionsStatement->fetchAll();
$users = $usersStatement->fetchAll();
$user_scores = $user_scoresStatement->fetchAll();
$total_categorie = 0;

foreach($categories as $counter_categorie){
    $total_categorie = $total_categorie + 1;
};
if (isset($_POST['title'])){
    $sql = "INSERT INTO categories (categorie_id, name) VALUES (:categorie_id, :name)";
    $stmt = $db->prepare($sql);
    $stmt->execute(['categorie_id' => $total_categorie + 1, 'name' => $_POST['title']]);
    header('Location: add_question.php?categorie=' . $total_categorie + 1);
    die();
};

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz - Ajout</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include_once('header.php') ?>
    <div class="container">
        <div class="flex-center flex-column">
            <h1>Creation de catégorie :</h1>
            <div class="error">
                <p>
                    <?php if(isset($message_error)){echo $message_error;} ?>
                </p>
            </div>
            <form action="add_categorie.php" method="post">
                <div class="field">
                    <label for="title" class="form-label">Titre du quizz :</label>
                    <input type="text" class="form-input" name="title">
                </div>

                <div id="center">
                    <button class="btn highlight" id="submit" type="submit">Envoyé</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>