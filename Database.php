<?php 
class Database extends PDO {
    public function __construct(array $config = []){

        $driver = $config['driver'] ?? 'mysql';
        $host = $config['host'] ?? '127.0.0.1';
        $port = $config['port'] ?? '3306';
        $dbname = $config ['dbname'] ?? 'db_aula';
        $user = $config ['user'] ?? 'root';
        $pass = $config ['pass'] ?? '';
        $charset = $config ['charset'] ?? 'utf8mb4';

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        parent::__construct($dsn, $user, $pass, $options);
    }

    public function select(string $sql, array $params =[]) : array{
        $stmt = $this ->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $rows;
    }

    public function insert(string $sql, array $params =[]) : int{
        $stmt = $this ->prepare($sql);
        $stmt->execute($params);
        return (int)$this->lastInsertId();
    }

    public function updatedelete(string $sql, array $params =[]) : int{
        $stmt = $this ->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

}

?>