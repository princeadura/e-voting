<!DOCTYPE html>
<?php
require_once __DIR__ . '/./src/request.php';
if (isset($_SESSION["admin"])) header("location: /admin");
$register = true;
$group = "landing";
$form = (new Content)->loginFields();
$register = (new Content)->registerFields();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <?php require_once __DIR__ . '/./includes/style.php'; ?>
</head>

<body>
    <main class="register">

        <div class="register-group">
            <a href="/" class="my-btn-primary"> <i class="fa fa-home" aria-hidden="true"></i> Home</a>

            <!-- Admin Login Form  -->
            <form action="" method="POST" class="adiministratorLogin" id="adiministratorLogin">
                <h3 class="form-title"> Administrator's Login </h3>
                <div class="fields">
                    <?php foreach ($form as $field) { ?>
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
                </div>

                <div class="bottom">
                    <a href="#" class="link-primary"> forget password ??</a>
                    <button type="submit" name="adminlogin" class="my-btn-primary">Login <i class="fas fa-door-open"></i></button>
                </div>

                <p class="dont m-0"> Don't have an account?? <button type="button" class="link-primary" data-bs-toggle="modal" data-bs-target="#administratorRegisterForm">Register here</button> </p>

            </form>
            <!-- Admin Login Form  -->

            <button type="button" class="my-btn-secondary outline-secondary" data-bs-toggle="modal" data-bs-target="#become-an-administrator">
                Who is an Administrator
            </button>
        </div>

        <div class="img-holder">
            <img src="/assets/images/login.svg" alt="">
        </div>

        <!-- Admin Register form modal -->
        <div class="modal fade" id="administratorRegisterForm" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalTitleId">Administrator's Registration</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" class="administratorRegister" id="administratorRegister">
                            <div class="fields">
                                <?php foreach ($register as $field) { ?>
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
                            </div>
                            <button type="submit" name="adminregister" class="my-btn-primary w-100 my-3">Register</button>

                            <p class="dont m-0"> Already have an account?? <button type="button" class="link-primary" data-bs-toggle="modal" data-bs-target="#administratorRegisterForm">Login here</button> </p>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Admin Register form modal -->

        <?php require_once __DIR__ . '/./includes/administartorModal.php'; ?>
    </main>
    <?php require_once __DIR__ . '/./includes/script.php'; ?>
    <script src="/assets/scripts/administratorRegister.js" type="module"></script>
</body>

</html>