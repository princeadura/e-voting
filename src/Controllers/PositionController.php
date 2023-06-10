<?php

class PositionController
{
    protected array $fields;
    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function addPosition()
    {
        $validate = (new Auth($this->fields, new Positions()))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }
        list($orgId) = (new Admins)->getMydetail("organization");
        $savedRecords = (new Positions)->fetchAll([
            'election' => $this->fields['election']
        ]);
        if (count($savedRecords) > 0) {
            $savedPositions = json_decode($savedRecords["0"]["position"]);
            if (in_array($this->fields["position"], $savedPositions)) {
                $res = ["message" => ["position" => "Position Already Exists"], "status" => "error"];
                echo json_encode($res);
                return;
            }
            array_push($savedPositions, $this->fields["position"]);
            $position = json_encode($savedPositions);
            $update = (new Positions)->update(
                ["position" => $position],
                [
                    "election" => $this->fields["election"],
                    "organization" => $orgId
                ]
            );
            if ($update) {
                $res = ["message" => "Position Sucessfully Added", "status" => "success"];
                echo json_encode($res);
            } else {
                $res = ["message" => "An Error Occured", "status" => "error"];
                echo json_encode($res);
            }
        } else {
            $data = $this->fields;
            $data["organization"] = $orgId;
            $data["position"] = json_encode([$this->fields["position"]]);
            $insert = (new Positions)->insert($data);
            if ($insert) {
                $res = ["message" => "Position Sucessfully Added", "status" => "success"];
                echo json_encode($res);
            } else {
                $res = ["message" => "An Error Occured", "status" => "error"];
                echo json_encode($res);
            }
        }
    }
    public function editPosition()
    {
        $validate = (new Auth($this->fields, new Positions()))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }
        list($orgId) = (new Admins)->getMydetail("organization");
        $savedPositions = (new Positions)->fetchAll([
            'election' => $this->fields['election'],
            "organization" => $orgId
        ])[0]["position"];
        $position = json_decode($savedPositions);
        if (in_array($this->fields["position"], $position)) {
            $res = ["message" => ["position" => "Position Already Exists"], "status" => "error"];
            echo json_encode($res);
            return;
        }
        $position[$this->fields["index_id"]] = $this->fields["position"];
        $update = (new Positions)->update(
            ["position" => json_encode($position)],
            [
                "election" => $this->fields["election"],
                "organization" => $orgId
            ]
        );
        if ($update) {
            $res = ["message" => "Position Sucessfully Updated", "status" => "success"];
            echo json_encode($res);
        } else {
            $res = ["message" => "An Error Occured", "status" => "error"];
            echo json_encode($res);
        }
    }

    public function deletePosition()
    {
        $validate = (new Auth($this->fields, new Positions()))->validation();
        list($orgId) = (new Admins)->getMydetail("organization");
        $savedPositions = (new Positions)->fetchAll([
            'election' => $this->fields['election'],
            "organization" => $orgId
        ])[0]["position"];
        $position = json_decode($savedPositions);
        unset($position[$this->fields["index_id"]]);
        $position = array_values($position);
        $update = (new Positions)->update(
            ["position" => json_encode($position)],
            [
                "election" => $this->fields["election"],
                "organization" => $orgId
            ]
        );
        if ($update) {
            $res = ["message" => "Position Sucessfully Deleted", "status" => "success"];
            echo json_encode($res);
        } else {
            $res = ["message" => "An Error Occured", "status" => "error"];
            echo json_encode($res);
        }
    }
}
