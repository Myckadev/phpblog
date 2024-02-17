<?php

namespace App\Service;

class SessionService
{
    // Démarrer la session ou s'assurer qu'elle est déjà démarrée
    public function ensureStarted(): void
    {
        if (session_status() === PHP_SESSION_NONE) {

            //Configuration les paramètres de sécurité des cookies de session
            session_set_cookie_params([
               'lifetime' => 3600,
                'path' => '/',
                'domain' => '', // Spécifiez votre domaine si nécessaire
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict',
            ]);

            session_start();
        }
    }

    // Obtenir une valeur de la session
    public function getSession($key, $default = null)
    {
        $this->ensureStarted();
        return $_SESSION[$key] ?? $default;
    }

    // Vérifier si une clé de session existe
    public function hasSession($key): bool
    {
        $this->ensureStarted();
        return isset($_SESSION[$key]);
    }

    // Créer ou écraser une valeur de session
    public function createSession($key, $value): void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    // Supprimer une valeur de session
    public function deleteSession($key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }

    // Détruire complètement la session
    public function destroySession(): void
    {
        // Supprime le cookie de session
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

        // Supprimer toutes les données de session
        $_SESSION = [];

        //S'assure de valider toute les modifications apporté à la session
        session_write_close();
        // Finalement, détruit la session
        session_destroy();
    }

    public function generateCsrfToken(): string
    {
        $this->ensureStarted();
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;

        return $token;
    }

    public function getCsrfToken()
    {
        $this->ensureStarted();

        return $this->getSession('csrf_token');
    }

    public function isCsrfTokenValid(string $token): bool
    {
        return $token === $this->getCsrfToken();
    }

    public function isAuthenticated(): bool
    {
        return !!$this->getSession('userId');
    }

}