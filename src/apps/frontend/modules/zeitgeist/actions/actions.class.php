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

        // Metadata
        $title = sprintf('Zeitgeist Incongru #%d : du %s au %s', $zeitgeist->zeitgeistid, $zeitgeist->datestart, $zeitgeist->dateend);
        $description = "Chaque semaine, le Zeitgeist Incongru résume l'actualité du forum des Musiques Incongrues : nouvelles productions, mixes et autres pièces. Il propose aussi un agenda des concerts pour la semaine à venir.";
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
        $ananasExMachina = Markdown($zeitgeist->ananasexmachina);
        $description = Markdown($zeitgeist->description);

        // Pass data to view
        $this->zeitgeist = $zeitgeist;
        $this->events = $events;
        $this->dateStartPretty = $datestartPretty;
        $this->dateEndPretty = $dateendPretty;
        $this->ananasExMachina = $ananasExMachina;
        $this->description = $description;

        // Select template
        return sfView::SUCCESS;
    }
}
