<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My Shop : The best place to buy japanese handmade tableware">
    <link rel="shortcut icon" href="#" type="image/x-icon">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>My Shop</title>
</head>
<body>
<?php 
        include_once('./pages/functions.php');
?>

<div class="wrapper" description="whole page wrapper"> 
    <div class="header" description="header containing logo, message and navbar">
        <div class="logo"><img src="<?php echo LOGO_IMG; ?>" alt="my shop logo"></div>
        <div class="message" description="display greetings">
            <p class="message--japanese" description="japanese greeting message">いらっしゃいませ</p>
            <p class="message--english" description="english greeting message"><?php App::display_name_index() ?></p>
        </div>
        <ul class="nav" description="navigation menu">  
            <?php
                App::display_nav();
            ?>
        </ul>
    </div>

    <div class="cwrap" description="wrapper for the content of the website">
        <div class="content" description="display website content">
            <aside class="filter" description="fitler menu">
                <?php
                    App::filter_bar();
                ?>       
            </aside>
            <?php
                if(isset($_POST['filter_reset'])) {
                    App::filter_reset();
                    $param = ['filter_sort' => NULL, 'filter_category' => 1, 'filter_price' =>0];
                    App::display_products($param);
                }

                if(isset($_POST['filter_submit'])) {
                    App::display_products($_POST);
                } else {
                    $param = ['filter_sort' => NULL, 'filter_category' => 1, 'filter_price' =>0];
                    App::display_products($param);
                }
            ?>

        </div>
    </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>