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
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,400italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/template/css/foundation.css" />
    <link rel="stylesheet" href="/template/css/foundation-icons.css" />
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
                        <h1><a href="/">LIFEPROM</a></h1>
                    </li>
                    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a>
                    </li>
                </ul>
                <section class="top-bar-section">
                    
                        <?php echo $top_menu;   ?>    
                    
                    
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
            <nav class="vertical">
            <?php echo $cat_menu;	?>
            </nav>
        </aside>
        <div class="large-9 columns">
            <article>
                
                <?php if (isset($breadcrumbs) AND !empty($breadcrumbs)) { ?>
                    <ul class="breadcrumbs">
                    <?php echo $breadcrumbs; ?>
                </ul>    
                <?php } ?>
                

                <?php
                echo $content;
                ?>

            </article>



        </div>
    </div>

</div>
<br>
<footer id="site-footer">
    <div class="row" style="padding: 0 0.9375rem;">
        <div class="large-12 columns panel collapse">
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