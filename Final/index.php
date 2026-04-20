<?php
if (!ini_get('date.timezone')) {
    date_default_timezone_set('Asia/Dhaka');
}

session_start();

$action = $_GET['action'] ?? 'register';

require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/PreferenceController.php';
require_once __DIR__ . '/models/ValidationModel.php';
require_once __DIR__ . '/models/UserModel.php';

$authController = new AuthController();
$preferenceController = new PreferenceController();

$theme = $preferenceController->getTheme();

switch ($action) {
    case 'register':
        $authController->showRegister($theme);
        break;
    case 'register_submit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register($theme);
        } else {
            header('Location: index.php?action=register');
            exit;
        }
        break;
    case 'login':
        $authController->showLogin($theme);
        break;
    case 'login_submit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login($theme);
        } else {
            header('Location: index.php?action=login');
            exit;
        }
        break;
    case 'dashboard':
        $authController->dashboard($theme);
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'settings':
        $preferenceController->showSettings($theme);
        break;
    case 'save_settings':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $preferenceController->saveSettings();
        } else {
            header('Location: index.php?action=settings');
            exit;
        }
        break;
    default:
        header('Location: index.php?action=register');
        exit;
}
