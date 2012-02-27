<?php

/**
 * zeitgeist actions.
 *
 * @package    zeitgeist.musiques-incongrues.net
 * @subpackage zeitgeist
 */
class zeitgeistActions extends sfActions
{
    /**
     * Website homepage.
     *
     * @param sfWebRequest $request
     */
    public function executeHome(sfWebRequest $request)
    {
        // Fetch latest zeitgeist
        $zeitgeistLatest = LUM_ZeitgeistTable::getInstance()->getLatestIssue();

        // Redirect
        $this->redirect('@zeitgeist_show?id='.$zeitgeistLatest->zeitgeistid);
    }

    /**
     * Displays a Zeitgeist issue.
     *
     * @param sfWebRequest $request
     */
    public function executeShow(sfWebRequest $request)
    {
        // Fetch Zeitgeist
        $zeitgeist = LUM_ZeitgeistTable::getInstance()->findOneByZeitgeistid($request->getParameter('id'));
        $this->forward404Unless($zeitgeist->ispublished || $this->getRequestParameter('preview') !== null);

        // Date handling
        $dateTimeStart = DateTime::createFromFormat('Y-m-d', $zeitgeist->datestart);
        $dateTimeEnd = DateTime::createFromFormat('Y-m-d', $zeitgeist->dateend);
        $formatStart = '%e %B %Y';
        $formatEnd = '%e %B %Y';
        if ($dateTimeStart->format('j') == 1) {
            $formatStart = '%eer %B %Y';
        }
        if ($dateTimeEnd->format('j') == 1) {
            $formatEnd = '%eer %B %Y';
        }
        $datestartPretty = strftime($formatStart, $dateTimeStart->getTimestamp());
        $dateendPretty = strftime($formatEnd, $dateTimeEnd->getTimestamp());

        // Redirect to 404 if zeitgeist cannot be found
        $this->forward404Unless($zeitgeist);

        // Sort events
        $events = array();
        foreach ($zeitgeist->getUpcomingEvents() as $event) {
            $date = DateTime::createFromFormat('Y-m-d', $event['LUM_Event']['date']);
            $timestamp = $date->getTimestamp();
            if (!isset($events[$timestamp])) {
                $events[$timestamp] = array();
            }
            $events[$timestamp][] = $event;
        }

        // Fetch links from data.musiques-incongrues.net
        $data = array(
            'all' => array(
                'url' => sprintf('http://data.musiques-incongrues.net/collections/links/segments/all/get?contributed_at=[%sT00:00:00Z%%20TO%%20%sT00:00:00Z]', $dateTimeStart->format('Y-m-d'), $dateTimeEnd->format('Y-m-d')),
                'count' => 0,
            ),
            'images' => array(
                'url' => sprintf('http://data.musiques-incongrues.net/collections/links/segments/images/get?contributed_at=[%sT00:00:00Z%%20TO%%20%sT00:00:00Z]', $dateTimeStart->format('Y-m-d'), $dateTimeEnd->format('Y-m-d')),
                'count' => 0,
            ),
            'videos' => array(
                'url' => sprintf('http://data.musiques-incongrues.net/collections/links/segments/all/get?contributed_at=[%sT00:00:00Z%%20TO%%20%sT00:00:00Z]&domain_parent=vimeo.com%%20OR%%20youtube.com', $dateTimeStart->format('Y-m-d'), $dateTimeEnd->format('Y-m-d')),
                'count' => 0,
            ),
        );

        foreach ($data as $segment => $spec) {
            $curl = curl_init($spec['url'].'&format=json');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($curl), true);
            $data[$segment]['count'] = (int)$response['num_found'];            
        }

        // Metadata
        $title = sprintf('Zeitgeist Incongru #%d : du %s au %s', $zeitgeist->zeitgeistid, $datestartPretty, $dateendPretty);
        $description = "Chaque semaine, le Zeitgeist Incongru résume l'actualité du forum des Musiques Incongrues : nouvelles productions, mixes et autres pièces. Il propose aussi un agenda des concerts pour la semaine à venir.";
        $description .= sprintf(
            "\n".'Cette semaine : %d mixes, %d sorties, %d nouveaux venus et %d évènements à venir !',
            count($zeitgeist->getMixes()),
            count($zeitgeist->getReleases()),
            count($zeitgeist->getUsers()),
            count($zeitgeist->getUpcomingEvents())
            );
        $ogp = array(
            'title' => $title,
            'description' => $description,
            'image' => $zeitgeist->image,
            'url' => 'http://zeitgeist.musiques-incongrues.net/'.$zeitgeist->zeitgeistid,
            'type' => 'article'
            );
        $this->getResponse()->addMeta('title', $title);
        $this->getResponse()->addMeta('description', $description);
        foreach ($ogp as $name => $content) {
            $this->getResponse()->addMeta('og:'.$name, $content);
        }

        // Apply markdown transformation to texts
        require_once(sfConfig::get('sf_lib_dir').'/vendor/markdown-php/markdown.php');
        $ananasExMachina = Markdown(utf8_encode($zeitgeist->ananasexmachina));
        $description = Markdown(utf8_encode($zeitgeist->description));

        // Pass data to view
        $this->zeitgeist = $zeitgeist;
        $this->events = $events;
        $this->dateStartPretty = $datestartPretty;
        $this->dateEndPretty = $dateendPretty;
        $this->ananasExMachina = $ananasExMachina;
        $this->description = $description;
        $this->lastZeitgeistId = LUM_ZeitgeistTable::getInstance()->getLatestIssue()->zeitgeistid;
        $this->data = $data;

        // Select template
        return sfView::SUCCESS;
    }

    public function executeFeed(sfWebRequest $request)
    {
        // Fetch zeitgeists
        $zeitgeists = LUM_ZeitgeistTable::getInstance()->getLastIssues();
        $zeitgeistLatest = $zeitgeists[0];

        // Setup zend autoloading
        require_once(sfConfig::get('sf_lib_dir').'/vendor/zend/library/Zend/Loader/Autoloader.php');
        Zend_Loader_Autoloader::getInstance();

        // Build feed
        $feed = new Zend_Feed_Writer_Feed();
        $feed->setTitle('Le Zeitgeist du forum des Musiques Incongrues');
        $feed->setLink('http://zeitgeist.musiques-incongrues.net');
        $feed->setFeedLink('http://zeitgeist.musiques-incongrues.net/feeds/news', 'rss');
        $feed->setDescription("Chaque semaine, le Zeitgeist Incongru résume l'actualité du forum des Musiques Incongrues : nouvelles productions, mixes et autres pièces. Il propose aussi un agenda des concerts pour la semaine à venir.");
        $feed->addAuthor(
            array(
                'name'  => 'Musiques Incongrues',
                'email' => 'contact@musiques-incongrues.net',
                'uri'   => 'http://www.musiques-incongrues.net',
                )
            );
        $feed->setDateModified(DateTime::createFromFormat('Y-m-d', $zeitgeistLatest->datestart)->getTimestamp());

        foreach ($zeitgeists as $zeitgeist) {
            // Date handling
            // TODO : factor in zeitgeist->getTitle()
            $dateTimeStart = DateTime::createFromFormat('Y-m-d', $zeitgeist->datestart);
            $dateTimeEnd = DateTime::createFromFormat('Y-m-d', $zeitgeist->dateend);
            $formatStart = '%e %B %Y';
            $formatEnd = '%e %B %Y';
            if ($dateTimeStart->format('j') == 1) {
                $formatStart = '%eer %B %Y';
            }
            if ($dateTimeEnd->format('j') == 1) {
                $formatEnd = '%eer %B %Y';
            }
            $datestartPretty = strftime($formatStart, $dateTimeStart->getTimestamp());
            $dateendPretty = strftime($formatEnd, $dateTimeEnd->getTimestamp());

            // Build entry
            $entry = $feed->createEntry();
            $entry->setTitle(sprintf('Zeitgeist Incongru #%d : du %s au %s', $zeitgeist->zeitgeistid, $datestartPretty, $dateendPretty));
            $entry->setLink('http://zeitgeist.musiques-incongrues.net/'.$zeitgeist->zeitgeistid);
            $entry->setDateModified($dateTimeStart->getTimestamp());
            $entry->setDateCreated($dateTimeEnd->getTimestamp());
            $defaultDescription = sprintf(
                "\n".'Cette semaine : %d mixes, %d sorties, %d nouveaux venus et %d évènements à venir !',
                count($zeitgeist->getMixes()),
                count($zeitgeist->getReleases()),
                count($zeitgeist->getUsers()),
                count($zeitgeist->getUpcomingEvents())
                );

            $entry->setDescription($defaultDescription);

            // Build entry content
            $content = array();

            // Apply markdown transformation to texts
            require_once(sfConfig::get('sf_lib_dir').'/vendor/markdown-php/markdown.php');
            if ($zeitgeist->description) {
                $description = Markdown(utf8_encode($zeitgeist->description));
            } else {
                $description = $defaultDescription;
            }
            $content[] = $description;
            if ($zeitgeist->image) {
                $content[] = sprintf('<img src="%s" />', $zeitgeist->image);
            }
            $entry->setContent(implode("\n", $content));

            // Add entry to feed
            $feed->addEntry($entry);
        }

        // Amend decoration
        sfConfig::set('sf_web_debug', false);
        $this->setLayout(false);

        // Set response headers
        $this->getResponse()->setContentType('application/rss+xml');

        // Pass data to view
        $this->feed = $feed->export('rss');
    }
}
