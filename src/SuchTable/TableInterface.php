<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 01/03/14
 * Time: 19:45
 */

namespace SuchTable;


use Zend\Form\FormInterface;
use Zend\Paginator\Paginator;

interface TableInterface extends BaseInterface
{
    /**
     * @param Paginator $paginator
     *
     * @return TableInterface
     */
    public function setPaginator(Paginator $paginator);

    /**
     * @return Paginator
     */
    public function getPaginator();

    /**
     * @return bool
     */
    public function hasPaginator();

    /**
     * @return FormInterface
     */
    public function getForm();

    /**
     * @param Form $form
     *
     * @return TableInterface
     */
    public function setForm(Form $form);

    /**
     * @return string
     */
    public function getParamsKey();

    /**
     * @return string
     */
    public function getElementsKey();

    /**
     * @param string $param
     *
     * @return string
     */
    public function getParam($param);

    /**
     * @param $param
     * @param $value
     *
     * @return Table
     */
    public function setParam($param, $value);

    /**
     * @return array
     */
    public function getParams();

    /**
     * @param array $params
     *
     * @return TableInterface
     */
    public function setParams(array $params = array());
}
