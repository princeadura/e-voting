<?php

class ElectionController
{
    protected array $fields;
    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function addElection()
    {
        $validate = (new Auth($this->fields, new Elections()))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }
        list($orgId) = (new Admins)->getMydetail("organization");
        $data = $this->fields;
        $data["organization"] = $orgId;
        $insert = (new Elections)->insert($data);
        if ($insert) {
            $res = ["message" => "Election Sucessfully Added", "status" => "success"];
            echo json_encode($res);
        } else {
            $res = ["message" => "An Error Occured", "status" => "error"];
            echo json_encode($res);
        }
    }

    public function getAllElections()
    {
        return (new Elections)->fetchAll($this->fields);
    }

    public function update()
    {
        $validate = (new Auth($this->fields, new Elections(), false))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }
        $election = function ($electionId) {
            $details = (new Elections)->fetchAll(["election_id" => $electionId])[0];
            if (strtolower($details["election_status"]) != "pending") {
                unset($this->fields["election_start_date"]);
            }
        };
        $election($this->fields["election_id"]);
        $update = (new Elections)->update($this->fields, [
            "election_id" => $this->fields["election_id"],
        ]);
        if ($update) {
            echo json_encode(["message" => "Details Sucessfully Updated", "status" => "success"]);
        } else {
            echo json_encode(["message" => "An Error Occured", "status" => "error"]);
        }
    }

    public function deleteElection()
    {
        $delete = (new Elections())->delete($this->fields);
        if ($delete) {
            echo json_encode(["message" => "Election Sucessfully Deleted", "status" => "success"]);
        } else {
            echo json_encode(["message" => "An Error Occured", "status" => "error"]);
        }
    }
}
