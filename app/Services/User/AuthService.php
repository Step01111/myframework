<?php
namespace App\Services\User;

class AuthService
{
    public static function createToken(User $user)
    {
        $token = $user->getId().':'.$user->getAuthToken();
        setcookie('token', $token, time() + 800000, '/', '', false, true);
    }

    public static function getUserByToken(): ?User
    {
        $token = $_COOKIE['token'] ?? '';

        if (!$token)
        return null;

        [$user_id, $auth_token] = explode(':', $token, 2);

        $user = User::getById((int) $user_id);

        if (!$user)
        return null;
        if ($user->getAuthToken() != $auth_token)
        return null;
        
        return $user;
    }

    public static function deleteToken()
    {
        setcookie('token', '', 3600, '/', '', false, true);
    }
}
