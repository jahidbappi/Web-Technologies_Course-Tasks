<?php

class AuthController
{
    private ValidationModel $validationModel;
    private UserModel $userModel;

    public function __construct()
    {
        $this->validationModel = new ValidationModel();
        $this->userModel = new UserModel();
    }

    public function showRegister(string $theme): void
    {
        $errors = [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => ''
        ];
        $old = [
            'username' => '',
            'email' => ''
        ];
        include __DIR__ . '/../views/register.php';
    }

    public function register(string $theme): void
    {
        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? ''
        ];

        $errors = $this->validationModel->validateRegistration($data);

        if ($this->hasErrors($errors)) {
            $old = [
                'username' => $data['username'],
                'email' => $data['email']
            ];
            include __DIR__ . '/../views/register.php';
            return;
        }

        $this->userModel->saveUser(
            $data['username'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        );

        $_SESSION['user'] = $data['username'];
        $_SESSION['login_time'] = date('d M Y, h:i:s A');

        header('Location: index.php?action=dashboard');
        exit;
    }

    public function showLogin(string $theme): void
    {
        $errors = [
            'email' => '',
            'password' => '',
            'general' => ''
        ];
        $old = [
            'email' => ''
        ];
        include __DIR__ . '/../views/login.php';
    }

    public function login(string $theme): void
    {
        $data = [
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? ''
        ];

        $errors = $this->validationModel->validateLogin($data);

        if ($this->hasErrors($errors)) {
            $old = ['email' => $data['email']];
            include __DIR__ . '/../views/login.php';
            return;
        }

        $registeredUser = $this->userModel->getUserByEmail($data['email']);

        if (!$registeredUser) {
            $errors['general'] = 'No registered user found. Please register first.';
            $old = ['email' => $data['email']];
            include __DIR__ . '/../views/login.php';
            return;
        }

        $isValidPassword = password_verify($data['password'], $registeredUser['password_hash']);

        if (!$isValidPassword) {
            $errors['general'] = 'Invalid email or password.';
            $old = ['email' => $data['email']];
            include __DIR__ . '/../views/login.php';
            return;
        }

        $_SESSION['user'] = $registeredUser['username'];
        $_SESSION['login_time'] = date('d M Y, h:i:s A');

        header('Location: index.php?action=dashboard');
        exit;
    }

    public function dashboard(string $theme): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $username = $_SESSION['user'];
        $loginTime = $_SESSION['login_time'] ?? 'Unknown';

        include __DIR__ . '/../views/dashboard.php';
    }

    public function logout(): void
    {
        unset($_SESSION['user'], $_SESSION['login_time']);

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: index.php?action=login');
        exit;
    }

    private function hasErrors(array $errors): bool
    {
        foreach ($errors as $error) {
            if (!empty($error)) {
                return true;
            }
        }
        return false;
    }
}
