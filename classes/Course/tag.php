<?php

class Tag
{
    private ?int $id;
    private string $name;


    public function __construct($id = null, $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
     public function setId(int $id): void
    {
         $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

     public function setName(string $name): void
    {
         $this->name = $name;
    }
      public static function getTagById(int $id): ?Tag
    {
        $db = new Database('localhost', 'youdemy', 'root', '');
        $query = "SELECT * FROM tags WHERE id = :id";
        $result = $db->executeQuery($query, ['id' => $id]);

        if ($result && count($result) > 0) {
           $tagData = $result[0];
           return new Tag($tagData['id'], $tagData['name']);
        }
        return null;
    }


    public static function getTagsByCourseId(Database $db,int $courseId): array
    {
        $query = "
           SELECT t.*
            FROM tags t
            INNER JOIN course_tags ct ON t.id = ct.tag_id
            WHERE ct.course_id = :course_id
        ";
        $result = $db->executeQuery($query,['course_id' => $courseId]);

         if ($result) {
                 $tags = [];
                  foreach($result as $tagData){
                    $tags[] =  new Tag($tagData['id'], $tagData['name']);
                  }
                 return $tags;
            }
        return [];
    }
     public static function getAllTags(): array|bool
    {
        $db = new Database('localhost', 'youdemy', 'root', '');
          $query = "SELECT * FROM tags";
         $result = $db->executeQuery($query,[]);
        if($result){
            $tags = [];
            foreach($result as $tagData){
                $tags[] = new Tag($tagData['id'], $tagData['name']);
            }
            return $tags;
        }
        return false;
    }
       public function save(): bool
    {
           $db = new Database('localhost', 'youdemy', 'root', '');
        if (isset($this->id)) {
            $query = "UPDATE tags SET name = :name WHERE id = :id";
             $params = [
                 'id' => $this->id,
                'name' => $this->name,
            ];
        } else {
              $query = "INSERT INTO tags (name) VALUES (:name)";
              $params = ['name' => $this->name];
          }
        $result = $db->executeQuery($query, $params);
        if(!$this->id) {
              $this->id = (int) $db->getConnection()->lastInsertId();
        }
           return $result;
    }
         public function delete(): bool
    {
          $db = new Database('localhost', 'youdemy', 'root', '');
          $query = "DELETE FROM tags WHERE id = :id";
         return $db->executeQuery($query,['id' => $this->id]);
    }
}