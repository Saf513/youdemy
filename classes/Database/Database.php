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
            if (empty($this->host) || empty($this->dbName) || empty($this->userName) || empty($this->password)) {
                throw new PDOException('Les informations de connexion sont incorrectes');
            }

            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->userName, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            if (defined('DEBUG') && DEBUG) {
                echo "error :" . $e->getMessage();
            }
        }
    }


    public function fetchColumn($query, $params = [])
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn();
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
                throw new PDOException('Database not connected');
            }
    
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($params);
    
            // Get query type
            $queryType = strtoupper(trim(strtok($query, ' ')));
    
            // For SELECT queries, return the results
            if (in_array($queryType, ['SELECT', 'SHOW', 'DESCRIBE', 'EXPLAIN'])) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
    
            // For INSERT, UPDATE, DELETE - return the execution result directly
            if (in_array($queryType, ['INSERT', 'UPDATE', 'DELETE'])) {
                return $result;
            }
    
            return false;
        } catch (PDOException $e) {
            if (defined('DEBUG') && DEBUG) {
                error_log("Error executing query: " . $e->getMessage());
            }
            return false;
        }
    }
}
