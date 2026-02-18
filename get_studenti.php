<?php
header("Content-Type: application/json");

$host = "localhost";
$db   = "4AINF_scuola";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT id_studente, cognome, nome, DATE_FORMAT(data_nascita, '%Y-%m-%d') AS data_nascita, id_classe
            FROM studenti
            ORDER BY cognome, nome";

    $stmt = $pdo->query($sql);
    $studenti = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "ok" => true,
        "studenti" => $studenti
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "ok" => false,
        "message" => "Errore DB: " . $e->getMessage()
    ]);
}
