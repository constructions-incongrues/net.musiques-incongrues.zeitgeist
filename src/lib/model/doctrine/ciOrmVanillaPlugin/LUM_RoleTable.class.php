<?php

/**
 * LUM_RoleTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LUM_RoleTable extends PluginLUM_RoleTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object LUM_RoleTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LUM_Role');
    }
}