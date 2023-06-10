<div class="election_list_wrapper">
    <?php $elections = array_values(array_filter($elections, fn ($election) => $election["election_status"] != "Pending")) ?>
    <?php if (count($elections) > 0) { ?>
    <h6 class="text-center">
        Below are the list of Completed Election Setup by your organization kindly click on them to view result
    </h6>
    <ul class="election_list m-0">
        <?php foreach ($elections as $key => $election) { ?>
        <li class="election_item_wrapper">
            <?php if (strtolower($election["election_status"]) == "completed") { ?>
            <span class="my-badge">C</span>
            <?php } ?>
            <a href="#" class="election_item">
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
    <p class="text-center text-danger">No Completed or Ongoing Elections Yet</p>
    <?php }  ?>
</div>