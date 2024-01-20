<?php

namespace App\Service;

class SessionService
{
    // Démarrer la session ou s'assurer qu'elle est déjà démarrée
    public function ensureStarted(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
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
        if (session_status() === PHP_SESSION_ACTIVE) {
            // Supprimer toutes les données de session
            $_SESSION = [];

            // Supprimer le cookie de session
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            // Finalement, détruire la session
            session_destroy();
        }
    }
}