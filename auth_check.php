<?php
// Shared authentication gate for standalone helper scripts
// (converteps.php, convertpsd.php, emlconvert.php, msgconvert*.php).
// Mirrors the session configuration used by index.php (FM_SESSION_ID = 'filemanager').

if (session_status() === PHP_SESSION_NONE) {
    session_name('filemanager');
    session_start();
}

$fm_logged = !empty($_SESSION['filemanager']['logged']);
$fm_iframe = isset($_SESSION['iframe_my_host']) && $_SESSION['iframe_my_host'] === 'onpoint';

if (!$fm_logged && !$fm_iframe) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Access denied. Authentication required.';
    exit;
}
