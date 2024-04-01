<!DOCTYPE html>
<?php
$page = "election";
require_once __DIR__ . '/./../src/request.php';
require_once __DIR__ . '/./includes/head.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elections</title>
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
                    Elections
                </h4>
                <div class="top-action">
                    <button class="my-btn-primary" data-bs-toggle="modal" data-bs-target="#addElection">
                        <i class="fas fa-plus-circle" aria-hidden="true"></i>
                        Add
                    </button>
                </div>
            </div>
            <table class="table table-striped table-hover" id="memberList">
                <thead class="">
                    <tr>
                        <th>S/n</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="">
                    <?php foreach ($elections as $key => $election) { ?>
                    <tr>
                        <td class="sn"><?= ++$key ?></td>
                        <td><?= $election["election_name"] ?></td>
                        <td><?= $election["election_status"] ?></td>
                        <td><?= (new DateTime($election["election_start_date"]))->format("F jS, Y") ?></td>
                        <td><?= (new DateTime($election["election_end_date"]))->format("F jS, Y") ?></td>
                        <td class="action">
                            <div>
                                <button class="btn btn-sm btn-success" onclick="editElection(this)" data-id="<?= $election["election_id"] ?>">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                    <span class="tip">Edit</span>
                                </button>

                                <a class="btn btn-sm my-btn-secondary" href="/admin/election_result.php?election_id=<?= $election["election_id"] ?>">
                                    <i class="fa fa-binoculars" aria-hidden="true"></i>
                                    <span class="tip">View</span>
                                </a>

                                <?php if (strtolower($election["election_status"]) == "pending") { ?>
                                <button class="btn btn-sm btn-danger" data-id="<?= $election["election_id"] ?>" onclick="deleteElection(this)">
                                    <i class="fa fa-trash-can" aria-hidden="true"></i>
                                    <span class="tip">Delete</span>
                                </button>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>


        <div class="modal fade" id="addElection" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Add Election</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="modal-body modal-form" method="POST" id="addElectionForm">
                        <div class="fields">
                            <?php foreach ($electionFields as $field) { ?>
                            <div class="field">
                                <div class="floating_form">
                                    <input type="<?= $field["type"] ?>" id="<?= $field["name"] ?>" name="<?= $field["name"] ?>" class="form-control" placeholder="a">
                                    <label for="<?= $field["name"] ?>" class="floating_label">
                                        <?= $field["label"] ?>
                                    </label>
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

        <div class="modal fade" id="editElection" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Edit Election</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="modal-body modal-form" method="POST" id="editElectionForm">
                        <div class="fields">
                            <?php foreach ($electionFields as $field) { ?>
                            <div class="field">
                                <div class="floating_form">
                                    <input type="<?= $field["type"] ?>" id="<?= $field["name"] ?>" name="<?= $field["name"] ?>" class="form-control" placeholder="a">
                                    <label for="<?= $field["name"] ?>" class="floating_label">
                                        <?= $field["label"] ?>
                                    </label>
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

        <div class="modal fade" id="deleteElection" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Delete Election</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-form">
                        <h5 class="message">
                        </h5>
                        <button type="button" class="btn btn-sm btn-danger delete">
                            <i class="fa fa-trash-can" aria-hidden="true"></i>
                            Delete
                        </button>
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
    <script src="/assets/scripts/election.js" type="module"></script>

</body>

</html>