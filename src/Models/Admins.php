<?php
class Admins extends Database
{
    protected $table = "admins";
    public function uploadMulti(array $fields)
    {
        try {
            $this->connection->beginTransaction();
            foreach ($fields as $key => $field) {
                list($key, $sanitizedKey, $sanitizedData) = $this->getSanitized($field);
                $column = implode(", ", $key);
                $values = implode(", ", $sanitizedKey);
                $query = "INSERT INTO $this->table($column) VALUES($values)";
                $stmt = $this->connection->prepare($query);
                $stmt->execute($sanitizedData);
            }
            $this->connection->commit();
            return true;
        } catch (PDOException $e) {
            $this->connection->rollBack();
            echo "Error During multi insert {$e->getMessage()}";
        }
    }

    public function getMydetail($search)
    {
        return array_values(
            array_filter(
                $this->fetchAll(["username" => $_SESSION["admin"]])[0],
                fn ($el) => in_array($el, [$search]),
                ARRAY_FILTER_USE_KEY
            ),
        );
    }
}
