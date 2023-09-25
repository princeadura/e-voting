<?php
$electionId = filter_var($_GET["election_id"], FILTER_SANITIZE_SPECIAL_CHARS);
$searchedElection = $election($electionId)[0];
if ($searchedElection["organization"] !==  $admin["organization"]) {
    redirect("/admin/positions.php");
}
$status = $searchedElection["election_status"];
$positions = (new Positions)->fetchAll(["election" => $searchedElection["election_id"]]);
$positions = (count($positions) > 0) ? json_decode($positions[0]["position"]) : [];

?>
<main class="general-list">
    <a href="/admin/positions.php" class="btn my-btn-primary back">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
        back
    </a>
    <div class="table-responsive member-list">
        <div class="top mb-3">
            <h5 class="title m-0">
                Positions Available in <?= $searchedElection["election_name"] ?>
            </h5>

            <?php if (strtolower($status) == "pending") { ?>
            <div class="top-action">
                <button class="my-btn-primary" data-bs-toggle="modal" data-bs-target="#addPositionModal">
                    <i class="fas fa-plus-circle" aria-hidden="true"></i>
                    Add
                </button>
            </div>
            <?php }?>
        </div>
        <table class="table table-striped table-hover" id="memberList">
            <thead class="">
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="">
                <?php foreach ($positions as $key => $position) { ?>
                <tr>
                    <td class="sn"><?= $key + 1 ?></td>
                    <td><?= $position ?></td>
                    <td class="action">
                        <?php if (strtolower($status) == "pending") { ?>
                        <div>

                            <button class="btn btn-sm btn-success" data-id="<?= $key ?>" data-name="<?= $position ?>" onclick="openEditModal(this)">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                                <span class="tip">Edit</span>
                            </button>

                            <button class="btn btn-sm btn-danger" data-id="<?= $key ?>" data-name="<?= $position ?>" onclick="openDeleteModal(this)">
                                <i class="fa fa-trash-can" aria-hidden="true"></i>
                                <span class="tip">Delete</span>
                            </button>
                        </div>
                        <?php } else { ?>
                        <p class="m-0 text-info">No Action</p>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="addPositionModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Add Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body modal-form" method="POST" id="addPositionForm" data-id="<?= $electionId ?>">
                    <div class="fields">
                        <div class="field">
                            <div class="floating_form">
                                <input type="text" id="position" name="position" class="form-control" placeholder="a">
                                <label for="position" class="floating_label">
                                    Position
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="addPosition" class="my-btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Add
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="editPositionModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Edit Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body modal-form" method="POST" id="editPositionForm" data-id="<?= $electionId ?>">
                    <div class="fields">
                        <div class="field">
                            <div class="floating_form">
                                <input type="text" id="position" name="position" class="form-control" placeholder="a">
                                <label for="position" class="floating_label">
                                    Position
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="addPosition" class="my-btn-primary">
                        <i class="fas fa-edit" aria-hidden="true"></i>
                        Edit
                    </button>
                </form>

            </div>
        </div>
    </div>


    <div class="modal fade" id="deletePositionModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Delete Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <h5 class="mb-3">
                        Are you sure you want to delete
                        <span class="position"></span>'s position ??
                    </h5>
                    <button type="button" class="btn btn-danger btn-sm align-self-end delete" data-id="<?= $electionId ?>">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

</main>