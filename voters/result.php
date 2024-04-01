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
$back = "/voters?page=result";

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $searchedElection["election_name"] ?> Result</title>
    <?php require_once __DIR__ . '/./../includes/style.php'; ?>
</head>

<body>
    <?php require_once __DIR__ . '/./includes/header.php'; ?>
    <main class="result-page">
        <?php require_once __DIR__ . '/./includes/election_component.php'; ?>
    </main>

    <?php require_once __DIR__ . '/./includes/footer.php'; ?>
    <?php require_once __DIR__ . '/./../includes/script.php'; ?>
    <script src="http://localhost:100/chart.js"></script>
    <script src="/assets/scripts/result.js"></script>
</body>

</html>