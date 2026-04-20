<?php

class UserModel
{
    private string $primaryStoragePath;
    private string $fallbackStoragePath;

    public function __construct()
    {
        $this->primaryStoragePath = __DIR__ . '/data/registered_user.json';
        $this->fallbackStoragePath = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'wt_lab_registered_users.json';
    }

    public function saveUser(string $username, string $email, string $passwordHash): void
    {
        $payload = $this->readUsers();

        $normalizedEmail = strtolower(trim($email));
        $user = [
            'username' => $username,
            'email' => trim($email),
            'password_hash' => $passwordHash
        ];

        $updated = false;
        foreach ($payload as $index => $existingUser) {
            if (strtolower(trim($existingUser['email'] ?? '')) === $normalizedEmail) {
                $payload[$index] = $user;
                $updated = true;
                break;
            }
        }

        if (!$updated) {
            $payload[] = $user;
        }

        $encoded = json_encode($payload, JSON_PRETTY_PRINT);
        if ($encoded === false) {
            return;
        }

        // Persist to both primary and fallback paths to avoid environment-specific write issues.
        $this->writeUsersToPath($this->primaryStoragePath, $encoded);
        $this->writeUsersToPath($this->fallbackStoragePath, $encoded);
        $this->clearLegacyUserCookie();
    }

    public function getUserByEmail(string $email): ?array
    {
        $normalizedEmail = strtolower(trim($email));
        $users = $this->readUsers();

        foreach ($users as $user) {
            if (strtolower(trim($user['email'] ?? '')) === $normalizedEmail) {
                return $user;
            }
        }

        return null;
    }

    private function readUsers(): array
    {
        $usersByEmail = [];
        $paths = [$this->primaryStoragePath, $this->fallbackStoragePath];
        usort($paths, function (string $a, string $b): int {
            $aTime = file_exists($a) ? (int) filemtime($a) : 0;
            $bTime = file_exists($b) ? (int) filemtime($b) : 0;
            return $aTime <=> $bTime;
        });

        foreach ($paths as $path) {
            foreach ($this->readUsersFromPath($path) as $user) {
                $emailKey = strtolower(trim($user['email']));
                $usersByEmail[$emailKey] = $user;
            }
        }

        return array_values($usersByEmail);
    }

    private function clearLegacyUserCookie(): void
    {
        // Remove old insecure cookie if it exists from previous versions.
        if (isset($_COOKIE['wt_lab_registered_users'])) {
            setcookie('wt_lab_registered_users', '', time() - 3600, '/');
            unset($_COOKIE['wt_lab_registered_users']);
        }
    }

    private function writeUsersToPath(string $path, string $encodedUsers): void
    {
        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($path, $encodedUsers);
    }

    private function readUsersFromPath(string $path): array
    {
        if (!file_exists($path)) {
            return [];
        }

        $contents = file_get_contents($path);
        if ($contents === false) {
            return [];
        }

        $decoded = json_decode($contents, true);
        if (!is_array($decoded)) {
            return [];
        }

        // Backward compatibility: single object format.
        if (isset($decoded['username'], $decoded['email'], $decoded['password_hash'])) {
            $decoded = [$decoded];
        }

        $users = [];
        foreach ($decoded as $item) {
            if (!is_array($item)) {
                continue;
            }

            if (empty($item['username']) || empty($item['email']) || empty($item['password_hash'])) {
                continue;
            }

            $users[] = [
                'username' => (string) $item['username'],
                'email' => (string) $item['email'],
                'password_hash' => (string) $item['password_hash']
            ];
        }

        return $users;
    }
}
