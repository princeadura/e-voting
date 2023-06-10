<?php
class Auth
{
    protected array $data;
    protected array $table;
    protected $register;
    protected object $db;

    public function __construct(array $data, object $db,  $register = true)
    {
        $this->data = $data;
        $this->db = $db;
        $this->register = $register;
    }

    public function validation()
    {
        global $error;
        (array) $error = [];
        $keys = array_keys($this->data);
        foreach ($keys as $key) {
            switch ($key) {
                case ("firstname"):
                    if (!preg_match("/^[a-zA-Z_-]{3,}$/", $this->data[$key])) {
                        $error[$key] = ucfirst($key) . " can't contain numbers and spaces, must have a minimum of 3 character length and can only contain underscore and hyphens";
                    }
                    break;
                case ("username"):
                    if (!preg_match("/^[a-zA-Z-_]{3,}$/", $this->data[$key])) {
                        $error[$key] = ucfirst($key) . " can't contain numbers and spaces, must have a minimum of 3 character length and can only contain hyphens";
                    } else if ($this->register && $this->db->count([$key => $this->data[$key]]) > 0) {
                        $error[$key] = $key . " already exists";
                    }
                    break;
                case ("voting_pin"):
                    $value = ucwords(implode(" ", explode("_", $key)));
                    if (!preg_match("/^[0-9]{4,4}$/", $this->data[$key])) {
                        $error[$key] = $value . " can only contain numbers and have a total of 4 character length.";
                    }
                    break;
                case ("lastname"):
                    if (!preg_match("/^[a-zA-Z_-]{3,}$/", $this->data[$key])) {
                        $error[$key] = ucfirst($key) . " can't contain numbers and spaces, must have a minimum of 3 character length and can only contain underscore and hyphens";
                    }
                    break;
                case ("position"):
                    if (!preg_match("/^([A-Za-z]+[\w\- ]*){3,}$/", $this->data[$key])) {
                        $error[$key] = ucfirst($key) . " can't contain numbers, must have a minimum of 3 character length and can only contain underscores and hyphens ";
                    }
                    break;
                case ("username"):
                    if (!preg_match("/^[a-zA-Z\d_-]{3,}$/", $this->data[$key])) {
                        $error[$key] = ucfirst($key) . " must have a minimum of 3 character length and can only contain underscore and hyphens";
                    }
                    break;
                case ("email"):
                    if (!preg_match("/^([a-zA-Z]+[\w.]+@[a-zA-Z]+\.[a-zA-Z]{2,})$/", $this->data[$key])) {
                        $error[$key] = "Kindly Input a valid " . $key;
                    }
                    break;
                case ("middlename"):
                    if (!preg_match("/^[a-zA-Z_-]*$/", $this->data[$key])) {
                        $error[$key] = ucfirst($key) . " can't contain numbers and spaces and is optional";
                    }
                    break;
                case ("password"):
                    if (!preg_match("/^.{6,}$/", $this->data[$key])) {
                        $error[$key] = ucfirst($key) . " must have a minimum of 6 character length";
                    }
                    break;
                case ("confirm_password"):
                    $value = ucwords(implode(" ", explode("_", $key)));
                    if (!preg_match("/^.{6,}$/", $this->data[$key])) {
                        $error[$key] = $value . " must have a minimum of 6 character length";
                    } else if ($this->data[$key] !== $this->data["password"]) {
                        $error[$key] = $value . " must be the same with the Password field";
                    }
                    break;
                case ("organization_name"):
                    $value = ucwords(implode(" ", explode("_", $key)));
                    if (!preg_match("/^([^\d]){3,}$/", $this->data[$key])) {
                        $error[$key] = $value . " must have a minimum of 3 character and cant't contains numbers";
                    } else if ((new Organizations)->count([
                        "organization_name" => $this->data[$key]
                    ]) > 0) {
                        $error[$key] = $value . " already exists";
                    }
                    break;
                case ("election_name"):
                    $value = ucwords(implode(" ", explode("_", $key)));
                    if (!preg_match("/^([A-Za-z]+[\w\- ]*)$/", $this->data[$key])) {
                        $error[$key] = $value . " can't start start with a number and can contain whitespace, underscore(_) and hyphen(-)";
                    }
                    break;
                case ("election_start_date"):
                    $value = ucwords(implode(" ", explode("_", $key)));
                    if (empty($this->data[$key])) {
                        $error[$key] = $value . " is required";
                    } else if (
                        $this->register &&
                        $this->data[$key] <= (new DateTime())->format("Y-m-d")
                    ) {
                        $error[$key] = $value . " must be greater than today";
                    }
                    break;
                case ("election_end_date"):
                    $value = ucwords(implode(" ", explode("_", $key)));
                    if (empty($this->data[$key])) {
                        $error[$key] = $value . " is required";
                    } else if (
                        $this->register &&
                        $this->data[$key] <= (new DateTime())->format("Y-m-d")
                    ) {
                        $error[$key] = $value . " must be greater than today";
                    } else if ($this->data[$key] < $this->data["election_start_date"]) {
                        $error[$key] = $value . " is less than Election Start Date";
                    }
                    break;
            }
        }
        return $error;
    }
}