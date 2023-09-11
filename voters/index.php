<!DOCTYPE html>
<?php
require_once __DIR__ . '/./includes/head.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php require_once __DIR__ . '/./../includes/style.php'; ?>
</head>

<body>

    <?php require_once __DIR__ . '/./includes/header.php'; ?>
    <main class="dashboard">
        <aside>
            <div class="group">
                <a class="my-btn-primary link <?php if ($page == "") echo 'active' ?>" href="/voters"> Vote </a>
                <a class="my-btn-primary link <?php if ($page == "result") echo 'active' ?>"" href=" /voters?page=result"> Results </a>
                <a class="my-btn-primary link <?php if ($page == "settings") echo 'active' ?>"" href=" /voters?page=settings"> Settings </a>
                <button class="my-btn-danger link" href="/logout.php" data-bs-toggle="modal" data-bs-target="#logout">
                    Logout
                </button>
            </div>
        </aside>
        <section class="main">
            <?php if ($page == "settings") { ?>
                <?php require_once __DIR__ . '/./includes/setting.php'; ?>
            <?php } else if ($page == "result") { ?>
                <?php require_once __DIR__ . '/./includes/election_result.php'; ?>
            <?php } else { ?>
                <?php require_once __DIR__ . '/./includes/election_list.php'; ?>
            <?php } ?>

        </section>
        <?php require_once __DIR__ . '/./../includes/logoutModal.php'; ?>
    </main>

    <?php require_once __DIR__ . '/./includes/footer.php'; ?>
    <?php require_once __DIR__ . '/./../includes/script.php'; ?>
    <script src="/assets/scripts/adminSetting.js" type="module"></script>
</body>

</html>