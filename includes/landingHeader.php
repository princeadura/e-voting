<?php
require_once __DIR__ . "/./../src/request.php";
$form = (new Content)->loginFields();
?>
<header class="landing-header">
    <div class="container">
        <div class="left">
            <div class="logo">
                <a href="/" class="brand" aria-label="icon">
                    <img src="/assets/images/logo.png" alt="" class="img-logo">
                </a>
            </div>
            <button class="hamburger">
                <span class="bar"></span>
            </button>
        </div>
        <div class="right">
            <ul class="links-group">
                <li class="link-list">
                    <a href="/" class="link-primary nav-link-primary <?= $page == "home" ? "active" : "" ?> ">Home</a>
                </li>
                <li class="link-list">
                    <a href="/about.php" class="link-primary nav-link-primary  <?= $page == "about" ? "active" : "" ?> ">About</a>
                </li>
                <li class="link-list">
                    <a href="#" class="link-primary nav-link-primary  <?= $page == "services" ? "active" : "" ?> ">Services</a>
                </li>
                <li class="link-list">
                    <?= setVoterButton() ?>
                </li>
            </ul>
        </div>
    </div>
</header>

<div class="modal fade" id="voterslogin" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleId"> Voter's Login</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="voterslogin" id="voterLogin" method="POST">
                    <div class="fields">
                        <?php foreach ($form as $field) { ?>
                            <div class="field">
                                <?php if ($field["type"] == "password") { ?>
                                    <a href="#" class="link-primary">Forget password??</a>
                                <?php } ?>
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
                    <button type="submit" class="my-btn-primary" name="voterLogin"> Login </button>
                </form>
            </div>
        </div>
    </div>
</div>