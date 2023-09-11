<div class="election_list_wrapper">
    <h5 class="text-center"> Dear <b><?= $voter["firstname"] . " " . $voter["lastname"] ?> </b> Welcome to <b><?= $organization["organization_name"] ?></b> Voters page </h5>
    <?php $elections = array_values(array_filter($elections, fn ($election) => $election["election_status"] == "Ongoing")) ?>
    <?php if (count($elections) > 0) { ?>
        <h6 class="text-center">
            Below are the list of Ongoing Election Setup by your organization kindly click on them to start voting
        </h6>
        <ul class="election_list m-0">
            <?php foreach ($elections as $key => $election) { ?>
                <li class="election_item_wrapper">
                    <a href="/voters/vote.php?election=<?= $election['election_id'] ?>" class="election_item">
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
    <?php } else { ?>
        <p class="text-center text-danger">No Ongoing Elections Yet</p>
    <?php }  ?>
</div>