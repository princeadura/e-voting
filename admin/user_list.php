<!DOCTYPE html>
<?php
$page = "user-list";
$subgroup = "userlist";
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
    <main class="general-list">
        <div class="table-responsive member-list">
            <div class="top mb-3">
                <h4 class="title m-0">
                    User List
                </h4>
                <div class="top-action">
                    <button class="my-btn-primary">
                        <i class="fas fa-plus-circle" aria-hidden="true"></i>
                        single
                    </button>
                    <a href="#" class=" my-btn-primary">
                        <i class="fas fa-plus-circle" aria-hidden="true"></i>
                        multiple
                    </a>
                </div>
            </div>
            <table class="table table-striped table-hover" id="memberList">
                <thead class="">
                    <tr>
                        <th>Column 1</th>
                        <th>Column 2</th>
                        <th>Column 3</th>
                    </tr>
                </thead>
                <tbody class="">
                    <tr>
                        <td>Column 1</td>
                        <td>Column 2</td>
                        <td>Column 3</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>
    <?php require_once __DIR__ . '/./includes/footer.php'; ?>
    <?php require_once __DIR__ . '/.././includes/script.php'; ?>
</body>

</html>