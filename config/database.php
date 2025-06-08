<?php
$host = 'db';
$db = 'boardgames';
$user = 'root';
$pass = 'root';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    return new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}
