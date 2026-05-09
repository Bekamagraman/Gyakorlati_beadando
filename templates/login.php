<?php
session_start();
$db = mysqli_connect("localhost", "root", "", "gyakorlat7");

$üzenet = "";

// REGISZTRÁCIÓ FELDOLGOZÁSA
if (isset($_POST['regisztracio'])) {
    $login = mysqli_real_escape_string($db, $_POST['login_name']);
    $csaladi = mysqli_real_escape_string($db, $_POST['csaladi_nev']);
    $uto = mysqli_real_escape_string($db, $_POST['utonev']);
    $jelszo_titkos = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // SQL a te oszlopneveiddel
    $sql = "INSERT INTO felhasznalok (bejelentkezes, jelszo, csaladi_nev, uto_nev) 
            VALUES ('$login', '$jelszo_titkos', '$csaladi', '$uto')";
    
    if (mysqli_query($db, $sql)) {
        $üzenet = "Sikeres regisztráció! Most már bejelentkezhet.";
    } else {
        $üzenet = "Hiba: " . mysqli_error($db);
    }
}

// BEJELENTKEZÉS FELDOLGOZÁSA
if (isset($_POST['bejelentkezes_submit'])) {
    $login = mysqli_real_escape_string($db, $_POST['login_name']);
    $pass = $_POST['password'];

    // 1. Megkeressük a felhasználót
    $res = mysqli_query($db, "SELECT * FROM felhasznalok WHERE bejelentkezes = '$login'");
    $user = mysqli_fetch_assoc($res);

    if ($user) {
        // 2. Jelszó ellenőrzése
        if (password_verify($pass, $user['jelszo'])) {
            
            // 3. Ha minden stimmel, elmentjük a session-be a te oszlopneveidet
             $_SESSION['id'] = $user['id'];
            $_SESSION['bejelentkezes'] = $user['bejelentkezes'];
            $_SESSION['csaladi_nev'] = $user['csaladi_nev'];
            $_SESSION['uto_nev'] = $user['uto_nev'];
            
            header("Location: /index.php");
            exit();
        } else {
            $üzenet = "A jelszó nem stimmel!";
        }
    } else {
        $üzenet = "Nincs ilyen felhasználónév: " . htmlspecialchars($login);
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Belépés / Regisztráció</title>
     <link rel="stylesheet" href="/styles/style.css">
    <style>
        .container { display: flex; gap: 20px; font-family: Arial; }
        .box { border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 300px; }
        input { display: block; margin-bottom: 10px; width: 100%; padding: 5px; }
        button { width: 100%; padding: 8px; cursor: pointer; }
    </style>
</head>
<body>
    <a href="/index.php">← Vissza a főoldalra</a>
    <p><strong><?php echo $üzenet; ?></strong></p>
    
    <div class="container">
        <!-- Bejelentkezés -->
        <div class="box">
            <h2>Bejelentkezés</h2>
            <form method="POST">
                <input type="text" name="login_name" placeholder="Felhasználónév" required>
                <input type="password" name="password" placeholder="Jelszó" required>
                <button type="submit" name="bejelentkezes_submit">Belépés</button>
            </form>
        </div>

        <!-- Regisztráció -->
        <div class="box">
            <h2>Regisztráció</h2>
            <form method="POST">
                <input type="text" name="login_name" placeholder="Login név" required>
                <input type="text" name="csaladi_nev" placeholder="Családi név" required>
                <input type="text" name="utonev" placeholder="Utónév" required>
                <input type="password" name="password" placeholder="Jelszó" required>
                <button type="submit" name="regisztracio">Regisztráció</button>
            </form>
        </div>
    </div>
</body>
</html>