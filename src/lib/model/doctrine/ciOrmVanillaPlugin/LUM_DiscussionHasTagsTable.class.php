<?php

/**
 * LUM_DiscussionHasTagsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LUM_DiscussionHasTagsTable extends PluginLUM_DiscussionHasTagsTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object LUM_DiscussionHasTagsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LUM_DiscussionHasTags');
    }
}