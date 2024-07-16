<?php
session_start();

$servername = "db";
$username = "root";
$password = "";
$database = "vulnerable_db";

// Connessione al database
$conn = new mysqli($servername, $username, $password, $database);

// Controllo della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Abilitare multi_query per consentire query multiple
$conn->multi_query = true;

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Query vulnerabile con la concatenazione diretta di input non sanitizzato
    $sql = "SELECT id, username FROM users WHERE username = '$inputUsername' AND password = '$inputPassword';";

    // Esecuzione della query
    if ($conn->multi_query($sql)) {
        do {
            // Store the first result set
            if ($result = $conn->store_result()) {
                if ($result->num_rows > 0) {
                    $_SESSION['username'] = $inputUsername;
                    header("Location: welcome.php");
                    exit();
                } else {
                    $message = "Credenziali non valide. Riprova.";
                }
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());
    } else {
        $message = "Errore nell'esecuzione della query: " . $conn->error;
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
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 300px; 
            margin: 0 20px; 
        }
        h2 {
            text-align: center;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 15%); 
            padding: 10px;
            margin: 10px 10px; 
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 10px 6px; 
            width: calc(100% - 5%);  
        }
        input[type="submit"]:hover {
            background-color: #0056b3; 
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
