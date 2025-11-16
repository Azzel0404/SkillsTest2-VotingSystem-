<?php
include 'db.php';
session_start();

if (isset($_POST['login'])) {
    $voterId = $_POST['voterId'];
    $voterPass = $_POST['voterPass'];

    $query = "SELECT * FROM Voters WHERE voterID='$voterId' AND voterStat='active' AND voted='n'";
    $run = $conn->query($query);

    if ($run->num_rows > 0) {
        $row = $run->fetch_assoc();
        if (password_verify($voterPass, $row['voterPass'])) {
            $_SESSION['voterID'] = $voterId;
            header("Location: vote.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid credentials or voter already voted.";
    }
}

if (isset($_GET['error'])) {
    echo "You must log in first.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Voting System</title>
</head>
<body>
    <h2>Login to Vote</h2>
    <form method="post">
        VOTER ID: <input type="text" name="voterId" required><br>
        VOTER PASSWORD: <input type="password" name="voterPass" required><br>
        <button type="submit" name="login">Login</button>
        <button><a href = "index.html">Back</a></button>
    </form>
</body>
</html>
