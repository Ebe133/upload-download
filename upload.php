<?php
include 'db.php';

if (!isset($_POST["submit"])) {
    header("Location: index.php");
    exit;
}

if (!isset($_FILES["fileToUpload"]) || $_FILES["fileToUpload"]["error"] !== UPLOAD_ERR_OK) {
    die("Geen bestand gekozen of upload mislukt.");
}

$bestand_data = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
$bestandsnaam = $_FILES["fileToUpload"]["name"];
$bestandsgrootte = $_FILES["fileToUpload"]["size"];
$bestandstype = $_FILES["fileToUpload"]["type"];

$public_id = bin2hex(random_bytes(16));

$stmt = $conn->prepare("INSERT INTO bestanden (public_id, naam, type, grootte, data, upload_datum) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sssis", $public_id, $bestandsnaam, $bestandstype, $bestandsgrootte, $bestand_data);

if (!$stmt->execute()) {
    die("Fout: " . $conn->error);
}

$stmt->close();

header("Location: index.php");
exit;
