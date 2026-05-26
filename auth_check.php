<?php
// Shared authentication gate for standalone helper scripts
// (converteps.php, convertpsd.php, emlconvert.php, msgconvert*.php).
// Mirrors the session configuration used by index.php (FM_SESSION_ID = 'filemanager').
//
// Two ways to pass the gate:
//   1) Logged-in filemanager session — $_SESSION['filemanager']['logged'] populated by index.php.
//   2) iframe embed from onpoint.pinpoint.promo — $_SESSION['iframe_my_host'] === 'onpoint',
//      set by index.php when the parent page referer matches. Keeps in-iframe previews
//      (EML / MSG / EPS / PSD) working without a separate login.

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
