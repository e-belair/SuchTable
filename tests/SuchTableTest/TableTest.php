<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 28/06/14
 * Time: 09:15
 */

namespace SuchTableTest;

use PHPUnit_Framework_TestCase;
use SuchTable\Table;

class TableTest extends PHPUnit_Framework_TestCase
{
    /**
     * Base test, be sure that defaults params are loaded
     */
    public function testCreateTable()
    {
        $table = new Table();
        $this->assertInstanceOf('SuchTable\TableInterface', $table);
        $this->assertEquals(1, $table->getParam('page'));
        $this->assertEquals('ASC', $table->getParam('way'));
        $this->assertEquals(30, $table->getParam('itemsPerPage'));
    }
}
