<?php

/**
 * LUM_IpHistoryTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LUM_IpHistoryTable extends PluginLUM_IpHistoryTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object LUM_IpHistoryTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LUM_IpHistory');
    }
}