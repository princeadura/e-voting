<section class="result-wrapper">

    <a class="btn my-btn-primary back" href="<?= $back ?>">
        <i class="fa fa-angle-left"></i>
        <span>
            back
        </span>
    </a>

    <div class="controls">
        <button type="button" class="btn active" data-action="chart">Chart</button>
        <button type="button" class="btn" data-action="winner">Winner</button>
    </div>


    <div class="display_wrapper" data-election="<?= $electionId  ?>">
        <div class="charts">

            <div class="position">
                <?php foreach ($positions as $key => $position) { ?>
                    <button type="button" class="position_toggle <?= ($key == 0) ? "active" : ""  ?> " data-post="<?= $position ?>">
                        <?= $position ?>
                    </button>
                <?php } ?>
            </div>

            <div class="chart-wrapper">
                <div class="result-head">
                    <h5 class="result-title m-0">Chart Title</h5>
                    <button type="button" class="btn btn-sm reload-chart">
                        <i class="fas fa-retweet"></i>
                    </button>
                </div>
                <div class="chart">

                </div>
            </div>

        </div>

        <div class="table-wrapper">
            <div class="result-head">
                <h4 class="card-title m-0">Election Winners</h4>
                <button type="button" class="btn btn-sm reload-chart">
                    <i class="fas fa-retweet"></i>
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover" id="electionResultTable">
                    <thead class="">
                        <tr>
                            <th>SN</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Position</th>
                            <th>Vote(s)</th>
                        </tr>
                    </thead>
                    <tbody class="">

                    </tbody>
                </table>
            </div>


        </div>
    </div>

</section>