<?php

namespace Stageo\Lib\Security;

class Crypto
{
    const METHOD = "AES-256-CBC";
    private static string $key;

    private function setKey(): void
    {
        self::$key = $_ENV["ENCRYPTION_KEY"];
    }

    /**
     * Encrypt the given data string in a URL-safe encoding using {@link encode()}. The result can be decoded by
     * calling {@link decrypt()}.
     *
     * @param string $data The data string to encrypt. Use {@link json_encode()} to encode arrays and objects.
     * @return string The encrypted data string.
     */
    public static function encrypt(mixed $data): string
    {
        (new Crypto)->setKey();
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::METHOD));
        $encryptedJson = openssl_encrypt(
            data: json_encode($data),
            cipher_algo: self::METHOD,
            passphrase: self::$key,
            iv: $iv
        );
        return self::encode("{$iv}{$encryptedJson}");
    }

    /**
     * Decrypt the given URL-safe base64 encoded data string.
     *
     * @param string $encodedData Encoded data string which is expected to have been previously encoded
     * using {@link encode()}
     * @return mixed The original data or false if the data cannot be decoded.
     */
    public static function decrypt(string $encodedData): mixed
    {
        (new Crypto)->setKey();
        $encryptedData = self::decode($encodedData);
        $ivLength = openssl_cipher_iv_length(self::METHOD);
        $encryptedJson = substr($encryptedData, $ivLength);
        $jsonData = openssl_decrypt(
            data: $encryptedJson,
            cipher_algo: self::METHOD,
            passphrase: self::$key,
            iv: substr($encryptedData, 0, $ivLength)
        );
        return json_decode(
            json: $jsonData,
            associative: true
        );
    }

    /**
     * Encode the given data string in a URL-safe string by with base64 encoding and replacing URL-unsafe characters
     * with their URL-safe counterparts. The result can be decoded by calling {@link decode()}.
     *
     * @param string $data The data string to encode. Use {@link json_encode()} to encode arrays and objects.
     * @return string The encoded data string.
     */
    public static function encode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Decode the given URL-safe base64 encoded data string.
     *
     * @param string $data Data string is expected to have been encoded
     * using {@link encode()}
     * @return string|false The original data or false if the data cannot be decoded.
     */
    public static function decode(string $data): string|false
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}