<?php
header("Content-Type: application/json");

$host = "localhost";
$db   = "4AINF_scuola";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents("php://input"), true);

    $id_studente  = $data["id_studente"] ?? null;
    $cognome      = $data["cognome"] ?? null;
    $nome         = $data["nome"] ?? null;
    $data_nascita = $data["data_nascita"] ?? null;
    $id_classe    = $data["id_classe"] ?? null;

    if (!$id_studente || !$cognome || !$nome || !$id_classe) {
        echo json_encode(["ok" => false, "message" => "Dati mancanti (id_studente, cognome, nome, id_classe)."]);
        exit;
    }

    // data_nascita può essere NULL
    if ($data_nascita === "") $data_nascita = null;

    $sql = "UPDATE studenti
            SET cognome = :cognome,
                nome = :nome,
                data_nascita = :data_nascita,
                id_classe = :id_classe
            WHERE id_studente = :id_studente";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":cognome", $cognome, PDO::PARAM_STR);
    $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
    $stmt->bindParam(":data_nascita", $data_nascita, $data_nascita === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    $stmt->bindParam(":id_classe", $id_classe, PDO::PARAM_STR);
    $stmt->bindParam(":id_studente", $id_studente, PDO::PARAM_INT);

    $stmt->execute();

    echo json_encode(["ok" => true, "message" => "Studente aggiornato con successo."]);

} catch (PDOException $e) {
    echo json_encode(["ok" => false, "message" => "Errore DB: " . $e->getMessage()]);
}
