<?php
if (!isset($_SESSION["admin"])) {
    header("Location: /register.php");
}


$admin = (new AdminController(["username" => $_SESSION["admin"]]))->getLoggedInAdmin()[0];
$abbr = str_split($admin["firstname"])[0] . str_split($admin["lastname"])[0];

$_SESSION["admin_id"] = $admin["admin_id"];

$group = "admin";


$adminRegister = array_filter(
    (new Content)->registerFields(),
    fn ($field) => in_array($field["name"], ["firstname", "lastname", "middlename", "email"])
);

$personal = array_filter((new Content)->registerFields(),
    fn ($el) => in_array($el["name"], ["firstname", "lastname", "middlename"])
);

$reset = (new Content)->passwordReset();


$electionFields = (new Content)->electionFields();


if (isset($admin["organization"])) {
    $organization =  (new OrganizationController(["organization_id" => $admin["organization"]]))->getOrganization();

    $organization = count($organization) <= 0 ? NULL : $organization[0];

    $administrators = array_values(array_filter(
        AdminController::getAllAdministrator([
            "organization" => $admin["organization"]
        ]),
        fn ($administrator) => $administrator["role"] != "head"
    ));

    $voters = VoterController::getAllVoters([
        "organization" => $admin["organization"]
    ]);

    $organizationName = gettype($organization) == "NULL" ? "" : $organization["organization_name"];

    $elections = (new ElectionController([
        'organization' => $admin["organization"]
    ]))->getAllElections();

    $election = function ($electionId) {
        return (new ElectionController([
            'election_id' => $electionId
        ]))->getAllElections();
    };
}


// print_r($elections);