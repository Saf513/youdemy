<?php
use PDO;
use PDOException;

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
            echo "error :" . $e->getMessage();
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

    public function executeQuery(string $query, array $params): bool|array
    {
      try {
            if (!$this->conn) {
                 throw new PDOException('Base de données non connectée');
            }
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            if (strpos(strtolower($query), 'select') === 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return true;
         }
           catch (PDOException $e) {
            echo "Error executing query: " . $e->getMessage();
               return false;
         }
    }
}
?>