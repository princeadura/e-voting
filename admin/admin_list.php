<!DOCTYPE html>
<?php
$page = "admin";
require_once __DIR__ . '/./../src/request.php';
require_once __DIR__ . '/./includes/head.php';
if ($admin["role"] != "head") {
    redirect("/admin");
}

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
    <?php if (isset($admin["organization"])) { ?>
        <main class="general-list" data-organization="<?= $admin["organization"] ?>">
            <div class="table-responsive member-list">
                <div class="top mb-3">
                    <h4 class="title m-0">
                        Admin List
                    </h4>
                    <div class="top-action">
                        <button class="my-btn-primary" data-bs-toggle="modal" data-bs-target="#addAdmin">
                            <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            single
                        </button>
                        <button type="button" class=" my-btn-primary" data-bs-toggle="modal" data-bs-target="#multipleAdd">
                            <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            multiple
                        </button>
                    </div>
                </div>
                <table class="table table-striped table-hover" id="memberList">
                    <thead class="">
                        <tr>
                            <th>S/n</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($administrators as $key => $administrator) { ?>
                            <tr>
                                <td class="sn"><?= ++$key ?></td>
                                <td><?= $administrator["firstname"] ?></td>
                                <td><?= $administrator["lastname"] ?></td>
                                <td><?= $administrator["middlename"] ?></td>
                                <td><?= $administrator["email"] ?></td>
                                <td><?= $administrator["status"] ?></td>
                                <td class="action">
                                    <div>
                                        <button class="btn btn-sm btn-success" onclick="editAdmin(this)" data-email="<?= $administrator["email"] ?>">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                            <span class="tip">Edit</span>
                                        </button>

                                        <?php if ($administrator["status"]  == "r") { ?>
                                            <button class="btn btn-sm btn-secondary" data-email="<?= $administrator["email"] ?>" onclick="disableAdmin(this)">
                                                <i class="fas fa-ban" aria-hidden="true"></i>
                                                <span class="tip">Enable</span>
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-dark" data-email="<?= $administrator["email"] ?>" onclick="disableAdmin(this)">
                                                <i class="fas fa-ban" aria-hidden="true"></i>
                                                <span class="tip">Disable</span>
                                            </button>
                                        <?php } ?>

                                        <button class="btn btn-sm btn-danger" data-email="<?= $administrator["email"] ?>" onclick="deleteAdmin(this)">
                                            <i class="fa fa-trash-can" aria-hidden="true"></i>
                                            <span class="tip">Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


            <div class="modal fade" id="addAdmin" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">Add Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="modal-body modal-form" method="POST" id="addAdminForm">
                            <div class="fields">
                                <?php foreach ($adminRegister as $field) { ?>
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
                            <button type="submit" name="addAdmin" class="my-btn-primary">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editAdmin" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">Edit Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="modal-body modal-form" method="POST" id="editAdminForm">
                            <div class="fields">
                                <?php foreach ($adminEdit as $field) { ?>
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
                            <button type="submit" name="addAdmin" class="my-btn-primary">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                                Edit
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteAdmin" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">Delete Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex flex-column">
                            <h5 class="mb-3">
                                Are you sure you want to delete
                                <span class="user"></span>'s account ??
                            </h5>
                            <button type="button" class="btn btn-danger btn-sm align-self-end delete">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="disableAdmin" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">Disable Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex flex-column">
                            <h5 class="mb-3">
                                Are you sure you want to
                                <span class="act"></span>'s account ??
                            </h5>
                            <button type="button" class="btn  btn-sm align-self-end disable">
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="multipleAdd" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">Add Multiple Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="multi-add" method="POST" enctype="multipart/form-data" id="multi-add">

                                <div class="fields">
                                    <div class="input">
                                        <div class="floating_form">
                                            <input type="file" class="form-control" id="file" name="file">
                                        </div>
                                    </div>
                                    <button type="submit" class="my-btn-primary m-0 btn btn-sm">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        Add
                                    </button>
                                </div>

                                <div class="fields">
                                    <p class="info">
                                        <span class="notice">NB:</span>
                                        you upload a csv file by downloading the template using the button below, and filling the document with details of whom you want to add.
                                    </p>

                                    <a href="/assets/template/template.csv" class="my-btn-primary outline-primary btn btn-sm">
                                        <i class="fa fa-download" aria-hidden="true"></i> template
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <?php } else { ?>
        <?php require_once __DIR__ . '/./includes/register_organization.php'; ?>
    <?php } ?>
    <?php require_once __DIR__ . '/./includes/footer.php'; ?>
    <?php require_once __DIR__ . '/.././includes/script.php'; ?>
    <script src="/assets/scripts/add.js" type="module"></script>
    <script src="/assets/scripts/list.js"></script>
    <script src="/assets/scripts/admin.js" type="module"></script>
</body>

</html>