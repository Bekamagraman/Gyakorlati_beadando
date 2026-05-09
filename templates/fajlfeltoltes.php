<?php
session_start();

// Biztonság: Ha nem tag, ne csináljon semmit
if (!isset($_SESSION['bejelentkezes'])) {
    die("Nincs jogosultságod!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['kep_fajl'])) {
    $cel_mappa = "../images/";
    
    // Eredeti fájlnév és kiterjesztés
    $fajl_nev = basename($_FILES["kep_fajl"]["name"]);
    $cel_fajl = $cel_mappa . $fajl_nev;
    $tipus = strtolower(pathinfo($cel_fajl, PATHINFO_EXTENSION));

    // Alapvető ellenőrzések
    $hiba = "";

    // 1. Valóban kép-e?
    $check = getimagesize($_FILES["kep_fajl"]["tmp_name"]);
    if($check === false) $hiba = "A fájl nem kép.";

    // 2. Méret korlátozás (pl. max 5MB)
    if ($_FILES["kep_fajl"]["size"] > 5000000) $hiba = "Túl nagy a fájl mérete.";

    // 3. Formátum szűrés
    if(!in_array($tipus, ["jpg", "jpeg", "png", "gif", "webp"])) $hiba = "Csak JPG, PNG, GIF és WEBP engedélyezett.";

    // Ha nincs hiba, feltöltjük
    if ($hiba == "") {
        if (move_uploaded_file($_FILES["kep_fajl"]["tmp_name"], $cel_fajl)) {
            header("Location: /templates/galeria.php?siker=1");
        } else {
            echo "Hiba történt a másolás során.";
        }
    } else {
        echo "Hiba: " . $hiba;
    }
}
?>