<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 16:17
 */

namespace SuchTable;


use Zend\Form\FormInterface;
use Zend\Paginator\Paginator;
use Zend\Stdlib\PriorityQueue;

class Table extends BaseElement implements TableInterface
{
    protected $attributes = array(
        'class' => 'table table-bordered table-striped'
    );

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * @todo custom paginator?
     *
     * @param array|\ArrayAccess|\Traversable|Paginator $data
     * @return mixed|TableInterface|void
     */
    public function setData($data)
    {
        if ($data instanceof Paginator) {
            $this->setPaginator($data);
        }

        return parent::setData($data);
    }

    /**
     * @return Paginator
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * @param Paginator $paginator
     *
     * @return Table
     */
    public function setPaginator(Paginator $paginator)
    {
        $this->paginator = $paginator;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasPaginator()
    {
        return $this->paginator !== null;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param FormInterface $form
     *
     * @return Table
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;
        return $this;
    }
}
