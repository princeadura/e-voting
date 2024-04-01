<?php

class Voted extends Database
{
    protected $table = "voted";

    public function saveVote($election, $votes, $voter)
    {
        $voted = $this->fetchAll(["election" => $election]);

        $this->connection->beginTransaction();

        try {
            $updateVotes = $this->connection->prepare("UPDATE candidates SET candidate = :vote WHERE election = :election");

            if (count($voted) > 0 && json_decode($voted[0]["voters"]) > 0) {
                $votedVoters = json_decode($voted[0]["voters"]);

                array_push($votedVoters, (int) $voter);

                $updateVoted = $this->connection->prepare("UPDATE $this->table  SET voters = :voters WHERE election = :election");

                $updateVoted->execute([
                    "election" => $election,
                    "voters" => json_encode(array_unique($votedVoters)),
                ]);
            } else {
                $votedVoters = json_encode([$voter]);

                $updateVoted = $this->connection->prepare("INSERT INTO $this->table (election, voters) VALUES (:election, :voters)");
                $updateVoted->execute([
                    "election" => $election,
                    "voters" => $votedVoters,
                ]);
            }

            $updateVotes->execute(["vote" => $votes, "election" => $election]);


            $this->connection->commit();
            return true;
        } catch (PDOException $e) {
            // Rollback transaction if any error occurs
            $this->connection->rollback();
            echo "Transaction failed: " . $e->getMessage();
        }
    }
}
