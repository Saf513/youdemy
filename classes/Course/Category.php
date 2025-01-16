<?php

class Category
{
    
    private ?int $id;
    private string $name;
    private string $description;

   public function __construct($id = null, $name = null, $description = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
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

    public function getDescription(): string
    {
        return $this->description;
    }

     public function setDescription(string $description): void
    {
         $this->description = $description;
    }

       public function addCourse(Course $course): void
    {
        // Logic for adding course to category
        //  $this->courses[] = $course;
    }


    public function removeCourse(Course $course): void
    {
        // Logic for removing course to category
          //   $this->courses = array_filter($this->courses, fn($c) => $c->getId() !== $course->getId());
    }
     public static function getCategoryById(int $id): ?Category
    {
         $db = new Database('localhost', 'youdemy', 'root', '');
        $query = "SELECT * FROM categories WHERE id = :id";
        $result = $db->executeQuery($query, ['id' => $id]);

        if ($result && count($result) > 0) {
           $categoryData = $result[0];
           return new Category($categoryData['id'], $categoryData['name'], $categoryData['description']);
        }
        return null;
    }

    //   public static function getAllCategories(): array|bool
    // {
    //     $db = new Database('localhost', 'youdemy', 'root', 'root');
    //       $query = "SELECT * FROM categories";
    //      $result = $db->executeQuery($query,[]);
    //     if($result){
    //         $categories = [];
            
    //         foreach($result as $categoryData){
    //             $categories[] = new Category($categoryData['id'], $categoryData['name'], $categoryData['description']);
    //         }
    //         return $categories;
    //     }
    //     return false;
    // }

    public static function getAllCategories(): array|bool
{
    $db = new Database('localhost', 'youdemy', 'root', 'root');
    $query = "SELECT * FROM categories";
    $result = $db->executeQuery($query, []);
    
    if ($result && is_array($result)) { // Vérifier que le résultat est un tableau
        $categories = [];
        foreach ($result as $categoryData) {
            // Crée une nouvelle instance de Category pour chaque entrée
            $categories[] = new Category(
                $categoryData['id'],
                $categoryData['name'],
                $categoryData['description'] ?? null // Gestion des valeurs NULL pour description
            );
        }
        return $categories; // Retourne les catégories
    }

    // En cas d'échec ou si le résultat n'est pas valide, retourner false
    if (defined('DEBUG') && DEBUG) {
        echo "Error fetching categories: ";
        var_dump($result);
    }
    return false;
}

       public function save(): bool
    {
        $db = new Database('localhost', 'youdemy', 'root', '');
        if (isset($this->id)) {
            $query = "UPDATE categories SET name = :name, description = :description WHERE id = :id";
             $params = [
                 'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
            ];
        } else {
            $query = "INSERT INTO categories (name, description) VALUES (:name, :description)";
            $params = [
                 'name' => $this->name,
                 'description' => $this->description,
            ];
             }
       $result = $db->executeQuery($query, $params);
          if(!$this->id){
            $this->id = (int) $db->getConnection()->lastInsertId();
          }
       return  $result;
     }

     public function delete(): bool
    {
          $db = new Database('localhost', 'youdemy', 'root', '');
        $query = "DELETE FROM categories WHERE id = :id";
        return $db->executeQuery($query,['id' => $this->id]);
    }
}