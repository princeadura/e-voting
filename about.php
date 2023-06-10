<!DOCTYPE html>
<?php
$page = "about";
$group = "landing";
require_once __DIR__ . '/./includes/head.php';
?>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About</title>
        <?php require_once __DIR__ . '/./includes/style.php'; ?>
    </head>

    <body>
        <?php require_once __DIR__ . '/./includes/landingHeader.php'; ?>

        <main class="about">
            <section class="hero">
                <div class="container">
                    <div class="hero-left">
                        <h1 class="hero-welcome">About The App</h1>
                        <h3> The App is built to allow you stay in your comfort zone and let the world hear of your voice by been able to cast your vote without stress and fear.</h3>
                        <div class="my-btn-group">
                            <a href="#" class="my-btn-primary"> Chat On WhatsApp <i class="fab fa-whatsapp" aria-hidden="true"></i> </a>
                        </div>
                    </div>
                    <div class="hero-right">
                        <img src="/assets/images/about1.svg" alt="svg reprsenting election" class="hero-img">
                    </div>
                </div>
            </section>

            <section class="about-app">
                <div class="container">
                    <h1 class="title m-0">
                        Get Ready to vote in a
                        <span> Fast, Secured and reliable Environment </span>
                    </h1>
                    <div class="about-app-content">
                        <h3 class="content-head">
                            Where Security and Reliability is the driven force behind providing a fast voting experience on the go.
                        </h3>
                        <h3 class="content">
                            Our Users span across different organizations and one of the thing this organizations has in common is the conducting of election for various positions available in the organization.
                        </h3>
                        <h3 class="content">
                            Our Application provide an avenue where people
                            <button class="link-secondary" data-bs-toggle="modal" data-bs-target="#become-an-administrator">
                                register their organizations
                            </button>
                            and add their workers (voter's) who are the ones eligible to vote for any election scheduled by such organization.
                        </h3>
                    </div>
                </div>
            </section>

            <section class="mission-vision">
                <div class="container">
                    <div class="vision">
                        <span class="icon">
                            <i class="fas fa-arrows-to-eye"></i>
                        </span>
                        <div class="content">
                            <h3 class="title">VISION</h3>
                            <h5 class="text">
                                Becoming the central for a peaceful, free and secure voting experience for users.
                            </h5>
                        </div>
                    </div>

                    <div class="mission">
                        <span class="icon">
                            <i class="fas fa-bullseye"></i>
                        </span>
                        <div class="content">
                            <h3 class="title">MISSION</h3>
                        </div>
                        <h5 class="text">
                            To provide secured voting environment for users, and provision of election update on the go.
                        </h5>
                    </div>
                </div>
            </section>

            <section class="team">
                <div class="container">
                    <h1 class="title"> Meet The Team </h1>
                    <ul class="team-list">
                        <li class="team-item">
                            <div class="team-member">
                                <img src="/assets/images/me.jpg" class="team-member-img" alt="member image">
                                <div class="team-member-overlay">
                                    <div class="item">
                                        <a href="#" class="icon" aria-label="whatsapp">
                                            <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                            <p class="tip">
                                                WhatsApp
                                            </p>
                                        </a>
                                        <a href="#" class="icon" aria-label="whatsapp">
                                            <i class="fab fa-twitter" aria-hidden="true"></i>
                                            <p class="tip">
                                                Twitter
                                            </p>
                                        </a>
                                        <a href="#" class="icon" aria-label="whatsapp">
                                            <i class="fab fa-facebook" aria-hidden="true"></i>
                                            <p class="tip">
                                                Facebook
                                            </p>
                                        </a>
                                    </div>
                                </div>
                                <div class="label">
                                    <h2 class="name">Abdul-Azeez Abdul-Azeem <a href="#" class="link-primary"> <i class="fab fa-linkedin" aria-hidden="true"></i> </a></h2>
                                    <h5 class="role"> Lead Developer </h5>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
            <?php require_once __DIR__ . '/./includes/administartorModal.php'; ?>
        </main>

        <?php require_once __DIR__ . '/./includes/footer.php'; ?>
        <?php require_once __DIR__ . '/./includes/script.php'; ?>
        <script src="./assets/scripts/accordion.js" type="module"></script>
        <script src="./assets/scripts/landing_header.js" type="module"></script>
    </body>

</html>