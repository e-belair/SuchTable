<?php
namespace SuchTable\Example\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Salaries
 *
 * @ORM\Table(name="salaries", indexes={@ORM\Index(name="emp_no", columns={"employee"})})
 * @ORM\Entity
 */
class Salaries
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="from_date", type="date", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $fromDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="salary", type="integer", nullable=false)
     */
    private $salary;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="to_date", type="date", nullable=false)
     */
    private $toDate;

    /**
     * @var \Employees
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Employees")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="employee", referencedColumnName="id")
     * })
     */
    private $employee;

    /**
     * @return Employees
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param Employees $employee
     *
     * @return Salaries
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * @param DateTime $fromDate
     *
     * @return Salaries
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param int $salary
     *
     * @return Salaries
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * @param DateTime $toDate
     *
     * @return Salaries
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
        return $this;
    }


}
