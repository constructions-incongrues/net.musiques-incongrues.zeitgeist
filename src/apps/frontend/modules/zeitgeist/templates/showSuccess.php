<?php
$zeitgeist = $sf_data->getRaw('zeitgeist');
$events = $sf_data->getRaw('events');

// TODO : this should go in a helper
function slugify($text)
{
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    $text = trim($text, '-');

    if (function_exists('iconv')) $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    $text = strtolower($text);
    $text = preg_replace('~[^-\w]+~', '', $text);

    if (empty($text)) return 'n-a';

    return $text;
}
?>

<div class="grid_11">
    <div class="grid_11 numero alpha omega">
        <h1 class="last">
            Zeitgeist #<?php echo $zeitgeist->zeitgeistid ?><br />
            du <?php echo $dateStartPretty ?> au <?php echo $dateEndPretty ?>
        </h1>
        <p class="presentation">
        <?php echo nl2br($zeitgeist->description) ?>
        </p>
    </div>

    <div class="grid_5 releases alpha">
        <h2><a href="http://www.musiques-incongrues.net/forum/releases/" title="Consulter la liste de toutes les sorties musicales disponibles sur le forum des Musiques Incongrues">Du nouveau pour les oreilles</a></h2>
        <dl>
            <dt>Mixes</dt>
<?php foreach($zeitgeist->getMixes() as $mix): ?>
            <dd>
                <a href="http://www.musiques-incongrues.net/forum/discussion/<?php echo $mix['discussionid'] ?>/<?php echo slugify($mix['name'])?>" title="Consulter la discussion sur le forum des Musiques Incongrues"><?php echo $mix['name'] ?></a>
    <?php if ($mix['LUM_Releases']['downloadlink'] ): ?>
                <span class="download"><a href="<?php echo $mix['LUM_Releases']['downloadlink'] ?>" title="Télécharger le mix">⚡</a></span>
    <?php endif; ?>
            </dd>
<?php endforeach; ?>

            <dt>Sorties</dt>
<?php foreach($zeitgeist->getReleases() as $release): ?>
            <dd>
                <a href="http://www.musiques-incongrues.net/forum/discussion/<?php echo $release['discussionid'] ?>/<?php echo slugify($release['name'] ) ?>" title="Consultez la discussion sur le forum des Musiques Incongrues"><?php echo $release['name'] ?></a>
    <?php if ($release['LUM_Releases']['downloadlink'] ): ?>
                <span class="download"><a href="<?php echo $release['LUM_Releases']['downloadlink'] ?>" title="Télécharger le mix">⚡</a></span>
    <?php endif; ?>
            </dd>
<?php endforeach; ?>
        </dl>

    </div><!-- end of grid_5-->

    <div class="grid_6 events omega">
        <h2><a href="http://www.musiques-incongrues.net/forum/events/" title="Consultez l'agenda du forum des Musiques Incongrues">LA SEMAINE PROCHAINE, ON SORT !</a></h2>
<?php foreach (array_keys($events) as $timestamp): ?>
        <dl>
            <dt><?php echo strftime('%A %e', $timestamp) ?></dt>
    <?php foreach ($events[$timestamp] as $event): ?>
            <dd>
                <span class="ville">
                    <a href="http://www.musiques-incongrues.net/forum/events/<?php echo strtolower($event['LUM_Event']['city']) ?>"><?php echo $event['LUM_Event']['city'] ?></a>
                </span>	- <a href="http://www.musiques-incongrues.net/forum/discussion/<?php echo $event['discussionid'] ?>/<?php echo slugify($event['name']) ?>"> <?php echo $event['name'] ?></a>
            </dd>
    <?php endforeach; ?>
        </dl>
<?php endforeach; ?>
    </div><!-- end of grid_6events-->

    <div class="clear"></div>

    <div class="grid_6 compte_rendu alpha">
        <h2><a href="http://github.com/constructions-incongrues/">Ananas Ex Machina !</a></h2>
<?php echo $zeitgeist->getAnanasExMachinaFormated() ?>
    </div><!-- end of grid_6 compte_rendu -->

    <div class="grid_5 picsofweek omega">
        <h2><a href="http://incongrunacotheque.tumblr.com">L'image de la semaine</a></h2>
        <img src="<?php echo $zeitgeist->image ?>" width="300px" />
    </div><!-- end of grid_5picsofweek -->


     <div class="grid_11 newmember alpha omega">
        <h2><a href="">Nouveaux Venus</a></h2>
        <ul>
<?php foreach($zeitgeist->getUsers() as $user): ?>
            <li><a href="http://www.musiques-incongrues.net/forum/account/<?php echo $user['userid'] ?>"><?php echo $user['name'] ?></a></li>
<?php endforeach; ?>
        </ul>
    </div><!-- end of grid_1 newmember -->
</div>

<div class="clear"></div>

