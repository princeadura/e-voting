<div class="modal fade administartorModal" id="become-an-administrator" tabindex="-1" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleId">Become an Administrator</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="indent">
                    An Administrator is the one responsible for settling elections, adding candidates and positions for the election and adding voters (employees) as well.
                </p>
                <p>
                    An Administrator is grouped into two(2)
                <ol>
                    <li class="list">Head</li>
                    <li class="list">Regular</li>
                </ol>
                </p>
                <p class="indent">
                    The Roles of the <b>head</b> and the <b>regular</b> are the same, the differences are stated below.
                <ul class="unordered">
                    <li class="list">
                        The head is assumed to be the owner of the organization, and add regular admin as support.
                    </li>
                    <li class="list">
                        The head is the one responsible for adding and deleting other admin.
                    </li>
                </ul>
                <b>NB:</b> Administrators can't partake in the election process.
                </p>
                <p class="indent">
                    The head register an Account, and upon activating his account, he would be priviledge to perform all of the functions he can do as well as adding supporting admin(Regular)
                </p>
                <?php if(!isset($register)){?>
                <a href="/register.php" class="my-btn-secondary outline-secondary"> Register as an Adminstrator </a>
                <?php }?>
            </div>

        </div>
    </div>
</div>