<!DOCTYPE html>
<?php
$page = "position";
require_once __DIR__ . '/./../src/request.php';
require_once __DIR__ . '/./includes/head.php';
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
    <?php if (isset($_GET["election_id"]) && count($_GET) == 1) { ?>
        <?php require_once __DIR__ . '/./includes/position_list.php'; ?>
    <?php } else { ?>
        <?php if (isset($admin["organization"])) { ?>
            <?php if (count($elections) > 0) { ?>
                <main class="election_list_wrapper">
                    <p class="election_list_title m-0">
                        Click on each election below to access their available positions.
                    </p>
                    <ul class="election_list m-0">
                        <?php foreach ($elections as $key => $election) { ?>
                            <li class="election_item_wrapper">
                                <a href="/admin/positions.php?election_id=<?= $election["election_id"] ?>" class="election_item">
                                    <span class="number">
                                        <?= ++$key ?>
                                    </span>
                                    <span class="name">
                                        <?= $election["election_name"] ?>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </main>
            <?php } else { ?>
                <main class="p-3">
                    <h5 class="text-center text-danger">Elections Not Avalable yet</h5>
                </main>
            <?php } ?>
        <?php } else { ?>
            <?php require_once __DIR__ . '/./includes/register_organization.php'; ?>
        <?php } ?>
    <?php } ?>
    <?php require_once __DIR__ . '/./includes/footer.php'; ?>
    <?php require_once __DIR__ . '/.././includes/script.php'; ?>
    <script src="/assets/scripts/add.js" type="module"></script>
    <script src="/assets/scripts/list.js"></script>
    <script src="/assets/scripts/position.js" type="module"></script>
</body>

</html>