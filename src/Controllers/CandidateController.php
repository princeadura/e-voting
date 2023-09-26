<?php
class CandidateController
{
    protected array $fields;
    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function getOrganization()
    {
        return (new Organizations)->fetchAll($this->fields);
    }

    public function addCandidate()
    {
        $candidates = array_filter(
            $this->fields,
            fn ($field) => preg_match("/^candidate(.*)$/", $field),
            ARRAY_FILTER_USE_KEY
        );
        $columnChecked = (new Candidates())->count(["election" => $this->fields["election"]]);

        if (count($candidates) <= 0) {
            $res = ["message" => "No Candidate Selected", "status" => "error"];
            echo json_encode($res);
            return;
        }

        $savedCandidates = array_values(array_map(function ($candidate) {
            return ["voter_id" => $candidate, "img" => "", "votes" => 0];
        }, $candidates));

        $admin = array_filter((new Admins)->fetchAll([
            "username" => $_SESSION["admin"]
        ]))[0];

        list($organization) =   array_values(
            array_filter(
                $admin,
                fn ($details) => in_array($details, ["organization"]),
                ARRAY_FILTER_USE_KEY
            )
        );

        if ($columnChecked > 0) {
            $savedRecords = array_map(fn ($save) => (array) json_decode($save["candidate"]), (new Candidates())->fetchAll(["election" => $this->fields["election"]]))[0];
            $savedPosition = array_keys($savedRecords);
            if (in_array($this->fields["position"], $savedPosition)) {
                foreach ($savedCandidates as $key => $value) {
                    array_push($savedRecords[$this->fields["position"]], $value);
                }
            } else {
                $savedRecords[$this->fields["position"]] = $savedCandidates;
            }
            $data = ["candidate" => json_encode($savedRecords)];
            $update = (new Candidates())->update($data, ["election" => $this->fields["election"]]);
            if ($update) {
                echo json_encode(["message" => "Candidate(s) Sucessfully Added", "status" => "success"]);
            } else {
                echo json_encode(["message" => "An Error Occured", "status" => "error"]);
            }
        } else {
            $data = [
                "election" => $this->fields["election"],
                "organization" => $organization,
                "candidate" => json_encode([$this->fields["position"] => $savedCandidates])
            ];
            $insert = (new Candidates())->insert($data);
            if ($insert) {
                echo json_encode(["message" => "Candidate(s) Sucessfully Added", "status" => "success"]);
            } else {
                echo json_encode(["message" => "An Error Occured", "status" => "error"]);
            }
        }
    }

    public function setCandidateImage(array $file)
    {
        // print_r($this->fields);
        $expectedImage = ["image/png", "image/jpg", "image/jpeg"];
        if (!in_array($file["type"], $expectedImage)) {
            $res = ["message" => "Candidate Images are expected to be in a png, jpg or jpeg format", "status" => "error"];
            echo json_encode($res);
        } else if ($file["size"] > 18000) {
            $res = ["message" => "Image Sizes are expected to not exceed 16kb", "status" => "error"];
            echo json_encode($res);
        } else {
            // print_r($file);
            // print_r($this->fields);
            global $voter_id, $path, $backupPath, $previousImage;
            list($election, $position, $voter_id) = array_values($this->fields);
            $userdetails = (new Voters())->fetchAll(["voter_id" => $voter_id])[0];
            $splitFileName = explode(".", $file["name"]);
            $extensionName = $splitFileName[count($splitFileName) - 1];
            $randNum = rand(0, 100000);
            $uploadName = "{$userdetails["username"]}{$randNum}.{$extensionName}";
            $path = $_SERVER["DOCUMENT_ROOT"] . "/assets/images/candidate_images/";
            $backupPath = $_SERVER["DOCUMENT_ROOT"] . "/assets/images/backup/";
            $uploadFullPath = "{$path}{$uploadName}";

            $candidateDetails =  (array) json_decode((new Candidates())->fetchAll([
                "election" => $election
            ])[0]["candidate"]);
            $filteringWithPosition = array_values(array_filter($candidateDetails[$position], function ($candidate) {
                return $candidate->voter_id == $GLOBALS["voter_id"];
            }))[0];
            $previousImage = $filteringWithPosition->img;
            $returnImage = function () {
                rename(
                    $GLOBALS["backupPath"] . $GLOBALS["previousImage"],
                    $GLOBALS["path"] . $GLOBALS["previousImage"]
                );
            };
            if ($previousImage) {
                rename(
                    $path . $previousImage,
                    $backupPath . $previousImage
                );
            }
            $upload = move_uploaded_file($file['tmp_name'], $uploadFullPath);
            if (!$upload) {
                if ($previousImage) {
                    $returnImage();
                }
                $res = ["message" => "an error occured kindly contact administrators.", "status" => "error"];
                echo json_encode($res);
                return;
            }
            $filteringWithPosition->img = $uploadName;
            $data = ["candidate" => json_encode($candidateDetails)];
            $update = (new Candidates())->update($data, ["election" => $election]);
            if ($update) {
                if ($previousImage) {
                    unlink($backupPath . $previousImage);
                }
                $res = json_encode([
                    "message" => "Image has been uploaded Sucessfully.",
                    "img" => $uploadName,
                    "status" => "success"
                ]);
            } else {
                unlink($uploadFullPath);
                if ($previousImage) {
                    $returnImage();
                }
                $res = json_encode(["message" => "An Error Occured", "status" => "error"]);
            }
            echo $res;
        }
    }

    public function deleteCandidate()
    {
        // print_r($this->fields);
        global $voter_id;
        list($voter_id, $election, $position) = array_values($this->fields);
        $candidateDetails =  (array) json_decode((new Candidates())->fetchAll([
            "election" => $election
        ])[0]["candidate"]);
        $backupPath = $_SERVER["DOCUMENT_ROOT"] . "/assets/images/backup/";
        $path = $_SERVER["DOCUMENT_ROOT"] . "/assets/images/candidate_images/";
        $selectedPositionCandidate = $candidateDetails[$position];
        $filteringWithPosition = array_values(
            array_filter(
                $candidateDetails[$position],
                function ($candidate) {
                    return $candidate->voter_id == $GLOBALS["voter_id"];
                }
            )
        )[0];
        $previousImage = $filteringWithPosition->img;
        $targetId = array_search($filteringWithPosition, $selectedPositionCandidate);
        unset($selectedPositionCandidate[$targetId]);
        if ($previousImage) {
            rename(
                $path . $previousImage,
                $backupPath . $previousImage
            );
        }
        $candidateDetails[$position] = array_values($selectedPositionCandidate);
        $data = ["candidate" => json_encode($candidateDetails)];
        $update = (new Candidates())->update($data, ["election" => $election]);
        if ($update) {
            if ($previousImage) {
                unlink($backupPath . $previousImage);
            }
            $res = json_encode([
                "message" => "Candidate Succesfully Removed",
                "status" => "success"
            ]);
        } else {
            if ($previousImage) {
                rename(
                    $backupPath . $previousImage,
                    $path . $previousImage,
                );
            }
            $res = json_encode(["message" => "An Error Occured", "status" => "error"]);
        }
        echo $res;
    }
}
