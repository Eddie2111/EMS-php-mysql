<?php

function base64UrlEncode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64UrlDecode($data)
{
    return base64_decode(strtr($data, '-_', '+/'));
}

function encodeJWT($payload, $secret)
{
    $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
    $headerBase64 = base64UrlEncode($header);

    $payloadBase64 = base64UrlEncode(json_encode($payload));

    $signature = hash_hmac('sha256', $headerBase64 . '.' . $payloadBase64, $secret, true);
    $signatureBase64 = base64UrlEncode($signature);

    return $headerBase64 . '.' . $payloadBase64 . '.' . $signatureBase64;
}

function decodeJWT($jwt, $secret)
{
    list($headerBase64, $payloadBase64, $signatureBase64) = explode('.', $jwt);

    $header = json_decode(base64UrlDecode($headerBase64), true);
    $payload = json_decode(base64UrlDecode($payloadBase64), true);

    $signature = base64UrlDecode($signatureBase64);

    $expectedSignature = hash_hmac('sha256', $headerBase64 . '.' . $payloadBase64, $secret, true);

    if ($signature !== $expectedSignature) {
        throw new Exception("Invalid JWT signature.");
    }

    return $payload;
}

?>