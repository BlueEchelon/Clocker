<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
            href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@700&family=Roboto:wght@300;400;500;700&display=swap"
            rel="stylesheet">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Clocker</title>
</head>

<body>
<?php require_once "_navbar.php" ?>

<!-- Hero section -->
<section class="hero">
    <div class="hero__content">
        <h2 class="hero__title">Time management has never been easier.</h2>
        <p class="hero__text">Keep track of you work time, create numerous
            projects and increase your
            productivity.</p>
        <a class="btn-primary">Get started</a>

    </div>
    <div class="hero__img">
        <img src="../images/hero_img.svg" alt="Time management image">
    </div>
</section>

<!-- About section -->
<section class="about container">
    <h3 class="about__title">About us</h3>

    <div class="about__content">
        Cupcake ipsum dolor sit amet chupa chups sweet roll I love. I love
        macaroon I love I love powder dessert I love lollipop cotton candy.
        Gummies donut sweet dragée biscuit chupa chups I love chocolate. Croissant
        croissant apple pie croissant caramels chocolate. Dragée chupa chups donut
        cookie jelly-o icing jelly beans. Soufflé biscuit halvah pastry chocolate
        cake jujubes oat cake cake. Biscuit shortbread icing cheesecake jelly
        tiramisu I love biscuit. Powder wafer sugar plum macaroon gummies dragée
        cake pie caramels. Cupcake I love marzipan chocolate bar macaroon cupcake
        cookie topping I love. Chocolate cake cheesecake cookie I love gummies
        chocolate chocolate.
    </div>
</section>

<!-- Statistics section -->
<section class="statistics container">
    <h3 class="statistics__title">Statistics</h3>
    <div>
        <?php
        require_once "connect.php";
        $sql = "SELECT COUNT(*) as user_count FROM users WHERE role='u'";
        $handle = $pdo->prepare($sql);
        $handle->execute();
        $fetch = $handle->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="statistics__container">
            <div class="statistics__content">
                <h4 class="statistics__content-title">Join to <span
                            class="statistics__number"><?php echo $fetch['user_count']?></span> users
                </h4>

                <div class="statistics__content-raports">
                    <h4 class="statistics__content_raports-title">Generated raports:</h4>

                    <div class="statistics__content-data">
                        <span>daily</span>
                        <span
                                class="statistics__number statistics__number--small">305</span>
                    </div>

                    <div class="statistics__content-data">
                        <span>weekly</span>
                        <span class="statistics__number statistics__number--small">2
              137</span>
                    </div>

                    <div class="statistics__content-data">
                        <span>annually</span>
                        <span class="statistics__number statistics__number--small">780
              005</span>
                    </div>

                    <div class="statistics__content-data">
                        <span>total</span>
                        <span class="statistics__number statistics__number--small">3 123
              728</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="statistics__img">
            <img src="../images//statistics_img.svg" alt="Statistics image">
        </div>
    </div>
</section>
</body>


</html>