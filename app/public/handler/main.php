<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: /login");
} else {
    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", "dbuser", "dbpwd");

    $statement = $pdo->query("SELECT * FROM products");
    $products = $statement->fetchAll();
}

require_once './html/main.php';