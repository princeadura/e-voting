<!DOCTYPE html>
<?php
require_once __DIR__ . '/./includes/head.php';
$electionId = filter_var($_GET["election"], FILTER_SANITIZE_SPECIAL_CHARS);
$searchedElection = $election($electionId)[0];
$candidate = (new Candidates)->fetchAll([
    "election" => $searchedElection["election_id"]
]);
$position =  (new Positions)->fetchAll([
    "election" => $searchedElection["election_id"]
]);
if (
    ($searchedElection["organization"] !==  $voter["organization"]) ||
    $searchedElection["election_status"] !== "Ongoing"
) {
    redirect("/voters");
}
$candidates = count($candidate) > 0 ? json_decode(
    $candidate[0]["candidate"],
    JSON_FORCE_OBJECT
) : [];
$positions = count($position) > 0 ? json_decode(
    $position[0]["position"]
) : [];
$registeredCandidate = function ($voter_id) {
    return (new VoterController(["voter_id" => $voter_id]))->getLoggedInVoter()[0];
};

$voted = (new Voted())->fetchAll(["election" => $electionId]);

if ($voted) {
    $votedUsers = json_decode($voted[0]["voters"]);
    $votingUser = $voter["voter_id"];
    if (in_array($votingUser, $votedUsers)) {
        redirect("/voters");
    }
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cast the <?= $searchedElection["election_name"] ?> vote</title>
    <?php require_once __DIR__ . '/./../includes/style.php'; ?>
</head>

<body>

    <?php require_once __DIR__ . '/./includes/header.php'; ?>

    <main class="vote">
        <!-- Confirm Vote Modal -->
        <div class="modal fade" id="confirmVote" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Confirm Votes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-secondary">The following are your selections: </h5>
                        <ul class="list-group list-group-flush selected-candidate">

                        </ul>
                        <button class="btn my-btn-primary" id="checkVote">
                            Confirm <i class="fa fa-check-circle" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal that confirms voting pin -->
        <div class="modal fade" id="checkVotingPin" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Voting Pin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="voting">
                            <div class="alert alert-danger fade show" role="alert">
                                <strong>Note:</strong> Provide your 4 digit voting pin.
                            </div>
                            <div class="floating_form">
                                <input type="password" id="votingPin" name="voting_pin" class="form-control" placeholder="a">
                                <label for="votingPin" class="floating_label">
                                    Voting Pin
                                </label>
                                <span class="show icon">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </span>
                            </div>
                            <button class="btn my-btn-primary mt-3" disabled name="vote">
                                <i class="fas fa-vote-yea"></i> vote
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if (count($position) <= 0) { ?>
        <h4 class="text-danger text-center"> No Record Found for the <b><?= $searchedElection["election_name"] ?> </b> </h4>
        <?php } else { ?>
        <h4 class="vote-title"> Cast Your Vote Now for the <b><?= $searchedElection["election_name"] ?> </b> </h4>
        <form class="positions-wrapper" data-election="<?= $searchedElection["election_id"] ?>">
            <?php foreach ($positions as $position) { ?>
            <?php if (isset($candidates[$position]) && count($candidates[$position]) > 0) { ?>
            <div class="candidate">
                <div class="top">
                    <img src="/assets/images/candidate_images/default.png" alt="" class="candidate-image">
                </div>
                <p class="vote-title"><i><?= $position ?></i></p>
                <select class="form-select form-select-lg select-candidate" name="<?= $position ?>">
                    <option selected value="">Select a Candidate</option>
                    <?php foreach ($candidates[$position] as  $candidate) { ?>
                    <?php $innerCandidate = $registeredCandidate($candidate["voter_id"]); ?>
                    <option value="<?= $innerCandidate["voter_id"] ?>" data-img="<?= $candidate["img"] ?>">
                        <?= $innerCandidate["firstname"] . " " . $innerCandidate["lastname"] ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
            <?php } ?>
            <?php } ?>
        </form>
        <button class="btn my-btn-primary" id="confirmVoteButton" disabled>Vote <i class="fas fa-vote-yea"></i></button>
        <?php } ?>
    </main>

    <?php require_once __DIR__ . '/./includes/footer.php'; ?>
    <?php require_once __DIR__ . '/./../includes/script.php'; ?>
    <script src="/assets/scripts/vote.js" type="module"></script>
</body>

</html>