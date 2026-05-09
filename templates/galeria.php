<?php
session_start();
$mappa = "../images/"; 

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Képtár</title>
     <link rel="stylesheet" href="/styles/style.css">
    <style>
        .galeria { display: flex; flex-wrap: wrap; gap: 15px; }
        .kep-kartya { border: 1px solid #ccc; padding: 5px; border-radius: 5px; }
        .kep-kartya img { height: 150px; display: block; }
        .feltoltes-box { background: #eef; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px dashed #77a; }
    </style>
</head>
<body>
    <header>
        <div class="user-info">
        <?php
        // e) pont: Formátum: Bejelentkezett: Családi_név Utónév (Login_név)
        if (isset($_SESSION['bejelentkezes'])) {
            echo "Bejelentkezett: " . $_SESSION['csaladi_nev'] . " " . $_SESSION['uto_nev'] . " (" . $_SESSION['bejelentkezes'] . ")";
        }
        ?>
    </div>
     <nav>
    <a href="/index.php">Főoldal</a>
    
    <?php if (isset($_SESSION['bejelentkezes'])): ?>
        <a href="/templates/szemetcrud.php">Hulladékkezelő (Admin)</a>
        <a href="/templates/galeria.php">Galéria</a>
        <a href="/templates/kapcsolat.php">Kapcsolat</a>   
        <a href="/templates/uzenet.php">Üzenetek</a>     
        <a href="/templates/logout.php">Kilépés</a>
         
    <?php else: ?>     
        <a href="/templates/szemetcrud.php">Hulladékkezelő (Admin)</a>
        <a href="/templates/galeria.php">Galéria</a>   
        <a href="/templates/kapcsolat.php">Kapcsolat</a>   
        <a href="/templates/uzenet.php">Üzenetek</a>     
        <a href="/templates/login.php">Belépés</a>
    <?php endif; ?>
</nav>
    </header>
    <h1>Galéria</h1>

    <?php if (isset($_SESSION['bejelentkezes'])): ?>
        <div class="feltoltes-box">
            <strong>Be vagy jelentkezve!</strong>
            <form action="/templates/fajlfeltoltes.php" method="post" enctype="multipart/form-data">
                <input type="file" name="kep_fajl" required>
                <button type="submit">Kép feltöltése</button>
            </form>
        </div>
    <?php else: ?>
        <p><small>Csak tagok tölthetnek fel képet. <a href="/templates/login.php">Belépés</a></small></p>
    <?php endif; ?>

    <div class="galeria">
        <?php
        // Minden jpg, png, gif és webp fájl keresése a mappában
        $kepek = glob($mappa. "{*.jpg,*.jpeg,*.png,*.gif,*.webp}", GLOB_BRACE);

        if ($kepek) {
            foreach ($kepek as $kep) {
                echo '<div class="kep-kartya">';
                echo '    <img src="' . $kep . '" alt="Kép">';
                echo '    <p><small>' . basename($kep) . '</small></p>';
                echo '</div>';
            }
        } else {
            echo "<p>Még nincs kép a galériában.</p>";
        }
        ?>
    </div>

</body>
</html>