<!DOCTYPE html>
<?php
$page = "candidate";
require_once __DIR__ . '/./../src/request.php';
require_once __DIR__ . '/./includes/head.php';
require_once __DIR__ . '/./includes/election_list.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Add Candidate </title>
    <?php require_once __DIR__ . '/.././includes/style.php'; ?>
</head>

<body>
    <?php require_once __DIR__ . '/./includes/header.php'; ?>
    <?php require_once __DIR__ . '/./includes/sidebar.php'; ?>
    <?php if (isset($admin["organization"])) { ?>
        <?php if (isset($_GET["election_id"]) && count($_GET) == 1) { ?>
            <?php require_once __DIR__ . '/./includes/add_list_election.php'; ?>
        <?php } else if (
            isset($_GET["election_id"]) &&
            isset($_GET["position"])
        ) { ?>
            <?php require_once __DIR__ . '/./includes/list_candidate.php'; ?>
        <?php } else { ?>
            <?php listElection("candidate_list.php?") ?>
        <?php } ?>
    <?php } else { ?>
        <?php require_once __DIR__ . '/./includes/register_organization.php'; ?>
    <?php } ?>
    <?php require_once __DIR__ . '/./includes/footer.php'; ?>
    <?php require_once __DIR__ . '/.././includes/script.php'; ?>
    <script src="/assets/scripts/addCandidate.js" type="module"></script>
</body>

</html>