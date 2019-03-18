<?php

namespace App\Service;

class EncryptingService
{
    private $encryptedString;

    private $algo = 'md5';

    public function __construct(string $stringToEncrypt)
    {
        $this->encryptedString = hash($this->algo, $stringToEncrypt);
    }

    public function getEncryptedString(): string
    {
        return $this->encryptedString;
    }
}