<?php

namespace Ddb\Models;

class Areas extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $district_code;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $district_name;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $city_code;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $city_name;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $province_code;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $province_name;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field district_code
     *
     * @param string $district_code
     * @return $this
     */
    public function setDistrictCode($district_code)
    {
        $this->district_code = $district_code;

        return $this;
    }

    /**
     * Method to set the value of field district_name
     *
     * @param string $district_name
     * @return $this
     */
    public function setDistrictName($district_name)
    {
        $this->district_name = $district_name;

        return $this;
    }

    /**
     * Method to set the value of field city_code
     *
     * @param string $city_code
     * @return $this
     */
    public function setCityCode($city_code)
    {
        $this->city_code = $city_code;

        return $this;
    }

    /**
     * Method to set the value of field city_name
     *
     * @param string $city_name
     * @return $this
     */
    public function setCityName($city_name)
    {
        $this->city_name = $city_name;

        return $this;
    }

    /**
     * Method to set the value of field province_code
     *
     * @param string $province_code
     * @return $this
     */
    public function setProvinceCode($province_code)
    {
        $this->province_code = $province_code;

        return $this;
    }

    /**
     * Method to set the value of field province_name
     *
     * @param string $province_name
     * @return $this
     */
    public function setProvinceName($province_name)
    {
        $this->province_name = $province_name;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field district_code
     *
     * @return string
     */
    public function getDistrictCode()
    {
        return $this->district_code;
    }

    /**
     * Returns the value of field district_name
     *
     * @return string
     */
    public function getDistrictName()
    {
        return $this->district_name;
    }

    /**
     * Returns the value of field city_code
     *
     * @return string
     */
    public function getCityCode()
    {
        return $this->city_code;
    }

    /**
     * Returns the value of field city_name
     *
     * @return string
     */
    public function getCityName()
    {
        return $this->city_name;
    }

    /**
     * Returns the value of field province_code
     *
     * @return string
     */
    public function getProvinceCode()
    {
        return $this->province_code;
    }

    /**
     * Returns the value of field province_name
     *
     * @return string
     */
    public function getProvinceName()
    {
        return $this->province_name;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("ddb");
        $this->setSource("areas");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'areas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Areas[]|Areas|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Areas|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
