<?php
require_once __DIR__ . "/../../env.config.php";

try {
    $dbHost = DB_HOST;
    $db = DB_NAME;
    $user = DB_USER;
    $password = DB_PASSWORD;
    $conn = new PDO("mysql:host=$dbHost;dbname=$db", $user, $password);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

class QueryBuilder {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    public function select($table, $columns = "*", $conditions = [], $limit = null, $offset = null, $orderBy = null) {
        $sql = "SELECT $columns FROM $table";

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($conditions)));
        }

        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }

        if ($limit) {
            $sql .= " LIMIT $limit";
        }

        if ($offset) {
            $sql .= " OFFSET $offset";
        }

        $stmt = $this->conn->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(pdo::FETCH_ASSOC);
    }

    public function update($table, $data, $conditions) {
        $setClause = implode(", ", array_map(fn($key) => "$key = :set_$key", array_keys($data)));
        $whereClause = implode(" AND ", array_map(fn($key) => "$key = :cond_$key", array_keys($conditions)));

        $sql = "UPDATE $table SET $setClause WHERE $whereClause";
        $stmt = $this->conn->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":set_$key", $value);
        }

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":cond_$key", $value);
        }

        return $stmt->execute();
    }

    public function delete($table, $conditions) {
        $whereClause = implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($conditions)));

        $sql = "DELETE FROM $table WHERE $whereClause";
        $stmt = $this->conn->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    public function selectWithJoin($table, $columns = "*", $joins = [], $conditions = [], $limit = null, $offset = null, $orderBy = null, $groupBy = null) {
        $sql = "SELECT $columns FROM $table";
        foreach ($joins as $join) {
            $sql .= " " . strtoupper($join['type']) . " JOIN " . $join['table'] . " ON " . $join['on'];
        }
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($conditions)));
        }
        if ($groupBy) {
            $sql .= " GROUP BY $groupBy";
        }
        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        if ($offset) {
            $sql .= " OFFSET $offset";
        }
        $stmt = $this->conn->prepare($sql);
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    public function commit() {
        return $this->conn->commit();
    }

    public function rollBack() {
        return $this->conn->rollBack();
    }
}

$queryBuilder = new QueryBuilder($conn);