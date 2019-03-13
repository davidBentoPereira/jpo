<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 */
class Admin
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $uid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $encryptedPassword;

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function construct(string $mail, string $password){
        $this->uid = uniqid();
        $this->mail = $mail;
        $this->password = $password;
    }

    public function setUid(string $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    public function getEncryptedPassword(): ?string
    {
        return $this->encryptedPassword;
    }

    public function setEncryptedPassword(string $encryptedPassword): self
    {
        $this->encryptedPassword = $encryptedPassword;

        return $this;
    }
}
