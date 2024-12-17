<?php
// Include configuration for DB connection
include('cfg.php');

// Funkcja do dodawania kategorii
function DodajKategorie($parentId, $name) {
    global $link;
    $stmt = $link->prepare("INSERT INTO kategorie (parent_id, name) VALUES (?, ?)");
    $stmt->bind_param("is", $parentId, $name);
    $stmt->execute();
    $stmt->close();
}

// Funkcja do usuwania kategorii
function UsunKategorie($id) {
    global $link;
    // Usuwamy podkategorie
    $stmt = $link->prepare("DELETE FROM kategorie WHERE parent_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Usuwamy kategorię
    $stmt = $link->prepare("DELETE FROM kategorie WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Funkcja do edytowania kategorii
function EdytujKategorie($id, $newName) {
    global $link;
    $stmt = $link->prepare("UPDATE kategorie SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $newName, $id);
    $stmt->execute();
    $stmt->close();
}

// Funkcja do wyświetlania kategorii w postaci drzewa
function PokazKategorie() {
    global $link;
    $result = $link->query("SELECT * FROM kategorie ORDER BY parent_id, name");
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[$row['parent_id']][] = $row;
    }
    displayCategoryTree(0, $categories);  // Zmieniamy na 0, aby wyświetlić kategorie nadrzędne
}

// Funkcja do rekurencyjnego wyświetlania drzewa kategorii
function displayCategoryTree($parentId, $categories) {
    // Jeśli istnieją kategorie dla danej kategorii nadrzędnej
    if (isset($categories[$parentId])) {
        echo "<ul>";
        // Iteracja przez wszystkie kategorie dla tego rodzica
        foreach ($categories[$parentId] as $category) {
            echo "<li>" . htmlspecialchars($category['name']); // Wyświetlanie nazwy kategorii
            // Rekurencyjne wywołanie dla podkategorii
            displayCategoryTree($category['id'], $categories);
            echo "</li>";
        }
        echo "</ul>";
    }
}

// Funkcja do wyświetlania formularzy
function PokazFormularze() {
    echo '<h2>Dodaj kategorię</h2>
    <form method="post">
        <label for="parentId">Rodzic (ID):</label>
        <input type="number" name="parentId" id="parentId" required><br>
        <label for="categoryName">Nazwa kategorii:</label>
        <input type="text" name="categoryName" id="categoryName" required><br>
        <button type="submit" name="addCategory">Dodaj kategorię</button>
    </form>

    <h2>Edytuj kategorię</h2>
    <form method="post">
        <label for="editId">ID kategorii do edycji:</label>
        <input type="number" name="editId" id="editId" required><br>
        <label for="newCategoryName">Nowa nazwa kategorii:</label>
        <input type="text" name="newCategoryName" id="newCategoryName" required><br>
        <button type="submit" name="editCategory">Edytuj kategorię</button>
    </form>

    <h2>Usuń kategorię</h2>
    <form method="post">
        <label for="deleteId">ID kategorii do usunięcia:</label>
        <input type="number" name="deleteId" id="deleteId" required><br>
        <button type="submit" name="deleteCategory">Usuń kategorię</button>
    </form>';
}

// Obsługa formularzy
if (isset($_POST['addCategory'])) {
    $parentId = $_POST['parentId'];
    $categoryName = $_POST['categoryName'];
    DodajKategorie($parentId, $categoryName);
}

if (isset($_POST['editCategory'])) {
    $editId = $_POST['editId'];
    $newCategoryName = $_POST['newCategoryName'];
    EdytujKategorie($editId, $newCategoryName);
}

if (isset($_POST['deleteCategory'])) {
    $deleteId = $_POST['deleteId'];
    UsunKategorie($deleteId);
}

?>
