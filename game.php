<?php 
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
$questions_final = array();
$choices_final = array();

foreach ($questions as $question){
    if ($question['categorie_id'] == $_GET['categorie']){
        $questions_final[] = $question;
        foreach ($choices as $choice){
            if ($choice['question_number'] == $question['question_number']){
                $choices_final[sizeof($questions_final)-1][] = $choice;
            };
        };
    };
};

function answer($liste){
    $i = 0;
    foreach ($liste as $elt){
        $i = $i + 1;
        if ($elt['is_correct'] == 1){
            return $i;
        };
    };
};
$score = 0;

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $categories[$_GET['categorie']-1]['name'] ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/game.css">
</head>
<body>
    <?php include_once('header.php') ?>
    <div class="container-game">
        <div class="justify-center flex-column game">
            <div class="hud">
                <div class="hud-item">
                    <p class="hud-prefix progressText">
                        Question
                    </p>
                </div>
                <div class="hud-item">
                    <p class="hud-prefix">
                        Score
                    </p>
                    <h1 class="hub-main-text score">
                        0
                    </h1>
                </div>
            </div>
            <h1 class="question">Quelle est la réponse a cette question ?</h1>
            <div class="choice-container">
                <p class="choice-prefix">A</p>
                <p class="choice-text" data-number="1">Choix 1</p>
            </div>
            <div class="choice-container">
                <p class="choice-prefix">B</p>
                <p class="choice-text" data-number="2">Choix 2</p>
            </div>
            <div class="choice-container">
                <p class="choice-prefix">C</p>
                <p class="choice-text" data-number="3">Choix 3</p>
            </div>
            <div class="choice-container">
                <p class="choice-prefix">D</p>
                <p class="choice-text" data-number="4">Choix 4</p>
            </div>
        </div>
    </div>

    <script>

const question = document.querySelector('.question');
const choices = Array.from(document.querySelectorAll('.choice-text'));
const progressText = document.querySelector('.progressText');
const scoreText = document.querySelector('.score');

let currentQuestion = {}
let acceptingAnswers = true
let score = 0
let questionCounter = 0
let availableQuestions = []

let questions = [
    {
        question: `<?= $questions_final[0]['text']; ?>`,
        choice1: `<?= $choices_final[0][0]['text']; ?>`,
        choice2: `<?= $choices_final[0][1]['text']; ?>`,
        choice3: `<?= $choices_final[0][2]['text']; ?>`,
        choice4: `<?= $choices_final[0][3]['text']; ?>`,
        answer: <?= answer($choices_final[0]); ?>,
    },
    {
        question: `<?= $questions_final[1]['text']; ?>`,
        choice1: `<?= $choices_final[1][0]['text']; ?>`,
        choice2: `<?= $choices_final[1][1]['text']; ?>`,
        choice3: `<?= $choices_final[1][2]['text']; ?>`,
        choice4: `<?= $choices_final[1][3]['text']; ?>`,
        answer: <?= answer($choices_final[1]); ?>,
    },
    {
        question: `<?= $questions_final[2]['text']; ?>`,
        choice1: `<?= $choices_final[2][0]['text']; ?>`,
        choice2: `<?= $choices_final[2][1]['text']; ?>`,
        choice3: `<?= $choices_final[2][2]['text']; ?>`,
        choice4: `<?= $choices_final[2][3]['text']; ?>`,
        answer: <?= answer($choices_final[2]); ?>,
    },
    {
        question: `<?= $questions_final[3]['text']; ?>`,
        choice1: `<?= $choices_final[3][0]['text']; ?>`,
        choice2: `<?= $choices_final[3][1]['text']; ?>`,
        choice3: `<?= $choices_final[3][2]['text']; ?>`,
        choice4: `<?= $choices_final[3][3]['text']; ?>`,
        answer: <?= answer($choices_final[3]); ?>,
    },
    {
        question: `<?= $questions_final[4]['text']; ?>`,
        choice1: `<?= $choices_final[4][0]['text']; ?>`,
        choice2: `<?= $choices_final[4][1]['text']; ?>`,
        choice3: `<?= $choices_final[4][2]['text']; ?>`,
        choice4: `<?= $choices_final[4][3]['text']; ?>`,
        answer: <?= answer($choices_final[4]); ?>,
    },
    {
        question: `<?= $questions_final[5]['text']; ?>`,
        choice1: `<?= $choices_final[5][0]['text']; ?>`,
        choice2: `<?= $choices_final[5][1]['text']; ?>`,
        choice3: `<?= $choices_final[5][2]['text']; ?>`,
        choice4: `<?= $choices_final[5][3]['text']; ?>`,
        answer: <?= answer($choices_final[5]); ?>,
    },
    {
        question: `<?= $questions_final[6]['text']; ?>`,
        choice1: `<?= $choices_final[6][0]['text']; ?>`,
        choice2: `<?= $choices_final[6][1]['text']; ?>`,
        choice3: `<?= $choices_final[6][2]['text']; ?>`,
        choice4: `<?= $choices_final[6][3]['text']; ?>`,
        answer: <?= answer($choices_final[6]); ?>,
    },
    {
        question: `<?= $questions_final[7]['text']; ?>`,
        choice1: `<?= $choices_final[7][0]['text']; ?>`,
        choice2: `<?= $choices_final[7][1]['text']; ?>`,
        choice3: `<?= $choices_final[7][2]['text']; ?>`,
        choice4: `<?= $choices_final[7][3]['text']; ?>`,
        answer: <?= answer($choices_final[7]); ?>,
    },
    {
        question: `<?= $questions_final[8]['text']; ?>`,
        choice1: `<?= $choices_final[8][0]['text']; ?>`,
        choice2: `<?= $choices_final[8][1]['text']; ?>`,
        choice3: `<?= $choices_final[8][2]['text']; ?>`,
        choice4: `<?= $choices_final[8][3]['text']; ?>`,
        answer: <?= answer($choices_final[8]); ?>,
    },
    {
        question: `<?= $questions_final[9]['text']; ?>`,
        choice1: `<?= $choices_final[9][0]['text']; ?>`,
        choice2: `<?= $choices_final[9][1]['text']; ?>`,
        choice3: `<?= $choices_final[9][2]['text']; ?>`,
        choice4: `<?= $choices_final[9][3]['text']; ?>`,
        answer: <?= answer($choices_final[9]); ?>,
    }
]

const SCORE_POINTS = 1
const MAX_QUESTIONS = 10

startGame = () => {
    questionCounter = 0
    score = 0
    availableQuestions = [...questions]
    getNewQuestion()
}

getNewQuestion = () => {
    if(availableQuestions.length === 0 || questionCounter > MAX_QUESTIONS) {
        // Save score
        return window.location.assign(`end.php?categorie=<?php echo $_GET['categorie']; ?>&score=` + score)
    }

    questionCounter++
    progressText.innerText = `Question ${questionCounter} of ${MAX_QUESTIONS}`
    
    const questionsIndex = Math.floor(Math.random() * availableQuestions.length)
    currentQuestion = availableQuestions[questionsIndex]
    question.innerText = currentQuestion.question

    choices.forEach(choice => {
        const number = choice.dataset['number']
        choice.innerText = currentQuestion['choice' + number]
    })

    availableQuestions.splice(questionsIndex, 1)

    acceptingAnswers = true
}

choices.forEach(choice => {
    choice.addEventListener('click', e => {
        if(!acceptingAnswers) return

        acceptingAnswers = false
        const selectedChoice = e.target
        const selectedAnswer = selectedChoice.dataset['number']

        let classToApply = selectedAnswer == currentQuestion.answer ? 'correct' : 'incorrect'

        if(classToApply === 'correct') {
            incrementScore(SCORE_POINTS)
        }

        selectedChoice.parentElement.classList.add(classToApply)

        setTimeout(() => {
            selectedChoice.parentElement.classList.remove(classToApply)
            getNewQuestion()

        }, 1000)
    })
})

incrementScore = num => {
    score +=num
    scoreText.innerText = score
}

startGame()



    </script>
</body>
</html>