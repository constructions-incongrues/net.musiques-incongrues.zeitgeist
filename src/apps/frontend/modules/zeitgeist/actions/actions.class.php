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
        $zeitgeist = LUM_ZeitgeistTable::getInstance()->findOneByZeitgeistid($request->getParameter('id'), Doctrine_Core::HYDRATE_ARRAY);

        // Redirect to 404 if zeitgeist cannot be found
        $this->forward404Unless($zeitgeist);

        // Pass data to view
        $this->zeitgeist = $zeitgeist;

        // Select template
        return sfView::SUCCESS;
    }
}
