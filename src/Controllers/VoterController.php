<?php
class VoterController
{
    protected array $fields;
    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function register()
    {
        $validate = (new Auth($this->fields, new Voters()))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }

        list($orgId) = (new Admins)->getMyDetail("organization");
        $emails = array_map(fn ($detail) => $detail["email"], (new Voters)->fetchAll(["organization" => $orgId]));
        if (in_array($this->fields["email"], $emails)) {
            echo json_encode([
                "message" => [
                    "email" => "email already exist as a Voter of this Organization"
                ],
                "status" => "error"
            ]);
            return;
        }
        $this->fields["password"] = password_hash(12345678, PASSWORD_DEFAULT);
        $this->fields["organization"] = $orgId;
        $this->fields["voting_pin"] = 1234;
        $this->fields["username"] = $this->generateUsername();

        $insert = (new Voters())->insert($this->fields);
        if ($insert) {
            echo json_encode(["message" => "Account Sucessfully Created Kindly login your account", "status" => "success"]);
        } else {
            echo json_encode(["message" => "An Error Occured", "status" => "error"]);
        }
    }

    public function login()
    {
        session_destroy();
        session_start();
        $empty = array_filter($this->fields, fn ($field) => empty($field));
        $data = $this->fields;
        if (count($empty) > 0) {
            echo json_encode(["message" => "Kindly Fill in all fields", "status" => "error"]);
            return;
        }
        unset($this->fields["password"]);
        $fetch = (new Voters())->fetchAll($this->fields);
        if (count($fetch) > 0 && password_verify($data["password"], $fetch[0]["password"])) {
            $_SESSION["voter"] = $fetch[0]["username"];
            echo json_encode(["message" => "Details Sucessfully Verified", "status" => "success"]);
        } else {
            echo json_encode(["message" => "Invalid Username or Password", "status" => "error"]);
        }
    }
    public function getLoggedInVoter()
    {
        return (new Voters)->fetchAll($this->fields);
    }

    public function generateUsername()
    {
        $username = "voter" . str_pad(rand(0, 400), 4, "123");
        $usernameExists = (new Voters)->count(["username" => $username]);
        if ($usernameExists) {
            $this->generateUsername();
        } else {
            return $username;
        }
    }

    public static function getAllVoters($data)
    {
        return (new Voters())->fetchAll($data);
    }

    public function registerMultipleUser()
    {

        if (!isset($_FILES["file"])) {
            echo json_encode([
                "message" => ["file" => "Kindly Upload a file"],
                "status" => "error"
            ]);
            return;
        }
        $file = $_FILES["file"];
        $extension = "csv";
        $uploadedFilename = explode(".", $file["name"]);

        if ($extension != $uploadedFilename[count($uploadedFilename) - 1]) {
            echo json_encode([
                "message" => ["file" => "Uploaded File must be of .csv format"],
                "status" => "error"
            ]);
            return;
        }

        $content = upload($file["tmp_name"]);

        $head = explode(",", $content[0]);
        $body = array_map(fn ($element) => explode(",", $element), array_splice($content, 1));
        list($orgId) = (new Admins)->getMyDetail("organization");
        $others = [
            "password" => password_hash(12345678, PASSWORD_DEFAULT),
            "organization" => $orgId,
        ];

        global $details;
        $details = array_map(fn ($element) => array_merge(
            array_combine(
                array_map(fn ($el) => trim($el), array_values($head)),
                array_map(fn ($el) => trim($el), array_values($element))
            ),
            $others
        ), $body);

        function generateUniqueUsername()
        {
            global $details;
            $generatedUsername = $generatedUsername = array_unique(array_map(fn ($detail) => (new VoterController([]))->generateUsername(), $details));
            if (count($generatedUsername) == count($details)) {
                return $generatedUsername;
            } else {
                generateUniqueUsername();
            }
        };
        $usernames = generateUniqueUsername();
        $newDetails = [];
        foreach ($details as $key => $detail) {
            $detail["username"] = $usernames[$key];
            array_push($newDetails, $detail);
        }
        $details = $newDetails;

        $emails = array_map(fn ($detail) => $detail["email"], (new Voters)->fetchAll(["organization" => $orgId]));
        $importEmails = array_map(fn ($detail) => $detail["email"], $details);
        $emailExpression = "/^([a-zA-Z]+[\w.]+@[a-zA-Z]+\.[a-zA-Z]{2,})$/";
        $nameExpression = "/^[a-zA-Z_-]{3,}$/";
        $mnameExpression = "/^[a-zA-Z_-]*$/";

        $invalid = function ($expression, $search) {
            return  array_filter(
                $GLOBALS['details'],
                fn ($detail) => !preg_match($expression, $detail[$search])
            );
        };
        $emailExists =  array_filter(
            $details,
            fn ($detail) => in_array($detail["email"], $emails)
        );

        if (count($invalid($nameExpression, "firstname")) > 0) {
            echo json_encode([
                "message" => ["file" => "Some of the firstnames are in an invalid format"],
                "status" => "error"
            ]);
            return;
        } else if (count($invalid($nameExpression, "lastname")) > 0) {
            echo json_encode([
                "message" => ["file" => "Some of the lastnames are in an invalid format"],
                "status" => "error"
            ]);
            return;
        } else if (count($invalid($mnameExpression, "middlename")) > 0) {
            echo json_encode([
                "message" => ["file" => "Some of the middlenames are in an invalid format"],
                "status" => "error"
            ]);
            return;
        } else if (count($invalid($emailExpression, "email")) > 0) {
            echo json_encode([
                "message" => ["file" => "Some of the emails are in an invalid format"],
                "status" => "error"
            ]);
            return;
        } else if (count($importEmails) != count(array_unique($importEmails))) {
            echo json_encode([
                "message" => [
                    "file" => "Some of the emails been uploaded are the same"
                ],
                "status" => "error"
            ]);
            return;
        } else if (count($emailExists) > 0) {
            echo json_encode([
                "message" => [
                    "file" => "Some of the emails already exists as a User of this Organization."
                ],
                "status" => "error"
            ]);
            return;
        }

        $insert = (new Voters)->uploadMulti($details);
        if ($insert) {
            echo json_encode([
                "message" => "Account Sucessfully Created", "status" => "success"
            ]);
        } else {
            echo json_encode([
                "message" => [
                    "file" => "An error occured kindly contact the system's Administrators"
                ],
                "status" => "error"
            ]);
        }
    }

    public function resetPassword()
    {
        $validate = (new Auth($this->fields, new Voters()))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }
        list($password) = (new Voters)->getMyDetail("password");

        $verify = password_verify($this->fields["old_password"], $password);
        if ($verify) {
            $data = [
                "password" => password_hash($this->fields["password"], PASSWORD_DEFAULT)
            ];
            $update = (new Voters)->update($data, [
                "username" => $_SESSION["voter"]
            ]);
            if ($update) {
                session_destroy();
                echo json_encode(["message" => "Details Sucessfully Updated", "status" => "success"]);
            } else {
                echo json_encode(["message" => "An Error Occured", "status" => "error"]);
            }
        } else {
            $res = ["message" => ["old_password" => "Old Password must be the same with your Current Passowrd"], "status" => "error"];
            echo json_encode($res);
        }
    }
    public function resetPin()
    {
        $validate = (new Auth($this->fields, new Voters()))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }
        list($password) = (new Voters)->getMyDetail("password");

        $verify = password_verify($this->fields["password"], $password);
        if ($verify) {
            $data = [
                "voting_pin" => $this->fields["voting_pin"]
            ];
            $update = (new Voters)->update($data, [
                "username" => $_SESSION["voter"]
            ]);
            if ($update) {
                echo json_encode(["message" => "Details Sucessfully Updated", "status" => "success"]);
            } else {
                echo json_encode(["message" => "An Error Occured", "status" => "error"]);
            }
        } else {
            $res = ["message" => ["password" => "Account Password must be the same with your Current Passowrd"], "status" => "error"];
            echo json_encode($res);
        }
    }

    public function update()
    {
        $validate = (new Auth($this->fields, new Voters(), false))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }
        $update = (new Voters)->update($this->fields, [
            "voter_id" => $this->fields["voter_id"],
        ]);
        if ($update) {
            echo json_encode(["message" => "Details Sucessfully Updated", "status" => "success"]);
        } else {
            echo json_encode(["message" => "An Error Occured", "status" => "error"]);
        }
    }

    public function delete()
    {
        $delete = (new Voters())->delete($this->fields);
        if ($delete) {
            echo json_encode(["message" => "Acount Sucessfully Deleted", "status" => "success"]);
        } else {
            echo json_encode(["message" => "An Error Occured", "status" => "error"]);
        }
    }
}