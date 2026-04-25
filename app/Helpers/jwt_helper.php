<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Generate a JWT token.
 */
function generate_jwt($data, $secret, $expiry = 3600)
{
    $issuedAt = time();
    $payload = [
        'iat' => $issuedAt,
        'exp' => $issuedAt + $expiry,
        'data' => $data, // Expiration time
    ];

    return JWT::encode($payload, $secret, 'HS256');
}

/**
 * Validate and decode a JWT token.
 */
function validate_jwt($token, $secret)
{
    try {
        $token_data = JWT::decode($token, new Key($secret, 'HS256'));
        return (array) $token_data->data;
    } catch (Exception $e) {
        return null; // Return null if token is invalid
    }
}
