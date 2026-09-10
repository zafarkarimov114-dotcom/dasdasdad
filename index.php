<?php
// Numele fișierului în care se vor salva sarcinile
$fisier_text = "textul trecut.txt";
$mesaj_status = "";

// Verificăm dacă formularul a fost trimis prin metoda POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preluăm sarcina din formular
    $mesaj = trim($_POST['mesaj'] ?? '');

    if (!empty($mesaj)) {
        // Formatăm linia care va fi adăugată în fișier
        $linie_noua = "Data: " . date("Y-m-d H:i:s") . " | Sarcina: " . $mesaj . PHP_EOL;

        // Salvăm sarcina în fișier
        file_put_contents($fisier_text, $linie_noua, FILE_APPEND | LOCK_EX);

        $mesaj_status = "<p style='color: green; margin-bottom: 15px;'>Sarcina a fost salvată cu succes!</p>";
    } else {
        $mesaj_status = "<p style='color: red; margin-bottom: 15px;'>Te rugăm să introduci o sarcină.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager de Sarcini</title>
    <style>
        :root {
            --bg-color: #f4f6f9;
            --card-bg: #ffffff;
            --primary: #4a6da7;
            --text: #333333;
            --border: #e0e0e0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background: var(--card-bg);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        header h1 {
            margin: 0 0 10px 0;
            color: var(--primary);
        }

        header p {
            margin: 0 0 25px 0;
            color: #666;
        }

        .task-form {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .task-form input[type="text"] {
            flex: 1;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
        }

        .task-form button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
        }

        .task-form button:hover {
            background-color: #3b5987;
        }

        .saved-tasks {
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid var(--border);
            border-radius: 6px;
            white-space: pre-wrap;
            font-family: monospace;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1>Manager de Sarcini</h1>
            <p>Organizează-ți activitățile zilnice simplu și eficient.</p>
        </header>

        <!-- Afișarea mesajului de confirmare/eroare -->
        <?php echo $mesaj_status; ?>

        <!-- Formularul conectat la PHP -->
        <form class="task-form" action="" method="POST">
            <input type="text" name="mesaj" placeholder="Adaugă o sarcină nouă..." required>
            <button type="submit">Adaugă</button>
        </form>

        <section>
            <h2>Sarcini salvate în fișier</h2>
            <div class="saved-tasks"><?php 
                if (file_exists($fisier_text)) {
                    echo htmlspecialchars(file_get_contents($fisier_text));
                } else {
                    echo "Nu există sarcini salvate încă.";
                }
            ?></div>
        </section>
    </div>

</body>
</html>





