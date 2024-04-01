<?php
function listElection($path, $text)
{
    global $elections;
?>
<?php if (count($elections) > 0) { ?>
<main class="election_list_wrapper">
    <p class="election_list_title m-0">
        Click on each election below to access their <?= $text ?>.
    </p>
    <ul class="election_list m-0">
        <?php foreach ($elections as $key => $election) { ?>
        <li class="election_item_wrapper">
            <a href="/admin/<?= $path ?>election_id=<?= $election["election_id"] ?>" class="election_item">
                <span class="number">
                    <?= ++$key ?>
                </span>
                <span class="name">
                    <?= $election["election_name"] ?>
                </span>
            </a>
        </li>
        <?php } ?>
    </ul>
</main>
<?php } else { ?>
<main class="p-3">
    <h5 class="text-center text-danger">Elections Not Avalable yet</h5>
</main>
<?php } ?>
<?php } ?>