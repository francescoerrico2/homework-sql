<?php
session_start();

$servername = "db";
$username = "root";
$password = "";
$database = "vulnerable_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Query vulnerabile
    $sql = "SELECT id, username FROM users WHERE username = '$inputUsername' and password = '$inputPassword'";
    
    // Log the SQL query for debugging
    error_log("Executing SQL: $sql");
    
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $_SESSION['username'] = $inputUsername;
        header("Location: welcome.php");
        exit();
    } else {
        $message = "Credenziali non valide. Riprova.";
    }

    // Verifica se la tabella users esiste ancora
    $checkTableSql = "SHOW TABLES LIKE 'users'";
    $checkResult = $conn->query($checkTableSql);

    if ($checkResult && $checkResult->num_rows == 0) {
        $message = "La tabella 'users' è stata cancellata!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 50px;
            border-radius: 0px;
            box-shadow: 0 0 0px rgba(0, 0, 0, 0.1);
            width: 300px;justify-content: center;
            align-items: center;
        }
        h2 {
            text-align: center;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="submit"] {
            background-color: #0000FF;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #539fec;
        }
        .message {
            color: red;
            text-align: center;
        }
    
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
