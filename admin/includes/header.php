<header class="admin-header">
    <div class="right">
        <button type="button" class="open">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        <h5 class="page m-0">
            <?= implode(" ", explode("-", $page)) ?>
        </h5>
    </div>

    <div class="my-dropdown">
        <button class="my-dropdown-toggle">
            <div class="shortName">
                <span><?= $abbr ?></span>
            </div>
            <i class="fa fa-angle-down icon" aria-hidden="true"></i>
        </button>
        <ul class="my-dropdown-list">
            <li class="my-dropdown-items">
                <div class="my-dropdown-item info">
                    <div class="shortName">
                        <span><?= $abbr ?></span>
                    </div>
                    <p class="m-0"><?= $admin["firstname"] . " " . $admin["lastname"] ?></p>
                </div>
            </li>
            <li class="my-dropdown-items">
                <a href="/admin/settings.php" class="my-dropdown-item <?= $page == "settings" ? "active" : "" ?>">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="my-dropdown-items">
                <button type="button" class="my-dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logout">
                    <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                    <span>Signout</span>
                </button>
            </li>
        </ul>
    </div>
</header>
<?php require_once __DIR__ . '/./../../includes/logoutModal.php'; ?>