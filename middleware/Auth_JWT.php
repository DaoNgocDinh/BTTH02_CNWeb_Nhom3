<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Middleware {
    function checkJWT() {
        if (!isset($_COOKIE['token'])) {
            return false;
        }

        $token = $_COOKIE['token'];
        $secret = "d8edd050d5510dfcd2d5fab82a3284ead31de8fc4ab6aa38b70b964b35969346552b89e3d948e312996d1d30744b701a9679535308bdf838ff9dc535057ee98dfd8c7b782f21980687872c36ba98af84";

        try {
            $decoded = JWT::decode($token, new Key($secret, "HS256"));
            // Chỉ lưu thông tin user cần thiết vào session
            $_SESSION['user'] = [
                'id' => $decoded->id ?? null,
                'email' => $decoded->email ?? null,
                'username' => $decoded->username ?? null,
                'role' => $decoded->role ?? 0
            ];
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
