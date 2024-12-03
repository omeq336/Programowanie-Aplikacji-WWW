<?php

// Funkcja wyświetlająca formularz kontaktowy
function PokazKontakt() {
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

// Funkcja wysyłająca e-mail
function WyslijMailKontakt($odbiorca, $temat, $wiadomosc, $nadawca) {
    $header = "From: Formularz kontaktowy <" . $nadawca . ">\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";
    $header .= "X-Sender: " . $nadawca . "\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\n";
    $header .= "X-Priority: 3\n";
    $header .= "Return-Path: " . $nadawca . "\n";

    if (mail($odbiorca, $temat, $wiadomosc, $header)) {
        echo '<p style="color: green;">Wiadomość została wysłana.</p>';
    } else {
        echo '<p style="color: red;">Błąd podczas wysyłania wiadomości.</p>';
    }
}

// Funkcja do przypomnienia hasła
function PrzypomnijHaslo($email, $nowe_haslo) {
    $temat = 'Przypomnienie hasła';
    $wiadomosc = "Twoje nowe hasło do panelu admina to: $nowe_haslo";
    $nadawca = 'no-reply@mojastrona.pl';

    WyslijMailKontakt($email, $temat, $wiadomosc, $nadawca);
}

// Obsługa formularza kontaktowego
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['temat']) && !empty($_POST['tresc']) && !empty($_POST['email'])) {
        $odbiorca = 'admin@mojastrona.pl';
        WyslijMailKontakt($odbiorca, $_POST['temat'], $_POST['tresc'], $_POST['email']);
    } else {
        echo '<p style="color: red;">Nie wypełniłeś wszystkich pól.</p>';
        PokazKontakt();
    }
} else {
    PokazKontakt();
}
?>
