<!DOCTYPE html>
<?php
$page = "result";
require_once __DIR__ . '/./../src/request.php';
require_once __DIR__ . '/./includes/head.php';
require_once __DIR__ . '/./includes/election_list.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elections List</title>
    <?php require_once __DIR__ . '/.././includes/style.php'; ?>
</head>

<body>
    <?php require_once __DIR__ . '/./includes/header.php'; ?>
    <?php require_once __DIR__ . '/./includes/sidebar.php'; ?>
    <?php if (isset($admin["organization"])) { ?>
        <?php if (isset($_GET["election_id"]) && count($_GET) == 1) { ?>
            <?php require_once __DIR__ . '/./includes/election_result_view.php'; ?>
        <?php } else { ?>
            <?php listElection("election_result.php?", "results") ?>
        <?php } ?>
    <?php } else { ?>
        <?php require_once __DIR__ . '/./includes/register_organization.php'; ?>
    <?php } ?>
    <?php require_once __DIR__ . '/./includes/footer.php'; ?>
    <?php require_once __DIR__ . '/.././includes/script.php'; ?>

    <?php if (isset($_GET["election_id"]) && count($_GET) == 1) { ?>
        <script src="http://localhost:100/chart.js"></script>
        <script src="/assets/scripts/result.js"></script>
    <?php } ?>
</body>

</html>