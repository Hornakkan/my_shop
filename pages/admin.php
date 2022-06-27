<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My Shop : The best place to buy japanese handmade tableware">
    <link rel="shortcut icon" href="#" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>My Shop - Admin</title>
</head>
<body>

<?php
    require_once('functions.php');
    App::authCheck();
?>
<div class="adm-header">

<div class="header" description="header containing logo, message and navbar">
        <div class="logo"><img src=".<?php echo LOGO_IMG; ?>" alt="my shop logo"></div>
        <div class="message" description="display greetings">
            <p class="message--japanese" description="japanese greeting message">いらっしゃいませ</p>
            <p class="message--english" description="english greeting message"><?php App::display_name_index() ?></p>
        </div>
        <ul class="nav" description="navigation menu">  
            <h3>Admin Interface</h3>
        </ul>
    </div>

</div>

<div class="adm-wrapper">
    <aside class="adm--items">
        <ul>
            <li>
                <form action="" method="post">
                    <button type="submit" name="mng-users" id="mng-users" class="btn btn-light"><!-- Manage users --></button>
                </form>
            </li>
            <li>
                <form action="" method="post">
                    <button type="submit" name="mng-products" id="mng-products" class="btn btn-light"><!-- Manage products --></button>
                </form>
            </li>
            <li>
                <form action="" method="post">    
                    <button type="submit" name="mng-categories" id="mng-categories" class="btn btn-light"><!-- Manage categories --></button>
                </form>
            </li>
        </ul>
        <ul class="adm--items--options">
            <li>
                <form action="" method="post">    
                    <button type="submit" name="mng-index" id="mng-index" class="btn btn-light"><!-- Index page --></button>
                </form>
            </li>
            <li>
                <form action="" method="post">    
                    <button type="submit" name="mng-logout" id="mng-logout" class="btn btn-light"><!-- Logout --></button>
                </form>
            </li>
        </ul>
    </aside>
    <div class="container" alt="global container for query results">
        <?php 
            // gestion users
            if(isset($_POST['mng-users'])) {
                App::getUsers();
            }
            App::editUsers();
            App::deleteUsers();
            App::addUsers();

            // gestion products
            if(isset($_POST['mng-products'])) {
                App::getProducts();
            }
            App::editProducts();
            App::deleteProducts();
            App::addProducts();

            // gestion catégories
            if(isset($_POST['mng-categories'])) {
                App::getCategories();
            }
            App::editCategories();
            App::deleteCategories();
            App::addCategories();

            // back to index
            if(isset($_POST['mng-index'])) {
                header("Location: ../index.php");
                die();
            }

            // logout
            if(isset($_POST['mng-logout'])) {
                App::log_out_admin();
            }
        ?>
    </div>
</div>




<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>