<aside class="admin-sidebar">
    <div class="top">
        <a href="/admin" class="logo">
            <i class="fas fa-box-open"></i>
            <span>E-Voting</span>
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
            <li class="my-dropdown link-list <?= $page == "candidate-list" ? "open" : "" ?>" <?= $page == "candidate-list" ? " style='--height: 100%' " : "" ?>>
                <button class="my-dropdown-toggle link">
                    <span>
                        <i class="fas fa-user-tag"></i>
                        Candidates
                    </span>
                    <i class="fa fa-angle-down icon"></i>
                </button>
                <ul class="links-lists my-dropdown-list">
                    <div class="wrapper">
                        <li class="link-list">
                            <a href="/admin/candidate_list.php" class="link  <?= $subgroup == "candidatelist" ? "active" : "" ?>">
                                <i class=" fas fa-list"></i>
                                <span>Candidates List</span>
                            </a>
                        </li>
                        <li class="link-list">
                            <a href="#" class="link">
                                <i class="fas fa-user-plus"></i>
                                <span>Add Candidate</span>
                            </a>
                        </li>
                    </div>
                </ul>
            </li>
            <li class="my-dropdown link-list <?= $page == "user-list" ? "open" : "" ?>" <?= $page == "user-list" ? " style='--height: 100%' " : "" ?>>
                <button class="my-dropdown-toggle link">
                    <span>
                        <i class="fas fa-user"></i>
                        Users
                    </span>
                    <i class="fa fa-angle-down icon"></i>
                </button>
                <ul class="links-lists my-dropdown-list">
                    <div class="wrapper">
                        <li class="link-list">
                            <a href="/admin/user_list.php" class="link  <?= $subgroup == "userlist" ? "active" : "" ?>">
                                <i class="fas fa-list"></i>
                                <span>Users List</span>
                            </a>
                        </li>
                        <li class="link-list">
                            <a href="#" class="link">
                                <i class="fas fa-user-plus"></i>
                                <span>Add User</span>
                            </a>
                        </li>
                    </div>
                </ul>
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