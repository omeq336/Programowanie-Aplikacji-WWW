/*
 * Funkcja gettheDate()
 * Pobiera bieżącą datę, przetwarza ją i wyświetla w elemencie HTML o id "data".
 * Format daty: MM / DD / YY
 */
function gettheDate() {
    const Todays = new Date(); // Tworzenie nowego obiektu Date
    const TheDate = `${Todays.getMonth() + 1} / ${Todays.getDate()} / ${Todays.getFullYear() - 2000}`; 
    document.getElementById("data").innerHTML = TheDate; // Ustawianie wyświetlanej daty
}

/*
 * Funkcja stopclock()
 * Zatrzymuje działający zegar, jeśli jest uruchomiony.
 */
let timerId = null;
let timerRunning = false;

function stopclock() {
    if (timerRunning) {
        clearTimeout(timerId); // Zatrzymywanie zegara
    }
    timerRunning = false; // Zmienna pomocnicza oznaczająca, że zegar nie działa
}

/*
 * Funkcja startclock()
 * Uruchamia zegar, zatrzymując go wcześniej, jeśli jest już uruchomiony.
 */
function startclock() {
    stopclock(); // Zatrzymywanie poprzedniego zegara, jeśli jest uruchomiony
    gettheDate(); // Pobieranie bieżącej daty
    showtime(); // Rozpoczynanie wyświetlania godziny
}

/*
 * Funkcja showtime()
 * Wyświetla aktualny czas w formacie 12-godzinnym z oznaczeniem AM/PM.
 * Zegar jest odświeżany co sekundę.
 */
function showtime() {
    const now = new Date(); // Tworzenie nowego obiektu Date
    let hours = now.getHours(); // Pobranie godzin w formacie 24-godzinnym
    const minutes = now.getMinutes(); // Pobranie minut
    const seconds = now.getSeconds(); // Pobranie sekund

    let timeValue = (hours > 12 ? hours - 12 : hours); // Przekształcenie godzin na 12-godzinny format
    timeValue += (minutes < 10 ? ":0" : ":") + minutes; // Dodanie minut do godziny
    timeValue += (seconds < 10 ? ":0" : ":") + seconds; // Dodanie sekund do godziny

    // Określenie, czy jest to godzina przed południem (AM) czy po południu (PM)
    timeValue += (hours >= 12) ? " P.M." : " A.M.";

    document.getElementById("zegarek").innerHTML = timeValue; // Wyświetlanie godziny na stronie

    // Ustawienie ponownego wywołania funkcji showtime() co sekundę
    timerId = setTimeout(showtime, 1000);
    timerRunning = true; // Ustawienie zmiennej wskazującej, że zegar jest uruchomiony
}
