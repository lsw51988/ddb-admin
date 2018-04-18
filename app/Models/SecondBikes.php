<?php

namespace Ddb\Models;

class SecondBikes extends \Phalcon\Mvc\Model
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
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $member_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $buy_time;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    protected $voltage;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    protected $brand_id;

    /**
     *
     * @var double
     * @Column(type="double", length=8, nullable=false)
     */
    protected $in_price;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    protected $in_status;

    /**
     *
     * @var double
     * @Column(type="double", length=8, nullable=false)
     */
    protected $out_price;

    /**
     *
     * @var double
     * @Column(type="double", length=8, nullable=true)
     */
    protected $deal_price;

    /**
     *
     * @var string
     * @Column(type="string", length=8, nullable=false)
     */
    protected $province;

    /**
     *
     * @var string
     * @Column(type="string", length=8, nullable=false)
     */
    protected $city;

    /**
     *
     * @var string
     * @Column(type="string", length=8, nullable=false)
     */
    protected $district;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $card_num;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    protected $extended;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    protected $status;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $deal_time;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $created_at;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $updated_at;

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
     * Method to set the value of field member_id
     *
     * @param integer $member_id
     * @return $this
     */
    public function setMemberId($member_id)
    {
        $this->member_id = $member_id;

        return $this;
    }

    /**
     * Method to set the value of field buy_time
     *
     * @param string $buy_time
     * @return $this
     */
    public function setBuyTime($buy_time)
    {
        $this->buy_time = $buy_time;

        return $this;
    }

    /**
     * Method to set the value of field voltage
     *
     * @param integer $voltage
     * @return $this
     */
    public function setVoltage($voltage)
    {
        $this->voltage = $voltage;

        return $this;
    }

    /**
     * Method to set the value of field brand_id
     *
     * @param integer $brand_id
     * @return $this
     */
    public function setBrandId($brand_id)
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    /**
     * Method to set the value of field in_price
     *
     * @param double $in_price
     * @return $this
     */
    public function setInPrice($in_price)
    {
        $this->in_price = $in_price;

        return $this;
    }

    /**
     * Method to set the value of field in_status
     *
     * @param integer $in_status
     * @return $this
     */
    public function setInStatus($in_status)
    {
        $this->in_status = $in_status;

        return $this;
    }

    /**
     * Method to set the value of field out_price
     *
     * @param double $out_price
     * @return $this
     */
    public function setOutPrice($out_price)
    {
        $this->out_price = $out_price;

        return $this;
    }

    /**
     * Method to set the value of field deal_price
     *
     * @param double $deal_price
     * @return $this
     */
    public function setDealPrice($deal_price)
    {
        $this->deal_price = $deal_price;

        return $this;
    }

    /**
     * Method to set the value of field province
     *
     * @param string $province
     * @return $this
     */
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Method to set the value of field city
     *
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Method to set the value of field district
     *
     * @param string $district
     * @return $this
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Method to set the value of field card_num
     *
     * @param string $card_num
     * @return $this
     */
    public function setCardNum($card_num)
    {
        $this->card_num = $card_num;

        return $this;
    }

    /**
     * Method to set the value of field extended
     *
     * @param integer $extended
     * @return $this
     */
    public function setExtended($extended)
    {
        $this->extended = $extended;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param integer $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Method to set the value of field deal_time
     *
     * @param string $deal_time
     * @return $this
     */
    public function setDealTime($deal_time)
    {
        $this->deal_time = $deal_time;

        return $this;
    }

    /**
     * Method to set the value of field created_at
     *
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Method to set the value of field updated_at
     *
     * @param string $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

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
     * Returns the value of field member_id
     *
     * @return integer
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     * Returns the value of field buy_time
     *
     * @return string
     */
    public function getBuyTime()
    {
        return $this->buy_time;
    }

    /**
     * Returns the value of field voltage
     *
     * @return integer
     */
    public function getVoltage()
    {
        return $this->voltage;
    }

    /**
     * Returns the value of field brand_id
     *
     * @return integer
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Returns the value of field in_price
     *
     * @return double
     */
    public function getInPrice()
    {
        return $this->in_price;
    }

    /**
     * Returns the value of field in_status
     *
     * @return integer
     */
    public function getInStatus()
    {
        return $this->in_status;
    }

    /**
     * Returns the value of field out_price
     *
     * @return double
     */
    public function getOutPrice()
    {
        return $this->out_price;
    }

    /**
     * Returns the value of field deal_price
     *
     * @return double
     */
    public function getDealPrice()
    {
        return $this->deal_price;
    }

    /**
     * Returns the value of field province
     *
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Returns the value of field city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Returns the value of field district
     *
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Returns the value of field card_num
     *
     * @return string
     */
    public function getCardNum()
    {
        return $this->card_num;
    }

    /**
     * Returns the value of field extended
     *
     * @return integer
     */
    public function getExtended()
    {
        return $this->extended;
    }

    /**
     * Returns the value of field status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns the value of field deal_time
     *
     * @return string
     */
    public function getDealTime()
    {
        return $this->deal_time;
    }

    /**
     * Returns the value of field created_at
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Returns the value of field updated_at
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("ddb");
        $this->setSource("second_bikes");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'second_bikes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return SecondBikes[]|SecondBikes|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return SecondBikes|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
