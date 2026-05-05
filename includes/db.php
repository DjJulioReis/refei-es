<?php
if (!file_exists(__DIR__ . '/config.php')) {
    // Determine the correct path to setup.php
    $is_admin = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;
    $prefix = $is_admin ? '../' : '';
    header('Location: ' . $prefix . 'setup.php');
    exit;
}
require_once __DIR__ . '/config.php';
