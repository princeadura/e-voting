<?php
session_start();
ob_start();
// error_reporting(0);
require_once __DIR__ . '/./library/Content.php';
require_once __DIR__ . '/./library/Auth.php';
require_once __DIR__ . '/./library/Upload.php';
require_once __DIR__ . '/./library/functions.php';
require_once __DIR__ . '/./Models/autoload.php';
require_once __DIR__ . '/./Controllers/autoload.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fields = array_map(
        fn ($post) => filter_var($post, FILTER_SANITIZE_SPECIAL_CHARS),
        $_POST
    );
    if (isset($fields["adminlogin"])) {
        array_pop($fields);
        (new AdminController($fields))->login();
    } else if (isset($fields["adminregister"])) {
        array_pop($fields);
        (new AdminController($fields))->register();
    } else if (isset($fields["updateAdminDetail"])) {
        array_pop($fields);
        (new AdminController($fields))->update();
    } else if (isset($fields["editAdmin"])) {
        array_pop($fields);
        (new AdminController($fields))->updateAdmin();
    } else if (isset($fields["addOrganization"])) {
        array_pop($fields);
        (new OrganizationController($fields))->addOrganization();
    } else if (isset($fields["resetAdminPassword"])) {
        array_pop($fields);
        (new AdminController($fields))->resetPassword();
    } else if (isset($fields["addAdmin"])) {
        array_pop($fields);
        (new AdminController($fields))->register(true);
    } else if (isset($fields["addMultipleAdmin"])) {
        (new AdminController($fields))->registerMultipleAdmin();
    } else if (isset($fields["deleteAdmin"])) {
        array_pop($fields);
        (new AdminController($fields))->deleteAdmin();
    } else if (isset($fields["getAdmin"])) {
        array_pop($fields);
        echo json_encode(
            array_values(array_filter(
                AdminController::getAllAdministrator($fields),
                fn ($administrator) => $administrator["role"] != "head"
            ))
        );
    } else if (isset($fields["getElection"])) {
        array_pop($fields);
        echo json_encode(
            (new ElectionController([
                'organization' => $fields["organization"]
            ]))->getAllElections()
        );
    } else if (isset($fields["addElection"])) {
        array_pop($fields);
        (new ElectionController($fields))->addElection();
    } else if (isset($fields["editElection"])) {
        array_pop($fields);
        (new ElectionController($fields))->update();
    } else if (isset($_POST["deleteElection"])) {
        array_pop($fields);
        (new ElectionController($fields))->deleteElection();
    } else if (isset($_POST["addPosition"])) {
        array_pop($fields);
        (new PositionController($fields))->addPosition();
    } else if (isset($_POST["editPosition"])) {
        array_pop($fields);
        (new PositionController($fields))->editPosition();
    } else if (isset($_POST["deletePosition"])) {
        array_pop($fields);
        (new PositionController($fields))->deletePosition();
    } else if (isset($_POST["addUser"])) {
        array_pop($fields);
        (new VoterController($fields))->register();
    } else if (isset($fields["addMultipleUser"])) {
        (new VoterController($fields))->registerMultipleUser();
    } else if (isset($fields["getVoter"])) {
        array_pop($fields);
        echo json_encode(VoterController::getAllVoters($fields));
    } else if (isset($fields["editUser"])) {
        array_pop($fields);
        (new VoterController($fields))->update();
    } else if (isset($fields["deleteUser"])) {
        array_pop($fields);
        (new VoterController($fields))->delete();
    } else if (isset($fields["voterlogin"])) {
        array_pop($fields);
        (new VoterController($fields))->login();
    } else if (isset($fields["resetVoterPassword"])) {
        array_pop($fields);
        (new VoterController($fields))->resetPassword();
    } else if (isset($fields["resetVoterPin"])) {
        array_pop($fields);
        (new VoterController($fields))->resetPin();
    } else if (isset($fields["addCandidate"])) {
        array_pop($fields);
        (new CandidateController($fields))->addCandidate();
    } else if (isset($fields["updateCandidateImage"])) {
        array_pop($fields);
        (new CandidateController($fields))->setCandidateImage($_FILES["image"]);
    } else if (isset($fields["deleteCandidate"])) {
        array_pop($fields);
        (new CandidateController($fields))->deleteCandidate();
    } else if (isset($fields["vote"])) {
        array_pop($fields);
        // (new)
    }
}
