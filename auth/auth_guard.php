<?php
// ─────────────────────────────────────────────
// auth/auth_guard.php
// Include at the top of any protected page.
// Redirects to login if no PHP session exists.
// ─────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['uid'])) {
    // Preserve the requested page so we can redirect back after login
    $redirect = urlencode($_SERVER['REQUEST_URI'] ?? '/');
    header('Location: /auth/login.php?redirect=' . $redirect);
    exit;
}
