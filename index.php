<?php
include 'db.php';
include 'auth.php';

verplichtInloggen();

$bestanden = $conn->query("SELECT public_id, naam, grootte, upload_datum FROM bestanden ORDER BY upload_datum DESC");
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestanden uploaden en downloaden</title>
</head>
<body>
    <p>
        Ingelogd als <strong><?php echo htmlspecialchars($_SESSION['gebruikersnaam']); ?></strong>
        | <a href="uitloggen.php">Uitloggen</a>
    </p>

    <h2>Bestand uploaden</h2>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Selecteer een bestand:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" required>
        <input type="submit" value="Upload bestand" name="submit">
    </form>

    <h2>Bestanden downloaden</h2>

    <?php if ($bestanden && $bestanden->num_rows > 0): ?>
        <ul>
            <?php while ($bestand = $bestanden->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($bestand["naam"]); ?>
                    (<?php echo round($bestand["grootte"] / 1024, 2); ?> KB)
                    <a href="download.php?id=<?php echo htmlspecialchars($bestand["public_id"]); ?>">Download</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Er zijn nog geen bestanden geupload.</p>
    <?php endif; ?>
</body>
</html>
