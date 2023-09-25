<?php
$electionId = filter_var($_GET["election_id"], FILTER_SANITIZE_SPECIAL_CHARS);
$searchedElection = $election($electionId)[0];
if ($searchedElection["organization"] !==  $admin["organization"]) {
    redirect("/admin/candidate_list.php");
}
$positions = (new Positions)->fetchAll(["election" => $searchedElection["election_id"]]);
$positions = (count($positions) > 0) ? json_decode($positions[0]["position"]) : [];
$candidateDetails = (new Candidates())->fetchAll(["election" => $electionId]);
$candidateDetails = (count($candidateDetails) > 0) ?  json_decode($candidateDetails[0]["candidate"]) : [];

?>

<main class="position_list">
    <ul class="list-group">
        <div class="wrap">
            <a href="/admin/candidate_list.php" class="btn my-btn-primary back">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
                back
            </a>
            <h4 class="total-candidate text-secondary m-0"> <b>Total:</b> <span>0</span></h4>
        </div>

        <?php if (count($positions) > 0) { ?>
            <p class="text-secondary">Click on each position to have the opportunity of adding candidates for the clicked position</p>
            <?php foreach ($positions as $key => $position) { ?>
                <?php $number = (isset($candidateDetails->$position)) ? count($candidateDetails->$position) : 0 ?>
                <a class="list-group-item d-flex justify-content-between align-items-center" href="candidate_list.php?election_id=<?= $electionId ?>&position=<?= $position ?>">
                    <span> <?= $position ?> </span>
                    <span class="badge bg-danger badge-pill individual-candidate">
                        <?= $number ?>
                    </span>
                </a>
            <?php } ?>
        <?php } else { ?>
            <p class="text-danger text-center"> No Position Registered yet for this election </p>
        <?php } ?>
    </ul>
</main>