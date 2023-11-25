<?php
include('../models/db.php');
session_start();

$authenticated = true;

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    session_destroy();
    header('Location:../view/login.php');
    exit();
}

if ($authenticated && isset($_POST['question_text'])) {
    $question_text = $_POST['question_text'];
    $user_id = 1; 
    addQuestion($user_id, $question_text);
}

$questions = getQuestions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-5">Liste des Questions</h2>

    <form method="get" action="home.php">
        <button type="submit" name="logout" onclick="return confirm('Are you sure you want to logout?');" class="btn btn-link">Logout</button>
    </form>

    <?php if ($authenticated) : ?>
        <h3>Poster une Nouvelle Question</h3>
        <form method="post" action="home.php">
            <div class="mb-3">
                <label for="response_text" class="form-label">Question:</label>
                <textarea class="form-control" id="question_text" name="question_text" ></textarea>
            </div>
            <button type="submit" name="new_response" class="btn btn-primary">Envoyer Question</button>
        </form>
    <?php endif; ?>

    <?php if (empty($questions)) : ?>
        <p>Aucune question n'a été trouvée.</p>
    <?php else : ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Email Utilisateur</th>
                    <th>Question</th>
                    <th>Réponses</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question) : ?>
                    <tr>
                        <td><?php echo $question['date']; ?></td>
                        <td>
                            <?php
                            // Check if $_SESSION['user'] is set before accessing its elements
                            echo isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : 'N/A';
                            ?>
                        </td>
                        <td><?php echo $question['question']; ?></td>
                        <td><a href="question.php?id=<?php echo $question['id']; ?>">Voir Réponses</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
