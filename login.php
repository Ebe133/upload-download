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

    $stmt = $conn->prepare('SELECT id, gebruikersnaam, wachtwoord FROM gebruikers WHERE gebruikersnaam = ?');
    $stmt->bind_param('s', $gebruikersnaam);
    $stmt->execute();
    $resultaat = $stmt->get_result();
    $gebruiker = $resultaat->fetch_assoc();

    if ($gebruiker && password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
        session_regenerate_id(true);
        $_SESSION['gebruiker_id'] = $gebruiker['id'];
        $_SESSION['gebruikersnaam'] = $gebruiker['gebruikersnaam'];

        header('Location: index.php');
        exit;
    }

    $fout = 'Gebruikersnaam of wachtwoord is onjuist.';
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
</head>
<body>
    <h2>Inloggen</h2>

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
        <button type="submit">Inloggen</button>
    </form>

    <p>Nog geen account? <a href="registreren.php">Registreer hier</a>.</p>
</body>
</html>

