<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 03/03/14
 * Time: 10:45
 */

namespace SuchTable;


interface TableFactoryAwareInterface
{
    /**
     * Set a table factory into the object
     *
     * @param Factory $factory
     */
    public function setTableFactory(Factory $factory);
}
