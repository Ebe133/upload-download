<?php
include 'db.php';
include 'auth.php';

verplichtInloggen();

$id = $_GET['id'] ?? '';

if (!preg_match('/^[a-f0-9]{32}$/', $id)) {
    die('Ongeldig bestand.');
}
 // zegt dat het bestand moet worden opgehaald 
$stmt = $conn->prepare(
    'SELECT naam, type, data FROM bestanden WHERE public_id = ?'
);
//zegt dat hij het moet uitvoeren
$stmt->bind_param('s', $id);
$stmt->execute();
$stmt->bind_result($naam, $type, $data);

if (!$stmt->fetch()) {
    die('Bestand niet gevonden.');
}

header('Content-Type: ' . $type);
header('Content-Disposition: attachment; filename="' . basename($naam) . '"');

echo $data;
exit;
