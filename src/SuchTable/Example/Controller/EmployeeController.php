<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 27/06/14
 * Time: 16:55
 */

namespace SuchTable\Example\Controller;


use Doctrine\ORM\EntityManager;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use SuchTable\Example\Table\EmployeeListTable;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class EmployeeController extends AbstractActionController
{
    public function indexAction()
    {
        $employeeListTable = new EmployeeListTable();
        //$employeeListTable->setParam('itemsPerPage', 5);

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $employeeListTable->setParams((array) $request->getPost());
        }

        /** @var EntityManager $em */
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_suchTable');
        $qb = $em->createQueryBuilder()
            ->select('e', 't')
            ->from('SuchTable\Example\Entity\Employees', 'e')
            ->leftJoin('e.titles', 't')
            ->orderBy('e.'.$employeeListTable->getParam('order'), $employeeListTable->getParam('way'));

        if ($id = $employeeListTable->getParam('id')) {
            $qb->where('e.id = :id')->setParameter('id', $id);
        }
        if ($firstname = $employeeListTable->getParam('firstName')) {
            $qb->where($qb->expr()->like('e.firstName', $qb->expr()->literal("%{$firstname}%")));
        }
        if ($lastname = $employeeListTable->getParam('lastName')) {
            $qb->where($qb->expr()->like('e.lastName', $qb->expr()->literal("%{$lastname}%")));
        }
        $employees = new Paginator(new DoctrinePaginator(new \Doctrine\ORM\Tools\Pagination\Paginator($qb)));
        $employees->setCurrentPageNumber($employeeListTable->getParam('page'));
        $employeeListTable->setData($employees)
            ->getPaginator()
            ->setItemCountPerPage($employeeListTable->getParam('itemsPerPage'))
            ->setCurrentPageNumber($employeeListTable->getParam('page'));

        return new ViewModel([
            'table' => $employeeListTable
        ]);
    }
}
