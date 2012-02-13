<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="fr">
<!--<![endif]-->

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title><?php echo $sf_response->getTitle() ?></title>
    <meta name="description" content="Un résumé hebdomadaire de l'activité du forum des Musiques Incongrues">
    <meta name="author" content="Constructions Incongrues">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet" type="text/css" media="all" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/css/lib/960.gs/reset.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/css/lib/960.gs/text.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/css/lib/960.gs/960_14_col.css" />

    <link rel="stylesheet" href="<?php echo $sf_request->getRelativeUrlRoot() ?>/css/ananas.css">
    <script src="<?php echo $sf_request->getRelativeUrlRoot() ?>/js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body>

    <div class="container_14">

        <div class="grid_3 logo">
            <h1 class="zeit"><a href="<?php echo url_for('@homepage') ?>" title="Chaque semaine, une compilation de ce qui a été posté sur le forum des Musiques Incongrues : sorties, mixes, collections monomaniaques et autres merveilles. C'est le Zeitgeist Incongru.">Zeit</a></h1>
            <h1 class="geist" ><a href="<?php echo url_for('@homepage') ?>" title="Chaque semaine, une compilation de ce qui a été posté sur le forum des Musiques Incongrues : sorties, mixes, collections monomaniaques et autres merveilles. C'est le Zeitgeist Incongru.">geist</a></h1>
        </div><!-- end of grid_3 logo -->

        <div class="grid_11 numero">
<?php include_slot('zeitgeist_header') ?>
        </div><!-- end of grid_10-->

        <div class="clear"></div>

        <div class="grid_3">
            <ul class="nav">
                <li><a href="/issues.xml">RSS</a></li>
                <li><a class="share" href="http://facebook.com/sharer.php?u=http://zeitgeist.musiques-incongrues.net/issues/1">PARTAGER</a></li>
                <li><a href="mailto:contact@musiques-incongrues.net">CONTACT</a></li>
                <li><a href="#TODO">MAILING LIST</a></li>
            </ul>
            <div class="pagination">
                <h1>ARCHIVES</h1>
                <ul>
                    <li class="active"><a href="/issues/1" title="Période du 6/05/2011 au 12/05/2011">▲ 1</a></li>
                    <li><a href="/issues/1" title="Période du 6/05/2011 au 12/05/2011">▲ 2</a></li>
                </ul>
                <h2 class="moreepisode"><a href="">Next</a> </h2>
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
