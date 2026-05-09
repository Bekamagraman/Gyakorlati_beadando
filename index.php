<?php
session_start();
$videourl = "https://www.youtube.com/embed/uUmtJIBibMM?si=DOSoFf1iOH2reECf";
$convertedURL = str_replace("watch?v=","embed/", $videourl);

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Főoldal</title>
    <link rel="stylesheet" href="styles/style.css">
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
    <a href="index.php">Főoldal</a>
    
    <?php if (isset($_SESSION['bejelentkezes'])): ?>
        <a href="templates/szemetcrud.php">Hulladékkezelő (Admin)</a>
        <a href="templates/galeria.php">Galéria</a>
        <a href="templates/kapcsolat.php">Kapcsolat</a>   
        <a href="templates/uzenet.php">Üzenetek</a>     
        <a href="templates/logout.php">Kilépés</a>
         
    <?php else: ?>     
        <a href="templates/szemetcrud.php">Hulladékkezelő (Admin)</a>
        <a href="templates/galeria.php">Galéria</a>   
        <a href="templates/kapcsolat.php">Kapcsolat</a>   
        <a href="templates/uzenet.php">Üzenetek</a>     
        <a href="templates/login.php">Belépés</a>
    <?php endif; ?>
</nav>
</header>
<section>
    <h1>Üdvözöljük a weboldalon!</h1>
</section>
<aside>
    <iframe width="560" height="315" src="<?php echo $convertedURL; ?>" title="YouTube video player"
         frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
    </iframe>
    <video width="320" height="240" controls>
  <source src="kukas.mp4" type="video/mp4">
  A böngésződ nem támogatja a videó lejátszását.
</video>
</aside>
<div id="status">Keresem a pozíciódat...</div>
<div id="map-container">
    <iframe 
        id="googleMap"
        width="100%" 
        height="450" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        src="about:blank">
    </iframe>
</div>
<article>

</article>
<footer>Kincses Ármin [UY7NZC]</footer>
</body>
</html>
<script>
function getLocation() {
    const status = document.getElementById('status');
    const iframe = document.getElementById('googleMap');

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            // SIKER esetén:
            (position) => {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                
                status.innerHTML = "Pozíció megtalálva!";
                
                // Frissítjük az iframe forrását a te koordinátáiddal
                iframe.src = `https://maps.google.com/maps?q=${lat},${lon}&z=15&output=embed`;
            },
            // HIBA esetén (pl. elutasítottad a kérést):
            (error) => {
                status.innerHTML = "Hiba: A helymeghatározás nem sikerült vagy le van tiltva.";
                console.error(error);
            }
        );
    } else {
        status.innerHTML = "A böngésződ nem támogatja a helymeghatározást.";
    }
}

// Futtatás az oldal betöltésekor
window.onload = getLocation;
</script>