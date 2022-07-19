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
$total_question = 0;
$total_question_categorie = 0;

foreach ($questions as $question_counter){
    $total_question = $total_question + 1;
    if ($question_counter['categorie_id'] == $_GET['categorie']){
        $total_question_categorie = $total_question_categorie + 1;
    };
};

if ($total_question_categorie == 10){
    header("Location: index.php");
    die();
};

if (isset($_POST['question']) && $_POST['choice1'] && $_POST['choice2'] && $_POST['choice3'] && $_POST['choice4'] && $total_question_categorie <= 10) {
    $sql = "INSERT INTO questions (question_number, categorie_id, text) VALUES (:question_number, :categorie_id, :text)";
    $stmt = $db->prepare($sql);
    $stmt->execute(['question_number' => $total_question + 1, 'categorie_id' => $_GET['categorie'], 'text' => $_POST['question']]);
    for ($j = 1; $j <= 4; $j = $j + 1){
        $sql = "INSERT INTO choices (question_number, is_correct, text) VALUES (:question_number, :is_correct, :text)";
        $stmt = $db->prepare($sql);
        $stmt->execute(['question_number' => $total_question + 1, 'is_correct' => is_correct($_POST['correct' . $j]), 'text' => $_POST['choice' . $j]]);
    };
};

function is_correct($a){
    if(isset($a)){
        if (!empty($a)){
            return 1;
        } else {
            return 0;
        };
    } else {
        return 0;
    };
};

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz - Ajout Question</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include_once('header.php') ?>
    <div class="container">
        <div class="flex-center flex-colomn">
            <h1>Création de la question :</h1>
            <div class="error">
                <p>
                    <?php if(isset($message_error)){echo $message_error;} ?>
                </p>
            </div>
            <form action="add_question.php?categorie=<?= $_GET['categorie']; ?>" method="post">
                <div class="field">
                        <label for="question" class="form-label">Question :</label>
                        <input type="text" class="form-input" name="question">
                    </div>
                    <div class="field">
                        <label for="choice" class="form-label">Choix 1 :</label>
                        <input type="text" class="form-input" name="choice1"><br>
                        <input type="checkbox" name="correct1" class="choice"/>
		                <label id="remember-label" for="correct1">Bonne réponse</label>
                    </div>
                    <div class="field">
                        <label for="choice" class="form-label">Choix 2 :</label>
                        <input type="text" class="form-input" name="choice2"><br>
                        <input type="checkbox" name="correct2" class="choice"/>
		                <label id="remember-label" for="correct2">Bonne réponse</label>
                    </div>
                    <div class="field">
                        <label for="choice" class="form-label">Choix 3 :</label>
                        <input type="text" class="form-input" name="choice3"><br>
                        <input type="checkbox" name="correct3" class="choice"/>
		                <label id="remember-label" for="correct3">Bonne réponse</label>
                    </div>
                    <div class="field">
                        <label for="choice" class="form-label">Choix 4 :</label>
                        <input type="text" class="form-input" name="choice4"><br>
                        <input type="checkbox" name="correct4" class="choice"/>
		                <label id="remember-label" for="correct4">Bonne réponse</label>
                    </div>
                    <div id="center">
                        <button class="btn highlight" id="submit" type="submit">Envoyé</button>
                    </div>
            </form>
        </div>
    </div>
</body>
</html>