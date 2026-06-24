<?php
include 'db.php';
include 'auth.php';

if (isIngelogd()) {
    header('Location: index.php');
    exit;
}

$fout = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikersnaam = trim($_POST['gebruikersnaam'] ?? '');
    $wachtwoord = $_POST['wachtwoord'] ?? '';
    $wachtwoordHerhalen = $_POST['wachtwoord_herhalen'] ?? '';

    if (strlen($gebruikersnaam) < 3 || strlen($gebruikersnaam) > 50) {
        $fout = 'De gebruikersnaam moet tussen 3 en 50 tekens lang zijn.';
    } elseif (strlen($wachtwoord) < 6) {
        $fout = 'Het wachtwoord moet minimaal 6 tekens lang zijn.';
    } elseif ($wachtwoord !== $wachtwoordHerhalen) {
        $fout = 'De wachtwoorden zijn niet hetzelfde.';
    } else {
        $controle = $conn->prepare('SELECT id FROM gebruikers WHERE gebruikersnaam = ?');
        $controle->bind_param('s', $gebruikersnaam);
        $controle->execute();

        if ($controle->get_result()->num_rows > 0) {
            $fout = 'Deze gebruikersnaam bestaat al.';
        } else {
            $wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO gebruikers (gebruikersnaam, wachtwoord) VALUES (?, ?)');
            $stmt->bind_param('ss', $gebruikersnaam, $wachtwoordHash);

            if ($stmt->execute()) {
                header('Location: login.php');
                exit;
            }

            $fout = 'Registreren is mislukt. Probeer het opnieuw.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
</head>
<body>
    <h2>Account registreren</h2>

    <?php if ($fout): ?>
        <p><?php echo htmlspecialchars($fout); ?></p>
    <?php endif; ?>

    <form method="post">
        <p>
            <label for="gebruikersnaam">Gebruikersnaam:</label><br>
            <input
                type="text"
                name="gebruikersnaam"
                id="gebruikersnaam"
                minlength="3"
                maxlength="50"
                value="<?php echo htmlspecialchars($_POST['gebruikersnaam'] ?? ''); ?>"
                required
            >
        </p>
        <p>
            <label for="wachtwoord">Wachtwoord:</label><br>
            <input type="password" name="wachtwoord" id="wachtwoord" minlength="6" required>
        </p>
        <p>
            <label for="wachtwoord_herhalen">Wachtwoord herhalen:</label><br>
            <input type="password" name="wachtwoord_herhalen" id="wachtwoord_herhalen" minlength="6" required>
        </p>
        <button type="submit">Registreren</button>
    </form>

    <p>Al een account? <a href="login.php">Log hier in</a>.</p>
</body>
</html>

