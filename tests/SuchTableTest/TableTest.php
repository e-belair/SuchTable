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
    public function testCreateTable()
    {
        $table = new Table();
        $this->assertInstanceOf('SuchTable\TableInterface', $table);
    }
}
