<?php
session_start();


$host = 'localhost';
$dbname = 'gyakorlat7';
$user = 'root';
$pass = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Adatbázis hiba: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uzenet = isset($_POST['uzenet']) ? trim($_POST['uzenet']) : '';

    // Szerveroldali ellenőrzés
    if (strlen($uzenet) < 5) {
        die("Szerveroldali hiba: Az üzenet túl rövid!");
    }

    // Ki van bejelentkezve? (Feltételezzük, hogy a login-nál elmentetted a $_SESSION['id']-t)
    $bejelentkezve = isset($_SESSION['id']) ? 1 : 0;
    $felhasznalo_id = $bejelentkezve ? $_SESSION['id'] : NULL;
    $idopont = date('Y-m-d H:i:s');

    // Mentés az adatbázisba
    $sql = "INSERT INTO megjegyzesek (felhasznalo_id, tartalom, letrehozva, bejelentkezve) 
            VALUES (:fid, :szoveg, :ido, :bej)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':fid' => $felhasznalo_id,
        ':szoveg' => $uzenet,
        ':ido' => $idopont,
        ':bej' => $bejelentkezve
    ]);

    // Megjelenítés "ötödik" oldalként
    echo "<h1>Üzenet elküldve!</h1>";
    echo "<p><strong>Küldés ideje:</strong> $idopont</p>";
    echo "<p><strong>Üzeneted:</strong> " . htmlspecialchars($uzenet) . "</p>";
    echo "<a href='/index.php'>Vissza az űrlaphoz</a>";
}
?>