<?php
$electionId = filter_var($_GET["election_id"], FILTER_SANITIZE_SPECIAL_CHARS);
$position = filter_var($_GET["position"], FILTER_SANITIZE_SPECIAL_CHARS);
$searchedElection = $election($electionId)[0];
if ($searchedElection["organization"] !==  $admin["organization"]) {
    redirect("/admin/candidate_list.php");
}
$positions = (new Positions)->fetchAll(["election" => $searchedElection["election_id"]]);
$positions = (count($positions) > 0) ? json_decode($positions[0]["position"]) : [];

$status = $searchedElection["election_status"];

$candidates = (new Candidates)->fetchAll(["election" => $searchedElection["election_id"]]);
$allCandidates = (count($candidates) > 0) ?
    array_values((array) json_decode($candidates[0]["candidate"])) :
    [];
$backupVoters = $voters;
foreach ($allCandidates as $key => $item) {
    foreach ($item as $inneritem) {
        $element = (array) $inneritem;
        $voters = array_filter($voters, function ($voter) {
            global $element;
            return $element["voter_id"] != $voter["voter_id"];
        });
    }
}
$candidates = (count($candidates) > 0) ?
    array_values(array_filter(
        (array) json_decode($candidates[0]["candidate"]),
        function ($cand) {
            global $position;
            return $position == $cand;
        },
        ARRAY_FILTER_USE_KEY
    )) : [];
$candidatesId = [];
$candidateImages = [];
foreach ($candidates as $item) {
    foreach ($item as $inneritem) {
        $element = (array) $inneritem;
        array_push($candidatesId, $element["voter_id"]);
        array_push($candidateImages, $element["img"]);
    }
}
$candidates = array_values(array_filter($backupVoters, function ($voter) {
    global $candidatesId;
    return in_array($voter["voter_id"], $candidatesId);
}));
foreach ($candidateImages as $key => $value) {
    $candidates[$key]["img"] = $value;
}

if (!in_array($position, $positions)) {
    redirect("/admin/candidate_list.php");
}
?>
<!-- Modal -->
<div class="modal fade" id="addCandidateErrorModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="container-fluid">


                </div>
            </div>

        </div>
    </div>
</div>
<?php if (isset($_GET["action"]) && $_GET["action"] === "add" && strtolower($status) == "pending") { ?>
    <main class="add-candidate">
        <form action="" method="POST" id="addCandidateForm" data-position="<?= $position ?>" data-election-id="<?= $electionId ?>">

            <section class="head">
                <div class="left">
                    <a href="/admin/candidate_list.php?election_id=<?= $electionId ?>&position=<?= $position ?>" class="my-btn-primary">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                        <span> Back</span>
                    </a>
                    <h5 class="m-0">Add Candidates</h5>
                    <p class="m-0 count text-secondary">
                        <span class="selected">0</span>/<span><?= count($voters) ?></span>
                    </p>
                </div>
                <div class="search">
                    <input type="search" name="" id="searchCandidate" placeholder="Search by Name" class="form-control">
                    <i class="fas fa-magnifying-glass icon"></i>
                </div>
            </section>
            <section class="add-candidate-body">
                <?php foreach ($voters as $key => $voter) { ?>
                    <div class="candidate_select_wrapper">
                        <input type="checkbox" name="candidate_id<?= " " . $voter["voter_id"] ?>" id="<?= $voter["voter_id"] ?>" value="<?= $voter["voter_id"] ?>" class="candidate_select">
                        <label for="<?= $voter["voter_id"] ?>" class="detail-wrapper">
                            <div class="mark">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="candidate_image_wrapper">
                                <img src="/assets/images/candidate_images/default.png" class="candidate_image" alt="">
                                <p class="text m-0">
                                    Click me to Select
                                </p>
                            </div>
                            <div class="candidate_details">
                                <p class="m-1 name">
                                    <b><i>Name:</i></b>
                                    <span>
                                        <?= $voter["firstname"] ?> <?= $voter["lastname"] ?>
                                    </span>
                                </p>
                                <p class="m-0">
                                    <b><i>Email:</i></b>
                                    <span><?= $voter["email"] ?></span>
                                </p>
                            </div>
                        </label>
                    </div>
                <?php } ?>
            </section>

            <?php if (strtolower($status) == "pending") { ?>
                <button type="submit" class="my-btn-primary" name="addCandidate">
                    Add <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
            <?php } ?>
        </form>
    </main>
<?php } else { ?>
    <main class="add-candidate">
        <form action="" method="POST" id="listCandidateForm" data-position="<?= $position ?>" data-election-id="<?= $electionId ?>">
            <section class="head">
                <div class="left">
                    <a href="/admin/candidate_list.php?election_id=<?= $electionId ?>" class="my-btn-primary">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                        <span> Back</span>
                    </a>
                    <h5 class="m-0"><?= $position ?> Position Candidate(s)</h5>

                    <?php if (strtolower($status) == "pending") { ?>
                        <a class="link-primary" href="/admin/candidate_list.php?election_id=<?= $electionId ?>&position=<?= $position ?>&action=add">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        </a>
                    <?php } ?>
                </div>
                <div class="search">
                    <input type="search" name="" id="searchCandidate" placeholder="Search by Name" class="form-control">
                    <i class="fas fa-magnifying-glass icon"></i>
                </div>
            </section>
            <section class="add-candidate-body">
                <?php if (count($candidates) > 0) { ?>
                    <?php foreach ($candidates as $key => $candidate) { ?>
                        <?php $image = $candidate["img"] !== "" ? $candidate["img"] : "default.png"; ?>
                        <div class="candidate_select_wrapper">

                            <?php if (strtolower($status) == "pending") { ?>
                                <input type="file" name="candidate_id<?= " " . $candidate["voter_id"] ?>" id="<?= $candidate["voter_id"] ?>_view" data-voter-id="<?= $candidate["voter_id"] ?>" class="candidate_image_input">

                                <button class="btn btn-danger" type="button" data-remove-candidate="<?= $candidate["voter_id"] ?>" data-position="<?= $position ?>" data-election="<?= $electionId ?>">
                                    <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                </button>
                            <?php } ?>
                            <label for="<?= $candidate["voter_id"] ?>_view" class="detail-wrapper">
                                <div class="mark">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="candidate_image_wrapper">
                                    <img src="/assets/images/candidate_images/<?= $image ?>" class="candidate_image" alt="">

                                    <?php if (strtolower($status) == "pending") { ?>
                                        <p class="text m-0">
                                            Click me to set candidate Image
                                        </p>
                                    <?php } ?>
                                </div>
                                <div class="candidate_details">
                                    <p class="m-1 name">
                                        <b><i>Name:</i></b>
                                        <span>
                                            <?= $candidate["firstname"] ?> <?= $candidate["lastname"] ?>
                                        </span>
                                    </p>
                                    <p class="m-0">
                                        <b><i>Email:</i></b>
                                        <span><?= $candidate["email"] ?></span>
                                    </p>
                                </div>
                            </label>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <h6 class="text-danger">
                        No Candidate Available yet for this Position
                    </h6>
                <?php } ?>
            </section>
        </form>
    </main>
<?php } ?>