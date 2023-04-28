<!DOCTYPE html>
<?php
$page = "settings";
require_once __DIR__ . '/./../src/request.php';
require_once __DIR__ . '/./includes/head.php';

?>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account Settings</title>
        <?php require_once __DIR__ . '/.././includes/style.php'; ?>
    </head>

    <body>
        <?php require_once __DIR__ . '/./includes/header.php'; ?>
        <?php require_once __DIR__ . '/./includes/sidebar.php'; ?>
        <main class="settings">
            <section class="container-lg">
                <button type="button" class="my-btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#resetemail">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    Reset Email
                </button>
                <section class="my-card">
                    <div class="my-card-header">
                        <ul class="setting-toggles">
                            <li class="list">
                                <button class="setting-toggle active">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span>Personal Information</span>
                                </button>
                            </li>
                            <?php if ($admin["role"] == "head") { ?>
                            <li class="list">
                                <button class="setting-toggle">
                                    <i class="fas fa-users" aria-hidden="true"></i>
                                    <span>Organization</span>
                                </button>
                            </li>
                            <?php } ?>
                            <li class="list">
                                <button class="setting-toggle">
                                    <i class="fas fa-user-lock" aria-hidden="true"></i>
                                    <span>Reset Password</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="my-card-body">

                        <form action="" class="settings-form active" id="personal" method="POST">
                            <?php foreach ($personal as $field) { ?>
                            <div class="field">
                                <div class="floating_form">
                                    <input type="<?= $field["type"] ?>" id="<?= $field["name"] ?>" name="<?= $field["name"] ?>" class="form-control" placeholder="a" value="<?= $_POST[$field["name"]] ?? $admin[$field["name"]] ?>">
                                    <label for="<?= $field["name"] ?>" class="floating_label">
                                        <?= $field["label"] ?>
                                    </label>
                                    <?php if ($field["type"] == "password") { ?>
                                    <span class="show icon">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </span>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                            <button type="submit" class="my-btn-primary" name="updateAdminDetail">
                                Submit
                            </button>
                        </form>

                        <?php if ($admin["role"] == "head") { ?>
                        <form action="" class="settings-form" id="organization" method="POST">
                            <div class="field">
                                <div class="floating_form">
                                    <input type="text" id="organization_name" name="organization_name" class="form-control" placeholder="a" value="<?= $_POST["organization"] ?? $organizationName ?>">
                                    <label for="organization" class="floating_label">Organization</label>
                                </div>
                            </div>
                            <button type="submit" class="my-btn-primary" name="addOrganization">
                                Submit
                            </button>
                        </form>
                        <?php } ?>

                        <form action="" class="settings-form" id="passwordReset">
                            <?php foreach ($reset as $field) { ?>
                            <div class="field">
                                <div class="floating_form">
                                    <input type="<?= $field["type"] ?>" id="<?= $field["name"] ?>" name="<?= $field["name"] ?>" class="form-control" placeholder="a">
                                    <label for="<?= $field["name"] ?>" class="floating_label">
                                        <?= $field["label"] ?>
                                    </label>
                                    <?php if ($field["type"] == "password") { ?>
                                    <span class="show icon">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </span>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                            <button type="submit" class="my-btn-primary">
                                Submit
                            </button>
                        </form>

                    </div>
                </section>

                <div class="modal fade" id="resetemail" tabindex="-1" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitleId">Reset Email</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Body
                            </div>
                        </div>
                    </div>
                </div>

                </script>
            </section>
        </main>
        <?php require_once __DIR__ . '/./includes/footer.php'; ?>
        <?php require_once __DIR__ . '/.././includes/script.php'; ?>
        <script src="/assets/scripts/adminSetting.js" type="module"></script>
    </body>

</html>