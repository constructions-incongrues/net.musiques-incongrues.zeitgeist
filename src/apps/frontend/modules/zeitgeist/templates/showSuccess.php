<?php
$zeitgeist = $sf_data->getRaw('zeitgeist');
$events = $sf_data->getRaw('events');
use_helper('Text');

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

<?php slot('navigation'); ?>
<?php if ($zeitgeist->zeitgeistid > 1): ?>
    <h2 class="moreepisode previous"><a href="<?php echo url_for('@zeitgeist_show?id='.($sf_request->getParameter('id') - 1)) ?>">Previous</a></h2>
<?php endif; ?>
<?php if ($zeitgeist->zeitgeistid != $lastZeitgeistId): ?>
    <h2 class="moreepisode next"><a href="<?php echo url_for('@zeitgeist_show?id='.($sf_request->getParameter('id') + 1)) ?>">Next</a></h2>
<?php endif; ?>
<?php end_slot(); ?>

<div class="grid_11 content">
    <div class="grid_11 numero alpha omega">
        <h1 class="last">
            Zeitgeist #<?php echo $zeitgeist->zeitgeistid ?>
            du <?php echo $dateStartPretty ?> au <?php echo $dateEndPretty ?>
        </h1>
        <div class="presentation">
            <?php echo auto_link_text($sf_data->getRaw('description')) ?>
        </div>
    </div>

    <div class="grid_5 releases alpha">
        <h2><a href="http://www.musiques-incongrues.net/forum/releases/" title="Consulter la liste de toutes les sorties musicales disponibles sur le forum des Musiques Incongrues">Du nouveau pour les oreilles</a></h2>
        <dl>
            <dt><?php echo count($zeitgeist->getMixes()) ?> Mixes</dt>
            <?php foreach($zeitgeist->getMixes() as $mix): ?>
            <dd>
                <a href="http://www.musiques-incongrues.net/forum/discussion/<?php echo $mix['discussionid'] ?>/<?php echo slugify($mix['name'])?>" title="Consulter la discussion sur le forum des Musiques Incongrues"><?php echo $mix['name'] ?></a>
                <?php if ($mix['LUM_Releases']['downloadlink'] ): ?>
                <span class="download"><a href="<?php echo $mix['LUM_Releases']['downloadlink'] ?>" title="Télécharger le mix">⚡</a></span>
            <?php endif; ?>
        </dd>
    <?php endforeach; ?>

    <dt><?php echo count($zeitgeist->getReleases()) ?> Sorties</dt>
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
    <p><?php echo auto_link_text($sf_data->getRaw('ananasExMachina')) ?></p>
</div><!-- end of grid_6 compte_rendu -->

<div class="grid_5 picsofweek omega">
    <h2><a href="http://incongrunacotheque.tumblr.com">L'image de la semaine</a></h2>
    <img src="<?php echo $zeitgeist->image ?>" width="300px" />
</div><!-- end of grid_5picsofweek -->

<div class="clear"></div>

<div class="grid_6 newmember alpha">
    <h2><a href=""><?php echo count($zeitgeist->getUsers()) ?> Nouveaux Venus</a></h2>
    <ul>
        <?php foreach($zeitgeist->getUsers() as $user): ?>
        <li><a href="http://www.musiques-incongrues.net/forum/account/<?php echo $user['userid'] ?>"><?php echo $user['name'] ?></a></li>
    <?php endforeach; ?>
</ul>
</div><!-- end of grid_6 newmember -->

<div class="grid_5 data omega">
<h2><a href="http://data.musiques-incongrues.net">Data</h2>
<ul>
    <li><a target="_blank" href="<?php echo $data['all']['url'] ?> "><?php echo $data['all']['count'] ?> nouveaux liens</a></li>
    <li><a target="_blank" href="<?php echo $data['images']['url'] ?> "><?php echo $data['images']['count'] ?> nouvelles images</a></li>
    <li><a target="_blank" href="<?php echo $data['youtube']['url'] ?> "><?php echo $data['youtube']['count'] ?> nouvelles vidéos (youtube)</a></li>
    <li><a target="_blank" href="<?php echo $data['vimeo']['url'] ?> "><?php echo $data['vimeo']['count'] ?> nouvelles vidéos (vimeo)</a></li>
</ul>    
</div><!-- end of grid_5 data -->

</div><!-- end of grid_11 -->

<div class="clear"></div>


<div class="grid_14 footer">
    <p class="about">
        <span class="apropos">À PROPOS</span>
        <span class="about2">
            Ce projet est développé par
            <a href="http://wwww.constructions-incongrues.net">Constructions Incongrues</a>
            et hébergé par <a href="http://www.pastis-hosting.net">Pastis Hosting</a>.
            Le code source du projet est <a href="https://github.com/contructions-incongrues/zeitgeist.musiques-incongrues.net">distribué</a> sous licence
            <a href="http://www.gnu.org/licenses/agpl-3.0.html">GNU AGPLv3</a>.
        </span>
    </p>
</div>

<div class="clear"></div>

<script type="text/javascript" src="http://o.aolcdn.com/os_merge/?file=/streampad/sp-player.js&file=/streampad/sp-player-other.js&expsec=86400&ver=11&bgcolor=#000000&trackcolor=#0099F&clickimg=true&progressfrontcolor=FFF&progressbackcolor=0099FF&drawersize=215&btncolor=white-gray&clicktext=Cliquez%20ici%20pour%20écouter%20les%20nouveautés"></script>
