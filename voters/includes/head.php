<?php
require_once __DIR__ . '/./../../src/request.php';
if (!isset($_SESSION["voter"])) {
    header("Location: /logout.php");
}
$group = "voters";
$page = $_GET["page"] ?? "";
$voter = (new VoterController(["username" => $_SESSION["voter"]]))->getLoggedInVoter()[0];
$abbr = str_split($voter["firstname"])[0] . str_split($voter["lastname"])[0];
$organization =  (new OrganizationController([
    "organization_id" => $voter["organization"]
]))->getOrganization()[0];
$elections = (new ElectionController([
    'organization' => $voter["organization"]
]))->getAllElections();
$election = function ($electionId) {
    return (new ElectionController([
        'election_id' => $electionId
    ]))->getAllElections();
};
