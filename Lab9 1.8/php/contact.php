<?php

/*
 * Funkcja wyświetlająca formularz kontaktowy
 */
function PokazKontakt() {
    // Wyświetlanie formularza HTML do wysyłania wiadomości
    echo '<form method="POST" action="" style="max-width: 500px; margin: auto;">
            <h2>Formularz kontaktowy</h2>
            <div style="margin-bottom: 15px;">
                <label for="temat" style="display: block; font-weight: bold;">Temat:</label>
                <input type="text" name="temat" id="temat" required 
                       style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label for="tresc" style="display: block; font-weight: bold;">Treść wiadomości:</label>
                <textarea name="tresc" id="tresc" rows="6" required
                          style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;"></textarea>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; font-weight: bold;">Twój e-mail:</label>
                <input type="email" name="email" id="email" required 
                       style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Wyślij wiadomość
            </button>
          </form>';
}

/*
 * Funkcja wysyłająca e-mail
 */
function WyslijMailKontakt($odbiorca, $temat, $wiadomosc, $nadawca) {
    // Ustawienie nagłówków e-maila
    $header = "From: Formularz kontaktowy <" . htmlspecialchars($nadawca, ENT_QUOTES, 'UTF-8') . ">\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";
    $header .= "X-Sender: " . htmlspecialchars($nadawca, ENT_QUOTES, 'UTF-8') . "\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\n";
    $header .= "X-Priority: 3\n";
    $header .= "Return-Path: " . htmlspecialchars($nadawca, ENT_QUOTES, 'UTF-8') . "\n";

    // Próba wysłania e-maila i informacja o powodzeniu
    if (mail($odbiorca, htmlspecialchars($temat, ENT_QUOTES, 'UTF-8'), htmlspecialchars($wiadomosc, ENT_QUOTES, 'UTF-8'), $header)) {
        echo '<p style="color: green;">Wiadomość została wysłana.</p>';
    } else {
        echo '<p style="color: red;">Błąd podczas wysyłania wiadomości.</p>';
    }
}

/*
 * Funkcja do przypomnienia hasła
 */
function PrzypomnijHaslo($email, $nowe_haslo) {
    // Przygotowanie tematu i treści wiadomości z przypomnieniem hasła
    $temat = 'Przypomnienie hasła';
    $wiadomosc = "Twoje nowe hasło do panelu admina to: " . htmlspecialchars($nowe_haslo, ENT_QUOTES, 'UTF-8');
    $nadawca = 'no-reply@mojastrona.pl';

    // Wywołanie funkcji do wysyłania e-maila
    WyslijMailKontakt($email, $temat, $wiadomosc, $nadawca);
}

/*
 * Obsługa formularza kontaktowego
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filtrowanie i walidacja danych wejściowych z formularza
    $temat = filter_input(INPUT_POST, 'temat', FILTER_SANITIZE_STRING);
    $tresc = filter_input(INPUT_POST, 'tresc', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($temat && $tresc && $email) {
        $odbiorca = 'admin@mojastrona.pl'; // Adres e-mail odbiorcy wiadomości

        // Wywołanie funkcji do wysyłania wiadomości
        WyslijMailKontakt($odbiorca, $temat, $tresc, $email);
    } else {
        // Informacja o brakujących danych w formularzu lub błędnych danych
        echo '<p style="color: red;">Nie wypełniłeś wszystkich pól poprawnie.</p>';
        PokazKontakt();
    }
} 
?>
