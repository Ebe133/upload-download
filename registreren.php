<?php
include 'db.php';
include 'auth.php';

if (isIngelogd()) {
    header('Location: index.php');
    exit;
}

$fout = '';

if (isset($_POST['registreren'])) {
    $gebruikersnaam = trim($_POST['gebruikersnaam']);
    $wachtwoord = $_POST['wachtwoord'];

    if (empty($gebruikersnaam) || empty($wachtwoord)) {
        $fout = 'Vul alle velden in.';
    } else {
        $wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            'INSERT IGNORE INTO gebruikers (gebruikersnaam, wachtwoord) VALUES (?, ?)'
        );
        $stmt->bind_param('ss', $gebruikersnaam, $wachtwoord);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            header('Location: login.php');
            exit;
        }

        $fout = 'Deze gebruikersnaam bestaat al.';
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
            <input type="text" name="gebruikersnaam" id="gebruikersnaam" required>
        </p>
        <p>
            <label for="wachtwoord">Wachtwoord:</label><br>
            <input type="password" name="wachtwoord" id="wachtwoord" required>
        </p>
        <button type="submit" name="registreren">Registreren</button>
    </form>

    <p>Al een account? <a href="login.php">Log hier in</a>.</p>
</body>
</html>
