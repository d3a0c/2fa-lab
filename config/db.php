<?php
// FILE: config/db.php

// Read the exact variables Railway uses, or fall back to local XAMPP if running locally
$host     = getenv('MYSQLHOST')     ?: '127.0.0.1';
$username = getenv('MYSQLUSER')     ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: ''; // Blank for local XAMPP
$database = getenv('MYSQLDATABASE') ?: 'railway';
$port     = getenv('MYSQLPORT')     ?: '3306';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
