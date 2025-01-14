<?php
class Course
{
    private int $id;
    private string $title;
    private string $description;
    private string $content;
    private int $authorId;
    private array $tags = [];
    private int $categoryId;
    private string $miniature;
    private DateTime $createdAt;
    private string $contentType;
    private string $contentUrl;
    private string $status;

    public function __construct($id = null, $title = null, $description = null, $content = null, $miniature = null, $authorId = null, $categoryId = null, $createdAt = null, $isPublished = false)
    {

        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->authorId = $authorId;
        $this->categoryId = $categoryId;
        $this->createdAt = $createdAt;
        $this->miniature = $miniature;
    }
    // getters et setters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

   
    public function getTags(): array
    {
        return $this->tags;
    }
}
