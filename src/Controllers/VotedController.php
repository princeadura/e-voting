<?php

class VotedController
{
    protected $candidates;
    protected $voted;
    protected $voter;

    public function __construct(protected array $fields)
    {
        $this->candidates = new Candidates;
        $this->voter = new Voters;
        $this->voted = new Voted;
    }

    public function saveVotes()
    {
        $election_id = $this->fields["election_id"];
        $voting_pin = $this->fields["voting_pin"];
        $candidates = $this->candidates->fetchAll(["election" => $election_id])[0]["candidate"];
        $decodedCandidates = json_decode($candidates);
        $voter = $this->voter->fetchAll(["username" => $_SESSION["voter"]])[0];

        if ($voting_pin !== $voter["voting_pin"]) {
            echo json_encode(["message" => "Invalid Voting Pin", "status" => "error"]);
            return;
        }

        $votedCandidates = array_filter(
            $this->fields,
            fn ($field) => !in_array($field, ["voting_pin", "election_id"]),
            ARRAY_FILTER_USE_KEY
        );

        foreach ($votedCandidates as $key => $votedCandidate) {
            $position = str_replace("_", " ", $key);
            $aspirants = $decodedCandidates->$position;
            $aspirant = array_values(array_filter($aspirants, fn ($aspirant) => $aspirant->voter_id == $votedCandidate))[0];
            $aspirant->votes += 1;
        }

        $saveVote = $this->voted->saveVote($election_id, json_encode($decodedCandidates), $voter["voter_id"]);

        if ($saveVote) {
            echo json_encode(["message" => "Voted Successfully", "status" => "success"]);
        } else {
            echo json_encode(["message" => "An Error Occured", "status" => "error"]);
        }
    }

    public function getVotes()
    {
        $position = $this->fields["position"];
        $election = $this->fields["election"];

        $candidates = count($this->candidates->fetchAll(["election" => $election])) > 0 ? $this->candidates->fetchAll(["election" => $election])[0]["candidate"] : json_encode([]);
        $decodedCandidates = json_decode($candidates);
        $searchedCandidates = $decodedCandidates->$position ?? [];

        global $requiredColumn;
        $requiredColumn = ["firstname", "lastname"];

        $fullCandidate = array_map(
            function ($candidate) {
                $candidates = $this->voter->fetchAll(["voter_id" => $candidate->voter_id])[0];
                $candidateFiltered = array_filter(
                    $candidates,
                    function ($candidateKey) {
                        return in_array($candidateKey, $GLOBALS["requiredColumn"]);
                    },
                    ARRAY_FILTER_USE_KEY
                );
                $candidateFiltered["votes"] = $candidate->votes;
                return $candidateFiltered;
            },
            $searchedCandidates
        );

        echo json_encode(["message" => $fullCandidate, "status" => "success"]);
    }

    public function getElectionWinners()
    {
        $election = $this->fields["election"];

        $candidates = count($this->candidates->fetchAll(["election" => $election])) > 0 ? $this->candidates->fetchAll(["election" => $election])[0]["candidate"] : json_encode([]);
        $decodedCandidates = (array) json_decode($candidates);

        $reducedArray = array_map(function ($decodedCandidate) {
            return array_reduce($decodedCandidate, function ($highest, $current) {
                $vote = $current->votes;
                $candidates = $this->voter->fetchAll(["voter_id" => $current->voter_id])[0];

                global $requiredColumn;
                $requiredColumn = ["firstname", "lastname", "email"];

                $candidateFiltered = array_filter(
                    $candidates,
                    function ($candidateKey) {
                        return in_array($candidateKey, $GLOBALS["requiredColumn"]);
                    },
                    ARRAY_FILTER_USE_KEY
                );

                $candidateFiltered["votes"] = $vote;
                if ($highest) {
                    if ($vote > $highest[0]["votes"]) {
                        return [$candidateFiltered];
                    } else if ($vote == $highest[0]["votes"]) {
                        return [$candidateFiltered, ...$highest];
                    } else {
                        return $highest;
                    }
                } else {
                    return [$candidateFiltered];
                }
            });
        }, $decodedCandidates);

        $fullCandidate = [];

        foreach ($reducedArray as $parent_key => $candidate) {
            foreach ($candidate as $key => $value) {
                $value["position"] = $parent_key;
                array_push($fullCandidate, $value);
            }
        }

        echo json_encode(["message" => $fullCandidate, "status" => "success"]);
    }
}
