<?php
class AdminController
{
    protected array $fields;
    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function login()
    {
        $empty = array_filter($this->fields, fn ($field) => empty($field));
        $data = $this->fields;
        if (count($empty) > 0) {
            echo json_encode(["message" => "Kindly Fill in all fields", "status" => "error"]);
            return;
        }
        unset($this->fields["password"]);
        $fetch = (new Admins())->fetchAll($this->fields);
        if (count($fetch) > 0 && password_verify($data["password"], $fetch[0]["password"])) {
            $_SESSION["admin"] = $fetch[0]["email"];
            echo json_encode(["message" => "Details Sucessfully Verified", "status" => "success"]);
        } else {
            echo json_encode(["message" => "Invalid Username or Password", "status" => "error"]);
        }
    }

    public function register($organization = "")
    {
        $validate = (new Auth($this->fields, new Admins()))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }

        if ($organization) {
            list($orgId) = (new Admins)->getMyDetail("organization");
            $this->fields["password"] = password_hash(12345678, PASSWORD_DEFAULT);
            $this->fields["role"] = "regular";
            $this->fields["organization"] = $orgId;
        } else {
            $this->fields["password"] = password_hash($this->fields["password"], PASSWORD_DEFAULT);
        }
        unset($this->fields["confirm_password"]);
        $insert = (new Admins())->insert($this->fields);
        if ($insert) {
            echo json_encode(["message" => "Account Sucessfully Created Kindly login your account", "status" => "success"]);
        } else {
            echo json_encode(["message" => "An Error Occured", "status" => "error"]);
        }
    }

    public function registerMultipleAdmin()
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
            "role" => "regular"
        ];

        global $details;
        $details = array_map(fn ($element) => array_merge(
            array_combine(
                array_map(fn ($el) => trim($el), array_values($head)),
                array_map(fn ($el) => trim($el), array_values($element))
            ),
            $others
        ), $body);

        $emails = array_map(fn ($detail) => $detail["email"], (new Admins)->fetch());
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
        } else if (count($emailExists) > 0) {
            echo json_encode([
                "message" => [
                    "file" => "Some of the emails already exists as an Administrator, Kindly contact the system's Administrator if error persists."
                ],
                "status" => "error"
            ]);
            return;
        }

        $insert = (new Admins)->uploadMulti($details);
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

    public static function getAllAdministrator($data)
    {
        return (new Admins())->fetchAll($data);
    }

    public function getLoggedInAdmin()
    {
        return (new Admins)->fetchAll($this->fields);
    }

    public function resetPassword()
    {
        $validate = (new Auth($this->fields, new Admins()))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }
        list($password) = (new Admins)->getMyDetail("password");

        $verify = password_verify($this->fields["old_password"], $password);
        if ($verify) {
            $data = [
                "password" => password_hash($this->fields["password"], PASSWORD_DEFAULT)
            ];
            $update = (new Admins)->update($data, [
                "email" => $_SESSION["admin"]
            ]);
            if ($update) {
                echo json_encode(["message" => "Details Sucessfully Updated", "status" => "success"]);
            } else {
                echo json_encode(["message" => "An Error Occured", "status" => "error"]);
            }
        } else {
            $res = ["message" => ["old_password" => "Old Password must be the same with your Current Passowrd"], "status" => "error"];
            echo json_encode($res);
        }
    }

    public function update()
    {
        $validate = (new Auth($this->fields, new Admins(), false))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }
        $update = (new Admins)->update($this->fields, [
            "email" => $_SESSION["admin"],
            "admin_id" => $_SESSION["admin_id"]
        ]);
        if ($update) {
            echo json_encode(["message" => "Details Sucessfully Updated", "status" => "success"]);
        } else {
            echo json_encode(["message" => "An Error Occured", "status" => "error"]);
        }
    }

    public function updateAdmin()
    {
        $validate = (new Auth($this->fields, new Admins(), false))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }
        $update = (new Admins)->update($this->fields, [
            "admin_id" => $this->fields["admin_id"],
        ]);
        if ($update) {
            echo json_encode(["message" => "Details Sucessfully Updated", "status" => "success"]);
        } else {
            echo json_encode(["message" => "An Error Occured", "status" => "error"]);
        }
    }

    public function deleteAdmin()
    {
        $delete = (new Admins())->delete($this->fields);
        if ($delete) {
            echo json_encode(["message" => "Acount Sucessfully Deleted", "status" => "success"]);
        } else {
            echo json_encode(["message" => "An Error Occured", "status" => "error"]);
        }
    }
}
