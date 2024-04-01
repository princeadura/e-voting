<?php
$electionId = filter_var($_GET["election_id"], FILTER_SANITIZE_SPECIAL_CHARS);
$searchedElection = $election($electionId)[0];
$status = $searchedElection["election_status"];
if (
    $searchedElection["organization"] !==  $admin["organization"] ||
    strtolower($status) != "ongoing"
) {
    redirect("/admin/election_result.php");
}
$positions = (new Positions)->fetchAll(["election" => $searchedElection["election_id"]]);
$positions = (count($positions) > 0) ? json_decode($positions[0]["position"]) : [];

$back = "/admin/election_result.php"
?>


<main class="result-page">
    <?php require_once __DIR__ . '/./../../voters/includes/election_component.php'; ?>
</main>