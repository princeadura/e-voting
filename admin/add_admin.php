<!DOCTYPE html>
<?php
$page = "admin-list";
$subgroup = "addadmin";
require_once __DIR__ . '/./../src/request.php';
require_once __DIR__ . '/./includes/head.php';

?>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>All Administrator</title>
        <?php require_once __DIR__ . '/.././includes/style.php'; ?>
    </head>

    <body>
        <?php require_once __DIR__ . '/./includes/header.php'; ?>
        <?php require_once __DIR__ . '/./includes/sidebar.php'; ?>
        <main class="add-section">

            <div class="floating_form">
                <input type="email" id="email" class="form-control" placeholder="a">
                <label for="email" class="floating_label">Your Email</label>
            </div>
        </main>
        <?php require_once __DIR__ . '/./includes/footer.php'; ?>
        <?php require_once __DIR__ . '/.././includes/script.php'; ?>
    </body>

</html>