<?php

namespace Ddb\Models;

/**
 * Cities
 * 
 * @package Ddb\Models
 * @autogenerated by Phalcon Developer Utils
 * @date 2018-04-25, 13:10:51
 * 
 * @method static static findFirstByCode($code)
 * @method static static[] findByCode($code)
 * @method static int countByCode($code)
 * @method static static findFirstByName($name)
 * @method static static[] findByName($name)
 * @method static int countByName($name)
 * @method static static findFirstByProvinceCode($province_code)
 * @method static static[] findByProvinceCode($province_code)
 * @method static int countByProvinceCode($province_code)
 */
class Cities extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $code;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $province_code;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return static
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field code
     *
     * @param string $code
     * @return static
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return static
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field province_code
     *
     * @param string $province_code
     * @return static
     */
    public function setProvinceCode($province_code)
    {
        $this->province_code = $province_code;

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
     * Returns the value of field code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cities';
    }

}
