<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
} catch (Exception $e) {
    die('Erreur : ' . $e -> getMessage());
};

$usersStatement = $db -> prepare('SELECT * FROM users');
$usersStatement->execute();
$users = $usersStatement->fetchAll();
$total_user = 0;

foreach ($users as $user_counter){
    $total_user = $total_user + 1;
};


if (isset($_POST['pseudo']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmed_password'])){
    if ($_POST['password'] != $_POST['confirmed_password']){
        $message_error = 'Vous avez donné deux mots de passe différent.';
    } elseif (iconv_strlen($_POST['password']) < 8) {
        $message_error = 'Le mot de passe doit contenir plus de 8 caractères';
    } else {
        foreach ($users as $user){
            if($_POST['email'] === $user['email']){
                $message_error = 'Cette adresse mail est déjà utilisée.';
            } elseif($_POST['pseudo'] === $user['pseudo']){
                $message_error = 'Ce pseudo est déjà pris.';
            };
        };
    };
    if (!isset($message_error)){
        $db->prepare("INSERT INTO users (user_id, pseudo, email, password) VALUES (:user_id, :pseudo, :email, :password)")->execute(['user_id' => $total_user + 1, 'pseudo' => $_POST['pseudo'], 'email' => $_POST['email'], 'password' => $_POST['password']]);;
        header('Location:login.php');
        die();
    };
};


#$sql = "INSERT INTO users (pseudo, email, password) VALUES (:pseudo, :email, :password)";
#$stmt = $db->prepare($sql);
#$stmt->execute(['pseudo' => $_POST['pseudo'], 'email' => $_POST['email'], 'password' => $_POST['password']]);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz - Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include_once('header.php') ?>
    <div class="container">
        <div class="flex-center flex-column">
            <h1>Création de compte :</h1>
            <div class="error">
                <p>
                    <?php if(isset($message_error)){echo $message_error;}?>
                </p>
            </div>
            <form action="register.php" method="post">

                <div class="field">
                    <label for="pseudo" class="form-label">Pseudo :</label>
                    <input type="text" class="form-input" name="pseudo">
                </div>

                <div class="field">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" name="email" class="form-input">
                </div>

                <div class="field">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input type="password" name="password" class="form-input">
                </div>

                <div class="field">
                    <label for="password" class="form-label">Confimer le mot de passe :</label>
                    <input type="password" name="confirmed_password" class="form-input">
                </div>

                <div id="center">
                    <button class="btn highlight" id="submit" type="submit">Envoyé</button>
                </div>
            </form>
            <div class="flex-center flex-column">
                <p id="register-link">Ou <a href="login.php">cliquer ici</a> pour vous connecter.</p>
            </div>
        </div>
    </div>
</body>
</html>