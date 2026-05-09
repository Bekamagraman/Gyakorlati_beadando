<?php session_start(); ?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Hulladékkezelő CRUD</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 30px; background: #f4f7f6; }
        .container { max-width: 900px; margin: auto; }
        .form-box { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
        th, td { padding: 12px; border: 1px solid #eee; text-align: left; }
        th { background: #2c3e50; color: white; }
        select, button { padding: 10px; margin: 5px; border-radius: 5px; border: 1px solid #ddd; }
        button { cursor: pointer; color: white; border: none; font-weight: bold; }
        .btn-add { background: #27ae60; }
        .btn-edit { background: #f39c12; }
        .btn-del { background: #e74c3c; }
        .btn-cancel { background: #95a5a6; }
    </style>
    </head>
<body>

<?php if (isset($_SESSION['bejelentkezes'])): ?>
    <div class="container">
        <p>Üdv, <?php echo $_SESSION['csaladi_nev']; ?>! | <a href="/index.php">Vissza</a> | <a href="/templates/logout.php">Kilépés</a></p>
        
        <div class="form-box" id="form-container">
            <div class="form-box" id="form-container">
        <h3 id="form-title">Új gyűjtési pont rögzítése</h3>
        
        <label>Helyszín (Kerület és Cím):</label>
        <select id="sel-hely"></select>
        
        <label>Hulladék típusa:</label>
        <select id="sel-fajta"></select>

        <input type="hidden" id="old-helyid">
        <input type="hidden" id="old-fajtaid">

        <button class="btn-add" id="btn-save" onclick="mentes()">Hozzáadás</button>
        <button class="btn-cancel" id="btn-cancel" style="display:none;" onclick="resetForm()">Mégse</button>
         </div>
            <table>
        <thead>
            <tr>
                <th>Kerület</th>
                <th>Cím</th>
                <th>Hulladék</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody id="adat-tabla"></tbody>
    </table>










    <script>
            const API_URL = '/logicals/szemet.php';
    let editMode = false;

    // 1. Lenyílók feltöltése az indításkor
    async function setupSelects() {
        const helyek = await axios.get(`${API_URL}?type=helyek`);
        const fajtak = await axios.get(`${API_URL}?type=fajtak`);

        const hSel = document.getElementById('sel-hely');
        const fSel = document.getElementById('sel-fajta');

        helyek.data.forEach(h => {
            hSel.innerHTML += `<option value="${h.id}">${h.kerulet} - ${h.cim}</option>`;
        });

        fajtak.data.forEach(f => {
            fSel.innerHTML += `<option value="${f.id}">${f.nev}</option>`;
        });
    }
   // 2. Táblázat frissítése
    function frissit() {
        axios.get(API_URL).then(res => {
            const tbody = document.getElementById('adat-tabla');
            tbody.innerHTML = '';
            res.data.forEach(s => {
                tbody.innerHTML += `
                    <tr>
                        <td>${s.kerulet}</td>
                        <td>${s.cim}</td>
                        <td>${s.fajta_nev}</td>
                        <td>
                            <button class="btn-edit" onclick="szerkesztMod(${s.helyid}, ${s.fajtaid})">Szerkeszt</button>
                            <button class="btn-del" onclick="torol(${s.helyid}, ${s.fajtaid})">Törlés</button>
                        </td>
                    </tr>`;
            });
        });
    }

    // 3. Mentés (Hozzáadás vagy Frissítés)
    function mentes() {
        const adat = {
            helyid: document.getElementById('sel-hely').value,
            fajtaid: document.getElementById('sel-fajta').value
        };

        if (editMode) {
            axios.put(API_URL, {
                old_helyid: document.getElementById('old-helyid').value,
                old_fajtaid: document.getElementById('old-fajtaid').value,
                new_helyid: adat.helyid,
                new_fajtaid: adat.fajtaid
            }).then(() => { resetForm(); frissit(); });
        } else {
            axios.post(API_URL, adat).then(() => frissit());
        }
    }

    // 4. Szerkesztési mód aktiválása
    function szerkesztMod(hid, fid) {
        editMode = true;
        document.getElementById('form-title').innerText = "Kapcsolat módosítása";
        document.getElementById('btn-save').innerText = "Módosítás mentése";
        document.getElementById('btn-cancel').style.display = "inline-block";
        
        document.getElementById('sel-hely').value = hid;
        document.getElementById('sel-fajta').value = fid;
        document.getElementById('old-helyid').value = hid;
        document.getElementById('old-fajtaid').value = fid;
    }

    function resetForm() {
        editMode = false;
        document.getElementById('form-title').innerText = "Új gyűjtési pont rögzítése";
        document.getElementById('btn-save').innerText = "Hozzáadás";
        document.getElementById('btn-cancel').style.display = "none";
    }

    function torol(hid, fid) {
        if(confirm('Törlöd?')) axios.delete(`${API_URL}?helyid=${hid}&fajtaid=${fid}`).then(() => frissit());
    }

    setupSelects();
    frissit();
     
    </script>

<?php else: ?>
    <div style="text-align:center; margin-top:50px;">
        <h2>Hoppá! Ehhez be kell jelentkezned.</h2>
        <a href="/templates/login.php">Ugrás a bejelentkezéshez</a>
    </div>
<?php endif; ?>

</body>
</html>