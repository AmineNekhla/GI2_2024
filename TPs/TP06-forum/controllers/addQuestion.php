<?php
include('../models/db.php');
session_start();
$question_id = $_GET['id'];

$question = getQuestionById($question_id);

$responses = getReponses($question_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_response'])) {
    $response_text = $_POST['response_text'];
    $user_id = 1; 
    addResponse($user_id, $question_id, $response_text);
    header("Location: question.php?id=$question_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Question</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-5">Question</h2>

    <?php if ($question) : ?>
        <div class="mb-3">
            <strong>Date:</strong> <?php echo $question['date']; ?><br>
            <strong>Nom Utilisateur:</strong> <?php echo $question['nom_user']; ?><br>
            <strong>Email Utilisateur:</strong> <?php echo $question['email_user']; ?><br>
            <strong>Question:</strong> <?php echo $question['question']; ?>
        </div>
    <?php else : ?>
        <p>Question not found.</p>
    <?php endif; ?>

    <h3>Réponses</h3>

    <?php if ($responses) : ?>
        <ul>
            <?php foreach ($responses as $response) : ?>
                <li>
                    <strong>Date:</strong> <?php echo $response['date']; ?><br>
                    <strong>Email Utilisateur:</strong> <?php echo $_SESSION['user']['email']; ?><br>
                    <strong>Réponse:</strong> <?php echo $response['reponse']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Aucune réponse trouvée.</p>
    <?php endif; ?>

    <h3>Poster une Nouvelle Réponse</h3>
    <form method="post" action="">
        <div class="mb-3">
            <label for="response_text" class="form-label">Réponse:</label>
            <textarea class="form-control" id="response_text" name="response_text" required></textarea>
        </div>
        <button type="submit" name="new_response" class="btn btn-primary">Envoyer Réponse</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
