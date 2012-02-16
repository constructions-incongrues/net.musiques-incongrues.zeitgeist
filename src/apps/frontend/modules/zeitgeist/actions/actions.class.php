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

        // Redirect to 404 if zeitgeist cannot be found
        $this->forward404Unless($zeitgeist);

        // Sort events
        $events = array();
        foreach ($zeitgeist->getUpcomingEvents() as $event) {
            if (!isset($events[$event['LUM_Event']['date']])) {
                $events[$event['LUM_Event']['date']] = array();
            }
            $events[$event['LUM_Event']['date']][] = $event;
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

        // Pass data to view
        $this->zeitgeist = $zeitgeist;
        $this->events = $events;

        // Select template
        return sfView::SUCCESS;
    }
}
