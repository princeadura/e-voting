<!DOCTYPE html>
<?php
$page = "position";
require_once __DIR__ . '/./../src/request.php';
require_once __DIR__ . '/./includes/head.php';
require_once __DIR__ . '/./includes/election_list.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Positions for Available Elections</title>
    <?php require_once __DIR__ . '/.././includes/style.php'; ?>
</head>

<body>
    <?php require_once __DIR__ . '/./includes/header.php'; ?>
    <?php require_once __DIR__ . '/./includes/sidebar.php'; ?>
    <?php if (isset($admin["organization"])) { ?>
        <?php if (isset($_GET["election_id"]) && count($_GET) == 1) { ?>
            <?php require_once __DIR__ . '/./includes/position_list.php'; ?>
        <?php } else { ?>
            <?php listElection("positions.php?", "available positions") ?>
        <?php } ?>
    <?php } else { ?>
        <?php require_once __DIR__ . '/./includes/register_organization.php'; ?>
    <?php } ?>
    <?php require_once __DIR__ . '/./includes/footer.php'; ?>
    <?php require_once __DIR__ . '/.././includes/script.php'; ?>
    <script src="/assets/scripts/add.js" type="module"></script>
    <script src="/assets/scripts/list.js"></script>
    <script src="/assets/scripts/position.js" type="module"></script>
</body>

</html>