<?php
/*
 * Funkcja wyświetlająca zawartość podstrony
 */
function pokazPodstrone($id) {
    global $link; // Użycie globalnego połączenia z bazą danych

    // Sprawdzenie i walidacja ID
    $id_clear = filter_var($id, FILTER_VALIDATE_INT);
    if ($id_clear === false) {
        return '[nieprawidłowe_id]'; // Zwrócenie komunikatu dla nieprawidłowego ID
    }

    // Przygotowanie zapytania SQL (prepared statement)
    $query = "SELECT page_content FROM page_list WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($link, $query);

    if ($stmt) {
        // Przypisanie parametru do zapytania
        mysqli_stmt_bind_param($stmt, 'i', $id_clear);

        // Wykonanie zapytania
        mysqli_stmt_execute($stmt);

        // Pobranie wyniku zapytania
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        // Sprawdzenie, czy rekord został znaleziony
        if ($row) {
            return $row['page_content']; // Zwrócenie zawartości podstrony
        } else {
            return '[nie_znaleziono_strony]'; // Komunikat, jeśli nie ma podstrony o podanym ID
        }

        // Zamknięcie zapytania
        mysqli_stmt_close($stmt);
    } else {
        return '[błąd_zapytania]'; // Komunikat w przypadku błędu przygotowania zapytania
    }
}
?>