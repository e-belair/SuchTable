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
    /**
     * @see geType()
     * @var string
     */
    protected $type = '';

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
     * @var array
     */
    protected $params = array();

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        // @todo get defaults params from config
        $this->setParams([
            'way' => 'ASC',
            'page' => 1,
            'itemsPerPage' => 30
        ]);
    }

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
     * @return Form
     */
    public function getForm()
    {
        if ($this->form === null) {
            $this->setForm(new Form($this));
        }
        return $this->form;
    }

    /**
     * @param Form $form
     *
     * @return Table
     */
    public function setForm(Form $form)
    {
        $this->form = $form;
        return $this;
    }

    /**
     * @return TableInterface
     */
    public function prepare()
    {
        return parent::prepare();
    }

    /**
     * @param $param
     *
     * @return null|string
     */
    public function getParam($param)
    {
        if (empty($this->params[$param])) {
            if ($param == 'order') {
                $this->params['order'] = key($this->elements);
                return $this->params['order'];
            }
            return null;
        }

        return $this->params[$param];
    }

    /**
     * @param $param
     * @param $value
     *
     * @return Table
     */
    public function setParam($param, $value)
    {
        $this->params[$param] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     *
     * @return Table
     */
    public function setParams(array $params = array())
    {
        if (!isset($params[$this->getParamsKey()])) {
            $params[$this->getParamsKey()] = $params;
        }
        $form = $this->getForm();
        $form->setData($params);
        if (!$form->isValid()) {
            return $this;
        }

        $this->params = array_merge(
            $form->getData()[$this->getParamsKey()],
            $form->getData()[$this->getElementsKey()]
        );

        return $this;
    }

    /**
     * @return string
     */
    public function getParamsKey()
    {
        return $this->getName() . '-params';
    }

    /**
     * @return string
     */
    public function getElementsKey()
    {
        return $this->getName() . '-elements';
    }
}
