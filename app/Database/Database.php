<?php
namespace App\Database;

use PDO;
use PDOException;

class Database
{
    protected const DEFAULT_CONFIG = [
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'hotel'
    ];
    protected static ?Database $instance = null;
    private PDO $pdo;

    private function __construct(array $config)
    {
        $host = $config['host'] ?? self::DEFAULT_CONFIG['host'];
        $user = $config['user'] ?? self::DEFAULT_CONFIG['user'];
        $password = $config['password'] ?? self::DEFAULT_CONFIG['password'];
        $database = $config['database'] ?? self::DEFAULT_CONFIG['database'];

        try {
            $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new \RuntimeException("Database connection error.");
        }
    } 

    public static function getInstance(array $config = []): Database
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    // New method for server-level connection
    public static function getServerPdo(array $config = []): PDO
    {
        $host = $config['host'] ?? self::DEFAULT_CONFIG['host'];
        $user = $config['user'] ?? self::DEFAULT_CONFIG['user'];
        $password = $config['password'] ?? self::DEFAULT_CONFIG['password'];
        
        $dsn = "mysql:host=$host;charset=utf8mb4";
        try {
            return new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            error_log("Server connection error: " . $e->getMessage());
            throw new \RuntimeException("Server connection error.");
        }
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    // Optionally updated execSql
    public function execSql(string $sql, array $params = []): bool|int|array
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            if (str_starts_with(strtoupper(trim($sql)), 'INSERT')) {
                return (int) $this->pdo->lastInsertId();
            }
            
            if (str_starts_with(strtoupper(trim($sql)), 'SELECT')) {
                return $stmt->fetchAll() ?: [];
            }

            return true; // Changed from $stmt->rowCount() > 0
        } catch (PDOException $e) {
            $_SESSION['error_message'] = $e->getMessage();
            error_log($e->getMessage());
            return false;
        }
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function rollback()
    {
        return $this->pdo->rollback();
    }
}
?>