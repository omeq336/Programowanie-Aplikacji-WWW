<?php
include('cfg.php');

function SprawdzDostep() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        FormularzLogowania();
        return false;
    }
    return true;
}

function FormularzLogowania() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['login'] == $GLOBALS['login'] && $_POST['pass'] == $GLOBALS['pass']) {
            $_SESSION['logged_in'] = true;
            header('Location: admin.php');
        } else {
            echo '<p>Niepoprawny login lub hasło</p>';
        }
    }

    echo '<form method="POST" action="">
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" required><br><br>
            <label for="pass">Hasło:</label>
            <input type="password" name="pass" id="pass" required><br><br>
            <button type="submit">Zaloguj</button>
          </form>';
}

if (!SprawdzDostep()) {
    exit();
}

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $baza);
if (!$link) {
    die("Nie udało się połączyć z bazą danych: " . mysqli_connect_error());
}

function EdytujPodstrone() {
    global $link;
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM page_list WHERE id = $id LIMIT 1";
        $result = mysqli_query($link, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo '<form method="POST" action="">
                    <label for="page_title">Tytuł:</label>
                    <input type="text" name="page_title" value="' . htmlspecialchars($row['page_title']) . '" id="page_title" required><br><br>
                    <label for="page_content">Treść:</label>
                    <textarea name="page_content" id="page_content" rows="10" cols="50" required>' . htmlspecialchars($row['page_content']) . '</textarea><br><br>
                    <label for="status">
                        <input type="checkbox" name="status" ' . ($row['status'] ? 'checked' : '') . ' id="status"> Aktywna
                    </label><br><br>
                    <button type="submit">Zapisz zmiany</button>
                  </form>';
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $page_title = mysqli_real_escape_string($link, $_POST['page_title']);
                $page_content = mysqli_real_escape_string($link, $_POST['page_content']);
                $status = isset($_POST['status']) ? 1 : 0;
                $update_query = "UPDATE page_list SET page_title='$page_title', page_content='$page_content', status=$status WHERE id=$id LIMIT 1";
                if (mysqli_query($link, $update_query)) {
                    echo '<p>Podstrona została zaktualizowana.</p>';
                } else {
                    echo '<p>Błąd przy aktualizacji podstrony.</p>';
                }
            }
        }
    }
}

function DodajNowaPodstrone() {
    global $link;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $page_title = mysqli_real_escape_string($link, $_POST['page_title']);
        $page_content = mysqli_real_escape_string($link, $_POST['page_content']);
        $status = isset($_POST['status']) ? 1 : 0;
        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$page_title', '$page_content', '$status')";
        if (mysqli_query($link, $query)) {
            echo '<p>Podstrona została dodana.</p>';
        } else {
            echo '<p>Błąd przy dodawaniu podstrony.</p>';
        }
    }

    echo '<form method="POST" action="">
            <label for="page_title">Tytuł:</label>
            <input type="text" name="page_title" id="page_title" required><br><br>
            <label for="page_content">Treść:</label>
            <textarea name="page_content" id="page_content" rows="10" cols="50" required></textarea><br><br>
            <label for="status">
                <input type="checkbox" name="status" id="status"> Aktywna
            </label><br><br>
            <button type="submit">Dodaj podstronę</button>
          </form>';
}

function UsunPodstrone() {
    global $link;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $delete_query = "DELETE FROM page_list WHERE id = $id LIMIT 1";
        
        if (mysqli_query($link, $delete_query)) {
            echo '<p>Podstrona została usunięta.</p>';
        } else {
            echo '<p>Błąd przy usuwaniu podstrony.</p>';
        }
    }
}

function ListaPodstron() {
    global $link;
    
    $query = "SELECT * FROM page_list LIMIT 10";
    $result = mysqli_query($link, $query);
    
    echo '<table border="1">
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Aktywna</th>
                <th>Operacje</th>
            </tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . htmlspecialchars($row['page_title']) . '</td>
                <td>' . ($row['status'] ? 'Tak' : 'Nie') . '</td>
                <td>
                    <a href="?akcja=edytuj&id=' . $row['id'] . '">Edytuj</a> | 
                    <a href="?akcja=usun&id=' . $row['id'] . '" onclick="return confirm(\'Czy na pewno chcesz usunąć tę podstronę?\')">Usuń</a>
                </td>
            </tr>';
    }

    echo '</table>';
}

if (isset($_GET['akcja'])) {
    if ($_GET['akcja'] === 'dodaj') {
        DodajNowaPodstrone();
    } elseif ($_GET['akcja'] === 'edytuj') {
        EdytujPodstrone();
    } elseif ($_GET['akcja'] === 'usun') {
        UsunPodstrone();
    }
} else {
    ListaPodstron();
}
?>
