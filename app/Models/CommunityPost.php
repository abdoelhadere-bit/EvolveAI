<?php

namespace App\Models;

use DateTime;

class CommunityPost {
    private ?int $id = null;
    private int $userId;
    private string $title;
    private string $content;
    private string $postType;
    private DateTime $createdAt; 

    // Related data
    private ?UserModel $author = null;
    private array $comments = [];
    private bool $isLikedByCurrentUser = false;
    
    public function __construct(
        int $userId,
        string $title,
        string $content,
        string $postType = 'experience',
        ?string $createdAt = null // Optional date string
    ) {
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
        $this->postType = $postType;
        // Default to now if not provided
        $this->createdAt = $createdAt ? new DateTime($createdAt) : new DateTime(); 
    }
    
    // Getters
    public function getId(): ?int { return $this->id; }
    public function getUserId(): int { return $this->userId; }
    public function getTitle(): string { return $this->title; }
    public function getContent(): string { return $this->content; }
    public function getPostType(): string { return $this->postType; }
    public function getCreatedAt(): string { return $this->createdAt->format('Y-m-d H:i:s'); } // Formatted for DB
    public function getTimeAgo(): string { return $this->createdAt->format('M d, Y'); } // Formatted for UI

    public function getAuthor(): ?UserModel { return $this->author; }
    public function getComments(): array { return $this->comments; }
    public function isLikedByCurrentUser(): bool { return $this->isLikedByCurrentUser; }
    
    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setAuthor(?UserModel $author): void { $this->author = $author; }
    public function setComments(array $comments): void { $this->comments = $comments; }
    public function setIsLikedByCurrentUser(bool $liked): void { $this->isLikedByCurrentUser = $liked; }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'title' => $this->title,
            'content' => $this->content,
            'post_type' => $this->postType,
            'created_at' => $this->getCreatedAt(),
            
            // Related objects handling
            'author' => $this->author ? [
                'id' => $this->author->getId(),
                'full_name' => $this->author->getFname(), // Assuming UserModel has this
                'email' => $this->author->getEmail()
            ] : null,
            'is_liked' => $this->isLikedByCurrentUser,
            'comments' => array_map(fn($c) => $c->toArray(), $this->comments)
        ];
    }
    
    public static function fromArray(array $data): self {
        // Create the object
        $post = new self(
            userId: $data['user_id'],
            title: $data['title'],
            content: $data['content'],
            postType: $data['post_type'] ?? 'experience',
            createdAt: $data['created_at'] ?? null
        );

        // If 'id' exists (meaning it came from DB), set it
        if (isset($data['id'])) {
            $post->setId((int)$data['id']);
        }

        return $post;
    }
}