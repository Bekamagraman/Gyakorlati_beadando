<?php
session_start();

// Csak bejelentkezett felhasználó láthatja
if (!isset($_SESSION['bejelentkezes'])) {
    die("<h1>Hozzáférés megtagadva!</h1><p>Kérlek, jelentkezz be az üzenetek megtekintéséhez.</p>");
}

$db = new PDO('mysql:host=localhost;dbname=gyakorlat7;charset=utf8', 'root', '');

// Lekérdezés kapcsolva a felhasznalok táblával (LEFT JOIN)
$query = "SELECT m.tartalom, m.letrehozva, m.bejelentkezve, f.csaladi_nev, f.uto_nev 
          FROM megjegyzesek m 
          LEFT JOIN felhasznalok f ON m.felhasznalo_id = f.id 
          ORDER BY m.letrehozva DESC";

$lista = $db->query($query);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Üzenetek listája</title>
    <style>
        table { width: 80%; border-collapse: collapse; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
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
    <h1 style="text-align:center;">Beérkezett üzenetek</h1>
    <div>
    <table>
        <tr>
            <th>Küldő neve</th>
            <th>Üzenet</th>
            <th>Dátum</th>
        </tr>
        <?php foreach ($lista as $sor): ?>
            <tr>
                <td>
                    <?php 
                        echo ($sor['bejelentkezve'] == 1) 
                             ? htmlspecialchars($sor['csaladi_nev'] . " " . $sor['uto_nev']) 
                             : "Vendég"; 
                    ?>
                </td>
                <td><?php echo htmlspecialchars($sor['tartalom']); ?></td>
                <td><?php echo $sor['letrehozva']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
</body>
</html>