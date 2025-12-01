<?php
// Обробка форми після надсилання
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Отримуємо дані з форми
    $name   = trim($_POST["name"] ?? "");
    $email  = trim($_POST["email"] ?? "");
    $q1     = $_POST["q1"] ?? "";
    $q2     = $_POST["q2"] ?? "";
    $q3     = trim($_POST["q3"] ?? "");

    // Створюємо папку survey, якщо її ще немає
    $dir = __DIR__ . "/survey";
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    // Формуємо ім'я файлу з датою та часом
    date_default_timezone_set("Europe/Kyiv");
    $timestamp = date("Y-m-d_H-i-s"); // формат без двокрапок
    $fileName = $dir . "/survey_" . $timestamp . ".txt";

    // Формуємо вміст файлу
    $content  = "Час заповнення: " . date("Y-m-d H:i:s") . PHP_EOL;
    $content .= "Ім'я: " . $name . PHP_EOL;
    $content .= "Email: " . $email . PHP_EOL;
    $content .= "Питання 1: Улюблений альбом LP: " . $q1 . PHP_EOL;
    $content .= "Питання 2: Як часто слухаєте LP: " . $q2 . PHP_EOL;
    $content .= "Питання 3: Коментар: " . $q3 . PHP_EOL;

    // Запис у файл
    file_put_contents($fileName, $content);

    // Виведення підтвердження з датою і часом
    $submitted_at = date("d.m.Y H:i:s");
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Опитування про Linkin Park</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <div class="page-wrap">
        <h1>Linkin Park</h1>
        <nav>
            <ul>
                <li><a href="index.html">Головна</a></li>
                <li><a href="about.html">Про гурт</a></li>
                <li><a href="hybrid-theory.html">Hybrid Theory</a></li>
                <li><a href="meteora.html">Meteora</a></li>
                <li><a href="contacts.html">Контакти</a></li>
                <li><a href="survey.php" class="current">Опитування</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="page-wrap">
        <h2>Опитування: улюблений альбом Linkin Park</h2>

        <?php if (!empty($submitted_at)): ?>
            <section class="section-card">
                <h3>Дякуємо за відповідь!</h3>
                <p>Ваша форма успішно надіслана.</p>
                <p>Час та дата заповнення: <strong><?php echo htmlspecialchars($submitted_at); ?></strong></p>
            </section>
        <?php endif; ?>

        <section class="section-card">
            <h3>Анкета респондента</h3>
            <form method="POST" action="survey.php" class="contacts-grid">
                <div>
                    <label for="name">Ім’я респондента:</label><br>
                    <input type="text" id="name" name="name" required>
                </div>

                <div>
                    <label for="email">Email респондента:</label><br>
                    <input type="email" id="email" name="email" required>
                </div>

                <div>
                    <label for="q1">Улюблений альбом Linkin Park:</label><br>
                    <select id="q1" name="q1" required>
                        <option value="">Оберіть варіант</option>
                        <option value="Hybrid Theory">Hybrid Theory</option>
                        <option value="Meteora">Meteora</option>
                        <option value="Minutes to Midnight">Minutes to Midnight</option>
                        <option value="A Thousand Suns">A Thousand Suns</option>
                        <option value="Інший">Інший</option>
                    </select>
                </div>

                <div>
                    <label for="q2">Як часто ви слухаєте Linkin Park?</label><br>
                    <select id="q2" name="q2" required>
                        <option value="">Оберіть варіант</option>
                        <option value="Щодня">Щодня</option>
                        <option value="Кілька разів на тиждень">Кілька разів на тиждень</option>
                        <option value="Кілька разів на місяць">Кілька разів на місяць</option>
                        <option value="Рідко">Рідко</option>
                    </select>
                </div>

                <div>
                    <label for="q3">Ваш короткий відгук про гурт:</label><br>
                    <textarea id="q3" name="q3" rows="4" cols="40"
                              placeholder="Напишіть кілька слів..." ></textarea>
                </div>

                <div>
                    <button type="submit" class="contact-link">
                        <span>Надіслати відповідь</span>
                        <small>Метод POST, збереження у файл</small>
                    </button>
                </div>
            </form>
        </section>
    </div>
</main>

<footer>
    <div class="page-wrap">
        <p>2025 - Linkin Park</p>
    </div>
</footer>
</body>
</html>
