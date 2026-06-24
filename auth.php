<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isIngelogd()
{
    return isset($_SESSION['gebruiker_id']);
}

function verplichtInloggen()
{
    if (!isIngelogd()) {
        header('Location: login.php');
        exit;
    }
}

