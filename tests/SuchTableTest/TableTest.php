<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 28/06/14
 * Time: 09:15
 */

namespace SuchTableTest;

use Doctrine\ORM\EntityManager;
use PHPUnit_Framework_TestCase;
use SuchTable\Example\Table\EmployeeListTable;
use SuchTable\Table;
use Zend\ServiceManager\ServiceManager;
use Zend\Test\Util\ModuleLoader;

class TableTest extends PHPUnit_Framework_TestCase
{
    /** @var  ModuleLoader */
    protected $moduleLoader;

    /**
     * @return ModuleLoader
     */
    public function getModuleLoader()
    {
        if (null === $this->moduleLoader) {
            $this->moduleLoader = new ModuleLoader(include __DIR__ . '/../TestConfiguration.php');
        }

        return $this->moduleLoader;
    }

    /**
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->getModuleLoader()->getServiceManager();
    }

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

    public function testSetData()
    {
        $table = new EmployeeListTable();
        /** @var EntityManager $em */
        $em = $this->getServiceManager()->get('doctrine.entitymanager.orm_suchTable');
        $qb = $em->createQueryBuilder()
            ->select('e', 't')
            ->from('SuchTable\Example\Entity\Employees', 'e')
            ->leftJoin('e.titles', 't')
            ->setMaxResults(30);

        $table->setData($qb->getQuery()->getResult());
        $this->assertTrue(is_array($table->getData()));
    }
}
