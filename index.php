<!DOCTYPE html>
<?php
$page = "home";
$group = "landing";
require_once __DIR__ . '/./src/request.php';
require_once __DIR__ . '/./includes/head.php';
$choose = (new Content)->choose();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-voting Platform</title>
    <link rel="stylesheet" href="./assets/styles/css/landing.css">
    <?php require_once __DIR__ . '/./includes/style.php'; ?>
</head>

<body>
    <?php require_once __DIR__ . '/./includes/landingHeader.php'; ?>
    <main class="home">
        <section class="hero">
            <div class="container">
                <div class="hero-left">
                    <h1 class="hero-welcome">Welcome to ACOMS e-voting system</h1>
                    <h3> Where we provide your with secured, fast and reliable voting experience without need to panic that your vote would be compromised.</h3>
                    <div class="my-btn-group">
                        <?= setVoterButton() ?>
                        <a href="/register.php" class="my-btn-primary outline-primary"> Adminstrator's Account</a>
                    </div>
                </div>
                <div class="hero-right">
                    <img src="/assets/images/home_hero1.svg" alt="svg reprsenting election" class="hero-img">
                </div>
            </div>
        </section>

        <section class="why-us">
            <div class="container">
                <h2 class="why-us-title mb-4">OUR SYSTEM</h2>

                <div class="offers">
                    <?php foreach ($choose as $item) { ?>
                    <div class="offer">
                        <div class="top">
                            <h4 class="offer-icon">
                                <i class="<?= $item["icon"] ?>"></i>
                            </h4>
                            <h4 class="offer-title">
                                <?= $item["title"] ?>
                            </h4>
                        </div>
                        <p class="offer-content">
                            <?= $item["content"] ?>
                        </p>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>

    </main>

    <?php require_once __DIR__ . '/./includes/footer.php'; ?>
    <?php require_once __DIR__ . '/./includes/script.php'; ?>
    <script src="./assets/scripts/accordion.js" type="module"></script>
    <script src="./assets/scripts/landing_header.js" type="module"></script>
</body>

</html>