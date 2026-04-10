<?php
try {
    $dbh = new PDO('mysql:host=127.0.0.1', 'root', '');
    $dbh->exec('CREATE DATABASE IF NOT EXISTS ecommerce');
    echo "Database created successfully.\n";
} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage() . "\n");
}
