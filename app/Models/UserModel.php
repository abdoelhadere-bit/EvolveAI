<?php

namespace App\Models;

class UserModel
{
    private ?int $id= null;
    private ?string $full_name =null;
    private ?string $email = null;
    private ?string $password_hash = null;
    private ?string $password_confirm= null;
    private ?string $created_at = null;

    public function __construct(?int $id= null,
    ?string $full_name =null,
    ?string $email = null,
    ?string $password_hash = null,
    ?string $created_at = null,
    ?string $password_confirm = null)
    {
        $this->id= $id;
        $this->full_name = $full_name;
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->created_at = $created_at;
        $this->password_confirm = $password_confirm;
    }

    public function getId(): ?int { return $this->id; }
    public function getFname(): ?string { return $this->full_name; }
    public function getEmail(): ?string { return $this->email; }
    public function getPassword(): ?string { return $this->password_hash; }
    public function getConfirmPassword(): ?string { return $this->password_confirm; }
    public function getCreatedAt(): ?string  { return $this->created_at; }

    public function setId(?int $id) { $this->id= $id; }
    public function setFname(?string $fname) { $this->full_name= $fname; }
    public function setEmail(?string $email) { $this->email= $email; }
    public function setPassword(?string $password) { $this->password_hash= $password; }
    public function setConfirmPassword(?string $confirm_password) { $this->password_confirm = $confirm_password; }
    public function setCreatedAt(?string $created_at) { $this->created_at = $created_at; }
}