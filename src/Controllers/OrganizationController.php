<?php
class OrganizationController
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

    public function addOrganization()
    {
        $validate = (new Auth($this->fields, new Organizations()))->validation();
        if (count($validate) > 0) {
            $res = ["message" => $validate, "status" => "error"];
            echo json_encode($res);
            return;
        }
        $admin = array_filter((new Admins)->fetchAll([
            "username" => $_SESSION["admin"]
        ]))[0];

        list($admin_id, $organization) =   array_values(
            array_filter(
                $admin,
                fn ($details) => in_array($details, ["admin_id", "organization"]),
                ARRAY_FILTER_USE_KEY
            )
        );

        $action = (!empty($organization)) ?
            (new Organizations)->update($this->fields, [
                "organization_id" => $organization
            ])
            : (new Organizations)->insert([
                "organization_name" => $this->fields["organization_name"],
                "head" => $admin_id
            ]);

        if ($action) {
            echo json_encode(["message" => "Details Sucessfully Updated", "status" => "success"]);
        } else {
            echo json_encode(["message" => "An Error Occured", "status" => "error"]);
        }
    }
}
