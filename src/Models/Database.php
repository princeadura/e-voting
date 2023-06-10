<?php

/**
 * Database
 * This class is responsible for the database connections of the system
 */
class Database
{
    /* 
        Initializing the properties of the the database class 
    */
    protected $table;
    protected $connection;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * connect
     *
     * @return void
     */
    public function connect()
    {
        try {
            $connection = new PDO("mysql:host=localhost;dbname=e-voting", "root", "sijuade");
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection = $connection;
            // echo "Sucessfull";
        } catch (PDOException $e) {
            // echo "Error During Connection: {$e->getMessage()}";
        }
    }

    public function fetch()
    {
        try {
            $query = "SELECT * FROM $this->table";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // echo "Error When Fetching: {$e->getMessage()}";
        }
    }

    public function count(array $data, $sep = "")
    {
        list($keys, $sanitizedKey, $sanitizedData) = $this->getSanitized($data);
        $countColumn = array_map(
            fn ($column, $value) => $column . " = " . $value,
            $keys,
            $sanitizedKey
        );
        $column = implode(" $sep ", $countColumn);
        try {
            $query = "SELECT COUNT(*) FROM $this->table WHERE $column";
            $stmt = $this->connection->prepare($query);
            $stmt->execute($sanitizedData);
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            return $result;
        } catch (PDOException $e) {
            // echo "Error During Counting: {$e->getMessage()}";
        }
    }

    public function update(array $data, array $where, $sep = "AND")
    {
        list($keys, $sanitizedKey, $sanitizedData) = $this->getSanitized($data);
        list($whereKeys, $whereSanitizedKey, $whereSanitizedData) = $this->getSanitized($where);

        $column = implode(
            ",",
            array_map(
                fn ($key, $value) => $key . " = " . $value,
                $keys,
                $sanitizedKey
            )
        );

        $whereColumn = implode(
            " $sep ",
            array_map(
                fn ($key, $value) => $key . " = " . $value,
                $whereKeys,
                $whereSanitizedKey
            )
        );

        $fullSanitized = array_merge($sanitizedData, $whereSanitizedData);

        try {
            $query = "UPDATE $this->table SET $column, updated_at = CURRENT_TIMESTAMP WHERE $whereColumn";
            $stmt = $this->connection->prepare($query);
            $stmt->execute($fullSanitized);
            return true;
        } catch (PDOException $e) {
            // echo "Error During Updating: {$e->getMessage()}";
        }
    }

    public function insert(array $data)
    {
        list($keys, $sanitizedKey, $sanitizedData) = $this->getSanitized($data);
        $column = implode(",", $keys);
        $values = implode(",", $sanitizedKey);
        try {
            $query = "INSERT INTO $this->table($column) VALUES($values)";
            $stmt = $this->connection->prepare($query);
            $stmt->execute($sanitizedData);
            return true;
        } catch (PDOException $e) {
            echo "Error During Inserting: {$e->getMessage()}";
        }
    }

    public function fetchAll(array $data, string $sep = "AND")
    {
        list($keys, $sanitizedKey, $sanitizedData) = $this->getSanitized($data);
        $where = implode(
            " $sep ",
            array_map(
                fn ($key, $skey) => $key . " = " . $skey,
                $keys,
                $sanitizedKey
            )
        );
        try {
            $query = "SELECT * FROM $this->table WHERE $where";
            $stmt = $this->connection->prepare($query);
            $stmt->execute($sanitizedData);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // echo "Error When Fetching: {$e->getMessage()}";
        }
    }
    public function delete(array $data, string $sep = "AND")
    {
        list($keys, $sanitizedKey, $sanitizedData) = $this->getSanitized($data);
        $where = implode(
            " $sep ",
            array_map(
                fn ($key, $skey) => $key . " = " . $skey,
                $keys,
                $sanitizedKey
            )
        );
        try {
            $query = "DELETE FROM $this->table WHERE $where";
            $stmt = $this->connection->prepare($query);
            $stmt->execute($sanitizedData);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return true;
        } catch (PDOException $e) {
            // echo "Error When Fetching: {$e->getMessage()}";
        }
    }

    protected function getSanitized(array $data)
    {
        return [
            $keys = array_map(fn ($el) => trim($el), array_keys($data)),
            $sanitizedKey = array_map(fn ($key) => ":" . $key, $keys),
            array_combine($sanitizedKey, array_map(fn ($el) => trim($el), array_values($data)))
        ];
    }
}
