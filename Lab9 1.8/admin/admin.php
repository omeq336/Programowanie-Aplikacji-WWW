<?php

/*
 * Funkcja sprawdzająca dostęp użytkownika
 * Sprawdza, czy użytkownik jest zalogowany, jeśli nie, wyświetla formularz logowania.
 */
function SprawdzDostep() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        FormularzLogowania();  // Wywołanie funkcji formularza logowania, jeśli użytkownik nie jest zalogowany
        return false;
    }
    return true;
}

/*
 * Funkcja wyświetlająca formularz logowania
 * Obsługuje metodę POST do logowania użytkownika i sprawdzania poprawności danych.
 */
function FormularzLogowania() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Zabezpieczenie danych wejściowych przed atakami XSS
        $login = htmlspecialchars($_POST['login'], ENT_QUOTES, 'UTF-8');
        $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');
        
        // Sprawdzanie poprawności loginu i hasła
        if ($login === $GLOBALS['login'] && $pass === $GLOBALS['pass']) {
            $_SESSION['logged_in'] = true;
            header('Location: index.php');  // Przekierowanie na stronę główną po zalogowaniu
            exit;
        } else {
            echo '<p style="color: red;">Niepoprawny login lub hasło</p>';
        }
    }

    // Formularz logowania
    echo '<form method="POST" action="">
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" required><br><br>
            <label for="pass">Hasło:</label>
            <input type="password" name="pass" id="pass" required><br><br>
            <button type="submit">Zaloguj</button>
          </form>';
}

/*
 * Funkcja edytująca podstronę
 * Wyświetla formularz edycji strony oraz przetwarza dane po ich zapisaniu.
 */
function EdytujPodstrone() {
    global $link;

    // Sprawdzanie, czy istnieje parametr 'id' w URL
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);  // Bezpieczne przetworzenie id na liczbę całkowitą

        // Przygotowanie zapytania do bazy danych
        $query = "SELECT * FROM page_list WHERE id = ? LIMIT 1";
        $stmt = mysqli_prepare($link, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);  // Bezpieczne wiązanie parametrów
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                // Formularz edycji podstrony
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

                // Obsługa formularza po wysłaniu
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Zabezpieczenie danych wejściowych przed XSS
                    $page_title = htmlspecialchars($_POST['page_title'], ENT_QUOTES, 'UTF-8');
                    $page_content = htmlspecialchars($_POST['page_content'], ENT_QUOTES, 'UTF-8');
                    $status = isset($_POST['status']) ? 1 : 0;

                    // Przygotowanie zapytania do aktualizacji danych w bazie
                    $update_query = "UPDATE page_list SET page_title = ?, page_content = ?, status = ? WHERE id = ? LIMIT 1";
                    $update_stmt = mysqli_prepare($link, $update_query);

                    if ($update_stmt) {
                        mysqli_stmt_bind_param($update_stmt, 'ssii', $page_title, $page_content, $status, $id);
                        if (mysqli_stmt_execute($update_stmt)) {
                            echo '<p style="color: green;">Podstrona została zaktualizowana.</p>';
                        } else {
                            echo '<p style="color: red;">Błąd przy aktualizacji podstrony.</p>';
                        }
                        mysqli_stmt_close($update_stmt);
                    }
                }
            } else {
                echo '<p>Nie znaleziono podstrony.</p>';
            }
            mysqli_stmt_close($stmt);
        }
    }
}

/*
 * Funkcja dodająca nową podstronę
 * Wyświetla formularz dodawania podstrony oraz zapisuje dane w bazie po ich wysłaniu.
 */
function DodajNowaPodstrone() {
    global $link;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Zabezpieczenie danych wejściowych przed XSS
        $page_title = htmlspecialchars($_POST['page_title'], ENT_QUOTES, 'UTF-8');
        $page_content = htmlspecialchars($_POST['page_content'], ENT_QUOTES, 'UTF-8');
        $status = isset($_POST['status']) ? 1 : 0;

        // Przygotowanie zapytania do dodania nowej podstrony
        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($link, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ssi', $page_title, $page_content, $status);
            if (mysqli_stmt_execute($stmt)) {
                echo '<p style="color: green;">Podstrona została dodana.</p>';
            } else {
                echo '<p style="color: red;">Błąd przy dodawaniu podstrony.</p>';
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Formularz dodawania nowej podstrony
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

/*
 * Funkcja usuwająca podstronę
 * Usuwa podstronę na podstawie przekazanego ID.
 */
function UsunPodstrone() {
    global $link;

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);  // Bezpieczne przetworzenie id na liczbę całkowitą

        // Przygotowanie zapytania do usunięcia podstrony
        $query = "DELETE FROM page_list WHERE id = ? LIMIT 1";
        $stmt = mysqli_prepare($link, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            if (mysqli_stmt_execute($stmt)) {
                echo '<p style="color: green;">Podstrona została usunięta.</p>';
            } else {
                echo '<p style="color: red;">Błąd przy usuwaniu podstrony.</p>';
            }
            mysqli_stmt_close($stmt);
        }
    }
}

/*
 * Funkcja wyświetlająca listę podstron
 * Pobiera dane z bazy i wyświetla je w tabeli.
 */
function ListaPodstron() {
    global $link;

    // Przygotowanie zapytania do pobrania podstron
    $query = "SELECT id, page_title, status FROM page_list LIMIT 10";
    $result = mysqli_query($link, $query);

    // Wyświetlenie tabeli z podstronami
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

/*
 * Główna logika obsługi akcji
 * Obsługuje różne akcje związane z podstronami (dodawanie, edytowanie, usuwanie).
 */
if (isset($_GET['akcja'])) {
    if ($_GET['akcja'] === 'dodaj') {
        DodajNowaPodstrone();
    } elseif ($_GET['akcja'] === 'edytuj') {
        EdytujPodstrone();
    } elseif ($_GET['akcja'] === 'usun') {
        UsunPodstrone();
    }
}

?>
