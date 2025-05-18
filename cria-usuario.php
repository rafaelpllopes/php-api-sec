<?php

use Alura\Mvc\Controller\LoginController;
use Alura\Mvc\Repository\UserRepository;

require __DIR__ . '/vendor/autoload.php';

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

// $sql = "INSERT INTO users (email, password) VALUES (?, ?);";

// $email = $argv[1];
// $password = $argv[2];

// $hash = password_hash($password, PASSWORD_ARGON2ID);

// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(1, $email);
// $stmt->bindValue(2, $hash);

// $stmt->execute();


$login = new UserRepository($pdo);
$user = $login->login('email@example.com');


// $loginController = new LoginController($login);

echo $user->id . PHP_EOL;
echo $user->email . PHP_EOL;
echo $user->password . PHP_EOL;