<?php

class Positions extends Database
{
    protected $table = "positions";

    public function deletePosition($position, $candidate, $election)
    {
        try {
            $this->connection->beginTransaction();
            $this->update(
                ["position" => json_encode($position)],
                ["election" => $election,]
            );
            (new Candidates)->update(
                ["candidate" => json_encode($candidate)],
                ["election" => $election,]
            );
            $this->connection->commit();
            return true;
        } catch (PDOException $e) {
            $this->connection->rollBack();
            echo "Error Deleting Position {$e->getMessage()}";
        }
    }
}