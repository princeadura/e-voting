<?php
if (!isset($_SESSION["admin"])) {
    header("Location: /register.php");
}

$admin = (new AdminController(["email" => $_SESSION["admin"]]))->getLoggedInAdmin()[0];
$abbr = str_split($admin["firstname"])[0] . str_split($admin["lastname"])[0];

$_SESSION["admin_id"] = $admin["admin_id"];

$organization =  (new OrganizationController(["organization_id" => $admin["organization"]]))->getOrganization();

$organization = count($organization) <= 0 ? NULL : $organization[0];

$group = "admin";

$administrators = array_values(array_filter(
    AdminController::getAllAdministrator([
        "organization" => $admin["organization"]
    ]),
    fn ($administrator) => $administrator["role"] != "head"
));

$adminRegister = array_filter(
    (new Content)->registerFields(),
    fn ($field) => in_array($field["name"], ["firstname", "lastname", "middlename", "email"])
);

$personal = array_filter((new Content)->registerFields(), fn ($el) => in_array($el["name"], ["firstname", "lastname", "middlename"]));

$reset = (new Content)->passwordReset();

$organizationName = gettype($organization) == "NULL" ? "" : $organization["organization_name"];

$electionFields = (new Content)->electionFields();

$elections = (new ElectionController([
    'organization' => $admin["organization"]
]))->getAllElections();
// print_r($elections);