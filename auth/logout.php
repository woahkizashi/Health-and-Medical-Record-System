<?php
// auth/logout.php

// 1) Load config (so session_start() runs)
require_once __DIR__ . '/../includes/config.php';

// 2) Clear session and cookie
session_unset();
session_destroy();
if (ini_get('session.use_cookies')) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// 3) Absolute redirect—no constants
header('Location: /health-record-system/auth/login.php', true, 302);
exit;
