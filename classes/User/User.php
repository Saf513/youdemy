<?php

// creation de classe de user 

  abstract class User
{

    protected int $id;
    protected string $nom;
    protected string $email;
    protected string $password;
    protected string $role;
    protected bool $isActive;
    protected $createdAt;
    protected $updatedAt;
    protected ?string $photoUrl = null;


    public function __construct($id = null, $nom = null, $email = null, $password = null, $role = null, $isActive = true, $createdAt = null, $updatedAt = null)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->isActive = $isActive;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    //les getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }

    // les setters

    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    public function setRole(string $role)
    {
        $this->role = $role;
    }
    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;
    }

    public function setPhotoUrl(?string $photoUrl): void
    {
        $this->photoUrl = $photoUrl;
    }


    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'username'  => $this->nom,
            'email'     => $this->email,
            'password'  => $this->password,
            'role'      => $this->role,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s'),
            'is_active' => $this->isActive,
            'photoUrl' => $this->photoUrl,

        ];
    }
    public function loadData(array $data): void
    {
       $this->id = (int) $data['id'];
       $this->nom = $data['full_name'];
        $this->email = $data['email'];
       $this->password = $data['password'];
      $this->role = $data['role'];
      $this->isActive = $data['status'] === 'active';
      $this->createdAt = new DateTime($data['created_at']);
     $this->updatedAt = $data['updated_at'] ? new DateTime($data['updated_at']) : null;
     $this->photoUrl = $data['photoUrl'] ?? null;
  }

    // abstract public function login(): bool;
    // abstract public function logout(): void;
    abstract public function updateProfile(array $data, array $photoFile = null): bool;
    abstract public function save(): bool;
}
