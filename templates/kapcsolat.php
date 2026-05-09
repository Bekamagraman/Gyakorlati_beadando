<?php
session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Kapcsolat</title>
    <style>
        .error { color: red; font-weight: bold; }
        .form-container { width: 300px; margin: 0 auto; }
        textarea { width: 100%; height: 100px; }
    </style>
    <link rel="stylesheet" href="/styles/style.css">

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
    <div class="form-container">
        <h1>Kapcsolat</h1>
        <form id="contactForm" action="/logicals/feldolgoz.php" method="POST" novalidate>
            <label for="uzenet">Üzenet:</label><br>
            <textarea name="uzenet" id="uzenet"></textarea>
            <div id="jsHiba" class="error"></div>
            <br>
            <button type="submit">Küldés</button>
        </form>
    </div>

    <script>
        document.getElementById('contactForm').onsubmit = function(e) {
            let uzenet = document.getElementById('uzenet').value.trim();
            let hibaHelye = document.getElementById('jsHiba');
            
            // Kliensoldali ellenőrzés
            if (uzenet.length < 5) {
                e.preventDefault(); // Megállítja az elküldést
                hibaHelye.innerText = "Hiba: Az üzenetnek legalább 5 karakternek kell lennie!";
            } else {
                hibaHelye.innerText = "";
            }
        };
    </script>
</body>
</html>