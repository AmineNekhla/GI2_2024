<?php

$servername = "Localhost";
$username = "root";
$password = "";
$dbname = "forum";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

function adduser($nom, $email, $password) {
    global $conn;
    $sql = "INSERT INTO Users (nom, email, password) VALUES ('$nom', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        return true; 
    } else {
        return false; 
    }
}

function getUserByEmail($email) {
    global $conn;
    $sql = $conn->prepare("SELECT * FROM Users WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        return $user;
    } else {
        return null;
    }
}
function getQuestions() {
    global $conn;
    $sql = "SELECT * FROM questions ORDER BY date DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $questions = $result->fetch_all(MYSQLI_ASSOC);
        return $questions;
    } else {
        return array();
    }}
    function getReponses($question_id) {
        global $conn;
        $sql = "SELECT * FROM reponses WHERE question_id = ? ORDER BY date DESC";
        $dada = $conn->prepare($sql);
        $dada->bind_param("i", $question_id);
        $dada->execute();
        $result = $dada->get_result();
        if ($result->num_rows > 0) {
            $reponses = $result->fetch_all(MYSQLI_ASSOC);
            return $reponses;
        } else {
            return array();
        }}
        function addQuestion($user_id, $question_text) {
            global $conn;
        
            $user_id = mysqli_real_escape_string($conn, $user_id);
            $question_text = mysqli_real_escape_string($conn, $question_text);
        
            $sql = "INSERT INTO questions (user_id, question, date) VALUES ('$user_id', '$question_text', NOW())";
        
            if ($conn->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        }
        function addResponse($user_id, $question_id, $response_text) {
            global $conn;
        
            $user_id = mysqli_real_escape_string($conn, $user_id);
            $question_id = mysqli_real_escape_string($conn, $question_id);
            $response_text = mysqli_real_escape_string($conn, $response_text);
        
            $sql = "INSERT INTO Reponses (user_id, question_id, reponse, date) VALUES ('$user_id', '$question_id', '$response_text', NOW())";
        
            if ($conn->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        }


        // In your db.php file or another appropriate location
        function getQuestionById($question_id) {
            global $conn;
        
            // Escape special characters to prevent SQL injection
            $question_id = mysqli_real_escape_string($conn, $question_id);
        
            // SQL query to get the question details based on ID
            $sql = "SELECT Q.*, U.nom AS nom_user, U.email AS email_user FROM questions Q
                    JOIN users U ON Q.user_id = U.id
                    WHERE Q.id = $question_id";
        
            $result = $conn->query($sql);
        
            if ($result && $result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return null; // Return null if no question is found
            }
        }
        
?>
