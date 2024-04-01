<aside class="admin-sidebar">
    <div class="top">
        <a href="/admin" class="logo">
            <img src="/assets/images/logo.png" alt="" class="img-logo">
        </a>
        <button type="button" class="close">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
    </div>
    <div class="bottom">
        <ul class="links-lists">
            <li class="link-list">
                <a href="/admin" class="link <?= $page == "dashboard" ? "active" : "" ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="link-list">
                <a href="/admin/elections.php" class="link <?= $page == "election" ? "active" : "" ?>">
                    <i class="fas fa-vote-yea"></i>
                    <span>Elections</span>
                </a>
            </li>
            <li class="link-list">
                <a href="/admin/positions.php" class="link <?= $page == "position" ? "active" : "" ?>">
                    <i class="fas fa-crosshairs"></i>
                    <span>Positions</span>
                </a>
            </li>
            <?php if ($admin["role"] == "head") { ?>
                <li class="link-list">
                    <a href="/admin/admin_list.php" class="link <?= $page == "admin" ? "active" : "" ?>">
                        <i class="fas fa-user-shield"></i>
                        <span>Admin</span>
                    </a>
                </li>
            <?php } ?>
            <li class="link-list">
                <a href="/admin/candidate_list.php" class="link  <?= $page == "candidate" ? "active" : "" ?>">
                    <i class=" fas fa-list"></i>
                    <span>Candidates</span>
                </a>
            </li>
            <li class="link-list">
                <a href="/admin/user_list.php" class="link  <?= $page == "user" ? "active" : "" ?>">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span>Users(Voters)</span>
                </a>
            </li>
            <li class="link-list">
                <a href="/admin/election_result.php" class="link  <?= $page == "result" ? "active" : "" ?>">
                    <i class="fas fa-list-ol" aria-hidden="true"></i>
                    <span>Result(s)</span>
                </a>
            </li>
        </ul>
        <ul class="links-lists">
            <li class="link-list">
                <a href="/admin/settings.php" class="link <?= $page == "settings" ? "active" : "" ?>">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="link-list">
                <button type="button" class="link text-danger" data-bs-toggle="modal" data-bs-target="#logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Signout</span>
                </button>
            </li>
        </ul>
    </div>
</aside>