<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?php if (isset($title)) {echo $title;} ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="<?php if (isset($description)) {echo $description;}  ?>" />
	<meta name="keywords" content="<?php if (isset($keywords)) {echo $keywords;	}  ?>" />
    <script src="/template/js/vendor/modernizr.js"></script>
    <script src="/template/js/vendor/jquery.js"></script>
	<link rel="stylesheet" href="/template/css/foundation.css" />
	<link rel="stylesheet" href="/template/css/custom.css" />
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
</head>
<body>




<header id="site-header">
    <div class="row addmargin">
        <div class="large-12 columns">
            <nav class="top-bar" data-topbar>
                <ul class="title-area">
                    <li class="name">
                        <h1><a href="/">FIRM NAME</a></h1>
                    </li>
                    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a>
                    </li>
                </ul>
                <section class="top-bar-section">
                    <?php echo $top_menu;	?>
                    <ul class="right">
                        <li class="has-form">
                            <form>
                                <div class="row collapse">
                                    <div class="small-8 columns">
                                        <input type="text">
                                    </div>
                                    <div class="small-4 columns">
                                        <a href="#" class="alert button">Search</a>
                                    </div>
                                </div>
                            </form>
                        </li>
                    </ul>
                </section>

            </nav>
        </div>
    </div>
</header>


<div class="wrapper">






    <div class="row">
        <aside class="large-3 columns">

            <div id="info"></div>
            <?php include 'login.php'; ?>
            <p class="panel">МЕНЮ</p>
            <?php echo $cat_menu;	?>
        </aside>
        <div class="large-9 columns">
            <article>
                <ul class="breadcrumbs">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Gene Splicing</a></li>
                    <li class="current"><a href="#">Cloning</a></li>
                </ul>

                <?php
                echo $content;
                ?>

            </article>



        </div>
    </div>

</div>

<footer id="site-footer">
    <div class="row">
        <div class="large-12 columns panel radius">
            <p>Copyright &copy; <?php echo date('Y') ?></p>
        </div>
    </div>
</footer>



<script src="/template/js/vendor/jquery.js"></script>
<script src="/template/js/foundation.min.js"></script>
<script>
    $(document).foundation();
</script>
</body>
</html>