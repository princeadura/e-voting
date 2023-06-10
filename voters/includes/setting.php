<?php
$personal = array_filter((new Content)->registerFields(),
    fn ($el) => in_array($el["name"], ["firstname", "lastname", "middlename"])
);

$reset = (new Content)->passwordReset();
$resetPin = (new Content)->resetPin();
?>
<section class="settings">
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
                    <li class="list">
                        <button class="setting-toggle">
                            <i class="fas fa-user-lock" aria-hidden="true"></i>
                            <span>Reset Password</span>
                        </button>
                    </li>
                    <li class="list">
                        <button class="setting-toggle">
                            <i class="fas fa-key" aria-hidden="true"></i>
                            <span>Reset Pin</span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="my-card-body">

                <form action="" class="settings-form active" id="voterPersonal" method="POST">
                    <input type="text" name="voter_id" value="<?= $voter["voter_id"] ?>" hidden>
                    <?php foreach ($personal as $field) { ?>
                        <div class="field">
                            <div class="floating_form">
                                <input type="<?= $field["type"] ?>" id="<?= $field["name"] ?>" name="<?= $field["name"] ?>" class="form-control" placeholder="a" value="<?= $_POST[$field["name"]] ?? $voter[$field["name"]] ?>">
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

                <form action="" class="settings-form" id="voterPasswordReset">
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

                <form action="" class="settings-form" id="voterPinReset">
                    <?php foreach ($resetPin as $field) { ?>
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
    </section>
</section>