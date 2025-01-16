<?php
                                         /*===================/*
                                             classe de Course
                                         /*===================*/   
                                         require_once dirname(__DIR__, 2) . '/classes/Course/Tag.php';

            

class Course
{
    private ?int $id;
    private ?string $title;
    private ?string $description;
    private ?string $content;
    private ?int $authorId;
    private ?array $tags = [];
    private ?int $categoryId;
    private ?DateTime $createdAt;
    private ?string $contentType;
    private ?string $contentUrl;
    private ?string $status;
    private ?string $thumbnailUrl;

    /*==================/*
         constructure
    /*=================*/

    public function __construct($id = null, $title = null, $description = null, $content = null, $authorId = null, $categoryId = null, $createdAt = null , $contentUrl=null , $thumbnailUrl=null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->authorId = $authorId;
        $this->categoryId = $categoryId;
        $this->createdAt = $createdAt;
        $this->contentUrl =$contentUrl;

    }

/*==================/*
         getters
/*=================*/







/*===============================/*
       fonction loadData    
/*============================*/

public function loadData(array $data, dataBase $db): void
{
    $this->id = (int) $data['id'];
    $this->title = $data['title'];
    $this->description = $data['description'];
    $this->content = $data['content'];
    $this->authorId = $data['user_id']; // Assurez-vous que c'est 'user_id' dans la base de données
    $this->categoryId = $data['category_id'];
    $this->createdAt = new DateTime($data['created_at']);
    $this->contentType = $data['content_type'];
    $this->contentUrl = $data['content_url'];
    $this->status = $data['status'];
    $this->thumbnailUrl = $data['thumbnailUrl'] ?? null;
    $this->tags = Tag::getTagsByCourseId($db, $this->id);
}



    public function getId(): ?int
{
    return $this->id;
}

/*==================/*
  fonction de save
/*=================*/

    public function save(dataBase $db): bool
    {
        if (isset($this->id)) {
            $query = "UPDATE courses SET title = :title, description = :description, content = :content, user_id = :author_id, category_id = :category_id, content_type = :content_type, content_url = :content_url,  status = :status, thumbnailUrl = :thumbnailUrl WHERE id = :id";
            $params = [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'content' => $this->content,
                'author_id' => $this->authorId,
                'category_id' => $this->categoryId,
                'content_type' => $this->contentType,
                'content_url' => $this->contentUrl,
                'status' => $this->status,
                'thumbnailUrl' => $this->thumbnailUrl,
            ];
            $result = $db->executeQuery($query, $params);
            $this->saveCourseTags($db);
            return $result;
        } else {
            $query = "INSERT INTO courses (title, description, content, user_id, category_id, created_at, content_type, content_url, status, thumbnailUrl) VALUES (:title, :description, :content, :author_id, :category_id, NOW(), :content_type, :content_url, :status, :thumbnailUrl)";
            $params = [
                'title' => $this->title,
                'description' => $this->description,
                'content' => $this->content,
                'author_id' => $this->authorId,
                'category_id' => $this->categoryId,
                'content_type' => $this->contentType,
                'content_url' => $this->contentUrl,
                'status' => $this->status,
                'thumbnailUrl' => $this->thumbnailUrl,
            ];
            $result = $db->executeQuery($query, $params);
            if ($result) {
                $this->id = (int) $db->getConnection()->lastInsertId();
                $this->saveCourseTags($db);
                return true;
            }
            return false;
        }
    }

    private function saveCourseTags(dataBase $db): void
    {
        $query = "DELETE FROM course_tags WHERE course_id = :course_id";
        $db->executeQuery($query, ['course_id' => $this->id]);
        foreach ($this->tags as $tag) {
            $query = "INSERT INTO course_tags (course_id, tag_id) VALUES (:course_id, :tag_id)";
            $db->executeQuery($query, ['course_id' => $this->id, 'tag_id' => $tag->getId()]);
        }
    }

    public function delete(dataBase $db): bool
    {
        $query = "DELETE FROM courses WHERE id = :id";
        return  $db->executeQuery($query, ['id' => $this->id]);
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

    public function getTags(): array
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): bool
    {
        if (!in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
            return true;
        }
        return false;
    }
    public function removeTag(Tag $tag): bool
    {
        $this->tags = array_filter($this->tags, function ($item) use ($tag) {
            return $item->getId() !== $tag->getId();
        });
        return true;
    }

    public function removeALlTags(dataBase $db): bool
    {
        $query = "DELETE FROM course_tags WHERE course_id = :course_id";
        return  $db->executeQuery($query, ['course_id' => $this->id]);
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }
    public function setContentType(string $contentType): void
    {
        $this->contentType = $contentType;
    }

    public function getContentUrl(): string
    {
        return $this->contentUrl;
    }
    public function setContentUrl(string $contentUrl): void
    {
        $this->contentUrl = $contentUrl;
    }

    public function getStatus(): string
    {
        return $this->status="draft";
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
    public function getThumbnailUrl(): ?string
    {
        return $this->thumbnailUrl;
    }
    public function setThumbnailUrl(?string $thumbnailUrl): void
    {
        $this->thumbnailUrl = $thumbnailUrl;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public static function getCourseById(dataBase $db, int $id): ?Course
    {
        $query = "SELECT * FROM courses WHERE id = :id";
        $result =   $db->executeQuery($query, ['id' => $id]);
        if ($result && count($result) > 0) {
            $courseData = $result[0];
            $course =  new Course();
            $course->loadData($courseData, $db);
            return $course;
        }
        return null;
    }


    public static function getCoursesByTeacherId(dataBase $db, int $teacherId): array
    {
        $query = "SELECT * FROM courses WHERE user_id = :user_id";
        $result = $db->executeQuery($query, ['user_id' => $teacherId]);
        $courses = [];
        if ($result) {
            foreach ($result as $courseData) {
                $course = new Course();
                $course->loadData($courseData, $db);
                $courses[] = $course;
            }
        }
        return $courses;
    }
    public static function getCoursesByStudentId(dataBase $db, int $studentId): array
    {
        $query = "
            SELECT c.*
            FROM courses c
            INNER JOIN enrollments es ON c.id = es.course_id
            WHERE es.student_id = :student_id
        ";
        $result =   $db->executeQuery($query, ['student_id' => $studentId]);
        $courses = [];
        if ($result) {
            foreach ($result as $courseData) {
                $course = new Course();
                $course->loadData($courseData, $db);
                $courses[] = $course;
            }
        }
        return $courses;
    }

/*===========================/*
  fonction de get all courses
/*=========================*/

    public static function getAllCourses(dataBase $db): array
    {
        $query = "SELECT * FROM courses";
        $result = $db->executeQuery($query, []);
        $courses = [];
        if ($result) {
            foreach ($result as $courseData) {
                $course = new Course();
                $course->loadData($courseData, $db);
                $courses[] = $course;
            }
        }
        return $courses;
    }
}
