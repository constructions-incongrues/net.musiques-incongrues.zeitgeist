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

        // Pass data to view
        $this->zeitgeist = $zeitgeist;
        $this->events = $events;

        // Select template
        return sfView::SUCCESS;
    }
}
