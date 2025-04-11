<?php

$dsn = 'mysql:host=db;dbname=testdb;charset=utf8mb4';
$username = 'root';
$password = 'rootpassword';

$pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the `messages` table if it doesn't exist
    $createTableSQL = "
        CREATE TABLE IF NOT EXISTS messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            content TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $pdo->exec($createTableSQL);

    // Basic routing based on URI
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $content = 'testing';

            // Insert message into the database
            $stmt = $pdo->prepare("INSERT INTO messages (content) VALUES (:content)");
            $stmt->bindParam(':content', $content);
            $stmt->execute();
         
         $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($messages) {
            foreach ($messages as $message) {
                echo "ID: " . $message['id'] . "<br>";
                echo "Message: " . $message['content'] . "<br>";
                echo "Created at: " . $message['created_at'] . "<br><br>";
            }
        } else {
            echo "No messages found.";
        }
?>
