<?php
  

  class dataBase
  {
      private string $host;
      private string $dbName;
      private string $userName;
      private string $password;
      private ?PDO $conn;
  
      public function __construct(string $host, string $dbName, string $userName, string $password)
      {
          $this->host = $host;
          $this->dbName = $dbName;
          $this->userName = $userName;
          $this->password = $password;
            $this->conn = null;
  
         try {
              if(empty($this->host) || empty($this->dbName) || empty($this->userName) || empty($this->password)){
                 throw new PDOException('Les informations de connexion sont incorrectes');
              }
  
              $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->userName, $this->password);
               $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch (PDOException $e) {
                if(defined('DEBUG') && DEBUG){
                   echo "error :" . $e->getMessage();
              }
          }
      }
  
      public function getConnection(): ?PDO
      {
          return $this->conn;
      }
  
      public function closeConnection(): void
      {
          $this->conn = null;
      }
  
      public function executeQuery(string $query, array $params = []): bool|array
      {
          try {
              if (!$this->conn) {
                  throw new PDOException('Base de données non connectée');
              }
      
              $stmt = $this->conn->prepare($query);
             
      
              // Execute with or without parameters
              $stmt->execute($params); 
      
              $queryType = strtoupper(strtok(trim($query), ' '));
              if (in_array($queryType, ['SELECT', 'SHOW', 'DESCRIBE', 'EXPLAIN'])) {
                  return $stmt->fetchAll(PDO::FETCH_ASSOC);
              }
      
              // For other query types, return true on success or false on failure.
              return $stmt->rowCount() > 0;
          } catch (PDOException $e) {

              // Debug error handling
              if (defined('DEBUG') && DEBUG) {

                  echo "Error executing query: " . $e->getMessage();
              }
              return false;
          }
      }
      
      
  }
  ?>