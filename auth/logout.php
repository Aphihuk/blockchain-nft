<?php
// ─────────────────────────────────────────────
// auth/logout.php
// Destroys session and redirects to login
// ─────────────────────────────────────────────
session_start();
session_destroy();
header('Location: /auth/login.php?msg=logged_out');
exit;
