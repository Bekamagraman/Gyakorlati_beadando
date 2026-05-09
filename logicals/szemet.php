<?php
session_start();

// ELLENŐRZÉS: Ha nincs bejelentkezett felhasználó, megtagadjuk a hozzáférést
if (!isset($_SESSION['bejelentkezes'])) {
    http_response_code(401); // Unauthorized státuszkód
    echo json_encode(["error" => "Bejelentkezés szükséges!"]);
    exit();
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$conn = new PDO("mysql:host=localhost;dbname=adatbazis;charset=utf8", "root", "");


$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

switch($method) {
    case 'GET':
        if (isset($_GET['type'])) {
            if ($_GET['type'] == 'helyek') {
                echo json_encode($conn->query("SELECT * FROM hely")->fetchAll(PDO::FETCH_ASSOC));
            } elseif ($_GET['type'] == 'fajtak') {
                echo json_encode($conn->query("SELECT * FROM fajta")->fetchAll(PDO::FETCH_ASSOC));
            }
        } else {
            $sql = "SELECT h.id as helyid, f.id as fajtaid, h.kerulet, h.cim, f.nev as fajta_nev 
                    FROM gyujt gy
                    JOIN hely h ON gy.helyid = h.id
                    JOIN fajta f ON gy.fajtaid = f.id
                    ORDER BY h.kerulet ASC";
            echo json_encode($conn->query($sql)->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    case 'POST':
        $sql = "INSERT INTO gyujt (helyid, fajtaid) VALUES (?, ?)";
        $conn->prepare($sql)->execute([$input['helyid'], $input['fajtaid']]);
        echo json_encode(["message" => "Hozzáadva"]);
        break;

    case 'PUT':
        // Szerkesztés: Töröljük a régit, hozzáadjuk az újat
        $del = "DELETE FROM gyujt WHERE helyid = ? AND fajtaid = ?";
        $conn->prepare($del)->execute([$input['old_helyid'], $input['old_fajtaid']]);
        
        $ins = "INSERT INTO gyujt (helyid, fajtaid) VALUES (?, ?)";
        $conn->prepare($ins)->execute([$input['new_helyid'], $input['new_fajtaid']]);
        echo json_encode(["message" => "Frissítve"]);
        break;

    case 'DELETE':
        $sql = "DELETE FROM gyujt WHERE helyid = ? AND fajtaid = ?";
        $conn->prepare($sql)->execute([$_GET['helyid'], $_GET['fajtaid']]);
        echo json_encode(["message" => "Törölve"]);
        break;
}