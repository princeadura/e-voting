<!DOCTYPE html>
<?php
$page = "dashboard";
require_once __DIR__ . '/./../src/request.php';
require_once __DIR__ . '/./includes/head.php';
?>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <?php require_once __DIR__ . '/.././includes/style.php'; ?>
    </head>

    <body>
        <?php require_once __DIR__ . '/./includes/header.php'; ?>
        <?php require_once __DIR__ . '/./includes/sidebar.php'; ?>
        <?php if (isset($admin["organization"])) { ?>
        <main class="dashboard">
            <section class="mycard-wrapper">
                <a href="#" class="mycard admin">
                    <span class="icon">
                        <i class="fas fa-user-shield"></i>
                    </span>
                    <h5 class="title">
                        Administrators
                    </h5>
                    <p class="count">
                        8
                    </p>
                </a>
                <a href="#" class="mycard voter">
                    <span class="icon">
                        <i class="fas fa-person-booth"></i>
                    </span>
                    <h5 class="title">
                        Voters
                    </h5>
                    <p class="count">
                        40
                    </p>
                </a>
                <a href="#" class="mycard candidate">
                    <span class="icon">
                        <i class="fas fa-user-tag"></i>
                    </span>
                    <h5 class="title">
                        Candidates
                    </h5>
                    <p class="count">
                        10
                    </p>
                </a>
                <a href="#" class="mycard election">
                    <span class="icon">
                        <i class="fas fa-vote-yea"></i>
                    </span>
                    <h5 class="title">
                        Elections
                    </h5>
                    <p class="count">
                        4
                    </p>
                </a>
            </section>

            <section class="info">
                <div class="profile-info">
                    <h3 class="title">Your Profile</h3>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <p><span>First Name:</span> <?= $admin["firstname"] ?> </p>
                        </li>
                        <li class="list-group-item">
                            <p><span>Last Name:</span> <?= $admin["lastname"] ?> </p>
                        </li>
                        <li class="list-group-item ">
                            <p><span>Middle Name:</span> <?= $admin["middlename"] ?> </p>
                        </li>
                        <li class="list-group-item ">
                            <p><span>Username:</span> <?= $admin["username"] ?> </p>
                        </li>
                        <li class="list-group-item ">
                            <p><span>Organization:</span> <?= $organizationName ?> </p>
                        </li>
                    </ul>
                </div>
                <div class="election-info">
                    <h3 class="title">
                        Election Info
                    </h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover election-table">
                            <thead>
                                <tr>
                                    <th scope="col">S/N</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($elections as $key => $election) { ?>
                                <tr class="">
                                    <td><?= ++$key ?></td>
                                    <td><?= $election["election_name"] ?></td>
                                    <td><?= $election["election_status"] ?></td>
                                    <td> <a href="#" class="btn my-btn-primary"> <i class="fas fa-binoculars"></i> </a> </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </section>
        </main>
        <?php } else { ?>
        <?php require_once __DIR__ . '/./includes/register_organization.php'; ?>
        <?php } ?>
        <?php require_once __DIR__ . '/./includes/footer.php'; ?>
        <?php require_once __DIR__ . '/.././includes/script.php'; ?>
    </body>

</html>