<?php
// Dołączenie konfiguracji bazy danych
include('cfg.php');

// Funkcja do dodawania produktu
function DodajProdukt($tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_magazyn, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie) {
    global $link;
    $stmt = $link->prepare("INSERT INTO produkty 
        (tytul, opis, data_utworzenia, data_modyfikacji, data_wygasniecia, cena_netto, podatek_vat, ilosc_magazyn, status_dostepnosci, kategoria, gabaryt, zdjecie) 
        VALUES (?, ?, NOW(), NOW(), ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssddisssb", $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_magazyn, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie);
    $stmt->send_long_data(9, $zdjecie);
    $stmt->execute();
    $stmt->close();
}

// Funkcja do usuwania produktu
function UsunProdukt($id) {
    global $link;
    $stmt = $link->prepare("DELETE FROM produkty WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Funkcja do edytowania produktu
function EdytujProdukt($id, $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_magazyn, $status_dostepnosci, $kategoria, $gabaryt) {
    global $link;
    $stmt = $link->prepare("UPDATE produkty SET 
        tytul = ?, opis = ?, data_modyfikacji = NOW(), data_wygasniecia = ?, cena_netto = ?, podatek_vat = ?, 
        ilosc_magazyn = ?, status_dostepnosci = ?, kategoria = ?, gabaryt = ? 
        WHERE id = ?");
    $stmt->bind_param("sssddiissi", $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_magazyn, $status_dostepnosci, $kategoria, $gabaryt, $id);
    $stmt->execute();
    $stmt->close();
}

// Funkcja do wyświetlania wszystkich produktów
function PokazProdukty() {
    global $link;
    $result = $link->query("SELECT * FROM produkty ORDER BY id DESC");
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . "<br>";
        echo "Tytuł: " . htmlspecialchars($row['tytul']) . "<br>";
        echo "Opis: " . htmlspecialchars($row['opis']) . "<br>";
        echo "Data utworzenia: " . $row['data_utworzenia'] . "<br>";
        echo "Cena netto: " . $row['cena_netto'] . " PLN<br>";
        echo "Ilość w magazynie: " . $row['ilosc_magazyn'] . "<br>";
        echo "<hr>";
    }
}

// Funkcja do wyświetlania formularzy
function PokazFormularzeProduktow() {
    echo '<h2>Dodaj produkt</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Tytuł:</label> <input type="text" name="tytul" required><br>
        <label>Opis:</label> <input type="text" name="opis" required><br>
        <label>Data wygaśnięcia:</label> <input type="date" name="data_wygasniecia" required><br>
        <label>Cena netto:</label> <input type="number" step="0.01" name="cena_netto" required><br>
        <label>VAT (%):</label> <input type="number" step="0.01" name="podatek_vat" required><br>
        <label>Ilość:</label> <input type="number" name="ilosc_magazyn" required><br>
        <label>Status:</label> <input type="text" name="status_dostepnosci" required><br>
        <label>Kategoria:</label> <input type="number" name="kategoria" required><br>
        <label>Gabaryt:</label> <input type="text" name="gabaryt" required><br>
        <label>Zdjęcie:</label> <input type="file" name="zdjecie" required><br>
        <button type="submit" name="addProduct">Dodaj produkt</button>
    </form>
    
    <h2>Usuń produkt</h2>
    <form method="post">
        <label>ID produktu:</label> <input type="number" name="deleteId" required><br>
        <button type="submit" name="deleteProduct">Usuń</button>
    </form>';
}

// Obsługa formularzy
if (isset($_POST['addProduct'])) {
    $tytul = $_POST['tytul'];
    $opis = $_POST['opis'];
    $data_wygasniecia = $_POST['data_wygasniecia'];
    $cena_netto = $_POST['cena_netto'];
    $podatek_vat = $_POST['podatek_vat'];
    $ilosc_magazyn = $_POST['ilosc_magazyn'];
    $status_dostepnosci = $_POST['status_dostepnosci'];
    $kategoria = $_POST['kategoria'];
    $gabaryt = $_POST['gabaryt'];
    $zdjecie = file_get_contents($_FILES['zdjecie']['tmp_name']);
    DodajProdukt($tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_magazyn, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie);
}

if (isset($_POST['deleteProduct'])) {
    $deleteId = $_POST['deleteId'];
    UsunProdukt($deleteId);
}

?>
