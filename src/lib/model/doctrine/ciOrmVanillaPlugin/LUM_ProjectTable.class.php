<?php

/**
 * LUM_ProjectTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LUM_ProjectTable extends PluginLUM_ProjectTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object LUM_ProjectTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LUM_Project');
    }
}