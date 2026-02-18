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

    $cognome = $data["cognome"];
    $nome = $data["nome"];
    $data_nascita = $data["data_nascita"];
    $id_classe = $data["id_classe"];

    $sql = "INSERT INTO studenti (cognome, nome, data_nascita, id_classe)
            VALUES (:cognome, :nome, :data_nascita, :id_classe)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":cognome", $cognome);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":data_nascita", $data_nascita);
    $stmt->bindParam(":id_classe", $id_classe);

    $stmt->execute();

    echo json_encode(["message" => "Studente inserito correttamente"]);

} catch(PDOException $e) {
    echo json_encode(["message" => "Errore: " . $e->getMessage()]);
}
?>
