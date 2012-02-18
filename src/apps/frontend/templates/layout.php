<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="fr">
<!--<![endif]-->

<head>
<meta charset="utf-8">
    <title><?php echo $sf_response->getTitle() ?> | Musiques Incongrues</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/css/lib/960.gs/reset.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/css/lib/960.gs/text.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/css/lib/960.gs/960_14_col.css" />
    <link rel="stylesheet" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/css/ananas.css?v=1">

    <script src="<?php echo $sf_request->getRelativeUrlRoot() ?>/js/prefixfree.min.js"></script>

    <!-- Icons -->
    <link rel="shortcut icon" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/apple-touch-icon.png">

    <!-- Metas -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1">
<?php foreach ($sf_response->getMetas() as $name => $content): ?>
    <meta property="<?php echo $name ?>" content="<?php echo $content ?>" />
<?php endforeach;?>
</head>

<body>

    <div class="container_14">

        <div class="grid_3 sidebar">

   <h1 class="logo"  >
        <a href="<?php echo url_for('@homepage') ?>" class="zeit">Zeit</a>
        <a href="<?php echo url_for('@homepage') ?>" class="geist">Geist</a>
    </h1>

    <h2 class="descr">Chaque semaine, le Zeitgeist Incongru résume l'actualité du forum des <a href="http://www.musiques-incongrues.net">Musiques Incongrues</a></h2>

            <ul class="nav">
                <li><a class="share" target="_blank" href="http://facebook.com/sharer.php?u=http://<?php echo $sf_request->getHost() ?><?php echo $_SERVER['REQUEST_URI']?>">Partager</a></li>
                <li><a href="mailto:contact@musiques-incongrues.net">Contact</a></li>
            </ul>
            <div class="pagination">
                <h1>Archives</h1>
                <!--
                <ul>
                    <li class="active"><a href="/issues/1" title="Période du 6/05/2011 au 12/05/2011">▲ 1</a></li>
                    <li><a href="/issues/1" title="Période du 6/05/2011 au 12/05/2011">▲ 2</a></li>
                </ul>
                -->
                <h2 class="moreepisode previous"><a href="">Previous</a></h2>
                <h2 class="moreepisode next"><a href="">Next</a> </h2>
            </div><!-- end of.pagination -->
        </div><!-- end of grid_3 -->

<?php echo $sf_content ?>

    </div><!-- end of container_14 -->


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>
                    window.jQuery
                            || document
                                    .write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>');
                </script>

    <!-- scripts concatenated and minified via ant build script-->
    <script src="<?php echo $sf_request->getRelativeUrlRoot() ?>/js/script.js"></script>
    <!-- end scripts-->

    <script type="text/javascript">
                    WebFontConfig = {
                        google : {
                            families : [ 'Cuprum', 'Megrim', 'Metrophobic' ]
                        }
                    };
                    (function() {
                        var wf = document.createElement('script');
                        wf.src = ('https:' == document.location.protocol ? 'https'
                                : 'http')
                                + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                        wf.type = 'text/javascript';
                        wf.async = 'true';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(wf, s);
                    })();
    </script>

    <script>
                    var _gaq = [ [ '_setAccount', 'UA-XXXXX-X' ],
                            [ '_trackPageview' ] ]; // Change UA-XXXXX-X to be your site's ID
                    (function(d, t) {
                        var g = d.createElement(t), s = d
                                .getElementsByTagName(t)[0];
                        g.async = 1;
                        g.src = ('https:' == location.protocol ? '//ssl'
                                : '//www')
                                + '.google-analytics.com/ga.js';
                        s.parentNode.insertBefore(g, s)
                    }(document, 'script'));
    </script>

    <!--[if lt IE 7 ]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
        <script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
    <![endif]-->
</body>

</html>
