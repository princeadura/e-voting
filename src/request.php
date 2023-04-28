<?php
session_start();
require_once __DIR__ . '/./library/Content.php';
require_once __DIR__ . '/./library/Auth.php';
require_once __DIR__ . '/./library/Upload.php';
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
    }
}
