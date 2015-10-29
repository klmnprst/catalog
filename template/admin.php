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
    <link rel="stylesheet" href="/template/css/foundation-icons.css" />
	<link rel="stylesheet" href="/template/css/custom.css" />
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
</head>
<body>





<div class="row fullWidth" style="background:#F2B707; margin-bottom:5px;">
     <div class="large-12 columns"><h3>ADMIN</h3></div>
</div>



<div class="wrapper">


    <div class="row fullWidth">
        <aside class="large-3 columns">

            <div id="info"></div>
            <?php include 'login.php'; ?>

            <p class="panel">АДМИН МЕНЮ</p>
                <ul class="side-nav">
                    <li><a href="/admin/attribute">Атрибуты</a></li>
                    <li><a href="/admin/category">Категории</a></li>
                    <li><a href="/admin/goods">Товары</a></li>
                </ul>
            
            <p class="panel">МЕНЮ</p>
            <?php echo $cat_menu;	?>
        </aside>
        <div class="large-9 columns">
            <article>

                <?php
                echo $content;
                ?>

            </article>



        </div>
    </div>

</div>

<footer id="site-footer">
    <div class="row fullWidth">
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