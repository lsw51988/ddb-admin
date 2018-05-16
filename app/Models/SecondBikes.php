<?php

namespace Ddb\Models;

/**
 * SecondBikes
 * 
 * @package Ddb\Models
 * @autogenerated by Phalcon Developer Utils
 * @date 2018-05-17, 00:56:21
 * 
 * @method static static findFirstByMemberId($member_id)
 * @method static static[] findByMemberId($member_id)
 * @method static int countByMemberId($member_id)
 * @method static static findFirstByBuyDate($buy_date)
 * @method static static[] findByBuyDate($buy_date)
 * @method static int countByBuyDate($buy_date)
 * @method static static findFirstByVoltage($voltage)
 * @method static static[] findByVoltage($voltage)
 * @method static int countByVoltage($voltage)
 * @method static static findFirstByBrandId($brand_id)
 * @method static static[] findByBrandId($brand_id)
 * @method static int countByBrandId($brand_id)
 * @method static static findFirstByBrandName($brand_name)
 * @method static static[] findByBrandName($brand_name)
 * @method static int countByBrandName($brand_name)
 * @method static static findFirstByInPrice($in_price)
 * @method static static[] findByInPrice($in_price)
 * @method static int countByInPrice($in_price)
 * @method static static findFirstByInStatus($in_status)
 * @method static static[] findByInStatus($in_status)
 * @method static int countByInStatus($in_status)
 * @method static static findFirstByOutPrice($out_price)
 * @method static static[] findByOutPrice($out_price)
 * @method static int countByOutPrice($out_price)
 * @method static static findFirstByDealPrice($deal_price)
 * @method static static[] findByDealPrice($deal_price)
 * @method static int countByDealPrice($deal_price)
 * @method static static findFirstByProvince($province)
 * @method static static[] findByProvince($province)
 * @method static int countByProvince($province)
 * @method static static findFirstByCity($city)
 * @method static static[] findByCity($city)
 * @method static int countByCity($city)
 * @method static static findFirstByDistrict($district)
 * @method static static[] findByDistrict($district)
 * @method static int countByDistrict($district)
 * @method static static findFirstByDetailAddr($detail_addr)
 * @method static static[] findByDetailAddr($detail_addr)
 * @method static int countByDetailAddr($detail_addr)
 * @method static static findFirstByNumber($number)
 * @method static static[] findByNumber($number)
 * @method static int countByNumber($number)
 * @method static static findFirstByExtended($extended)
 * @method static static[] findByExtended($extended)
 * @method static int countByExtended($extended)
 * @method static static findFirstByRemark($remark)
 * @method static static[] findByRemark($remark)
 * @method static int countByRemark($remark)
 * @method static static findFirstByDealTime($deal_time)
 * @method static static[] findByDealTime($deal_time)
 * @method static int countByDealTime($deal_time)
 * @method static static findFirstByCreatedAt($created_at)
 * @method static static[] findByCreatedAt($created_at)
 * @method static int countByCreatedAt($created_at)
 * @method static static findFirstByUpdatedAt($updated_at)
 * @method static static[] findByUpdatedAt($updated_at)
 * @method static int countByUpdatedAt($updated_at)
 */
class SecondBikes extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $member_id;

    /**
     *
     * @var string
     */
    protected $buy_date;

    /**
     *
     * @var integer
     */
    protected $voltage;

    /**
     *
     * @var integer
     */
    protected $brand_id;

    /**
     *
     * @var string
     */
    protected $brand_name;

    /**
     *
     * @var double
     */
    protected $in_price;

    /**
     *
     * @var integer
     */
    protected $in_status;

    /**
     *
     * @var double
     */
    protected $out_price;

    /**
     *
     * @var double
     */
    protected $deal_price;

    /**
     *
     * @var string
     */
    protected $province;

    /**
     *
     * @var string
     */
    protected $city;

    /**
     *
     * @var string
     */
    protected $district;

    /**
     *
     * @var string
     */
    protected $detail_addr;

    /**
     *
     * @var string
     */
    protected $number;

    /**
     *
     * @var integer
     */
    protected $extended;

    /**
     *
     * @var string
     */
    protected $remark;

    /**
     *
     * @var integer
     */
    protected $status;

    /**
     *
     * @var string
     */
    protected $deal_time;

    /**
     *
     * @var string
     */
    protected $created_at;

    /**
     *
     * @var string
     */
    protected $updated_at;

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
     * Method to set the value of field member_id
     *
     * @param integer $member_id
     * @return static
     */
    public function setMemberId($member_id)
    {
        $this->member_id = $member_id;

        return $this;
    }

    /**
     * Method to set the value of field buy_date
     *
     * @param string $buy_date
     * @return static
     */
    public function setBuyDate($buy_date)
    {
        $this->buy_date = $buy_date;

        return $this;
    }

    /**
     * Method to set the value of field voltage
     *
     * @param integer $voltage
     * @return static
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
     * @return static
     */
    public function setBrandId($brand_id)
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    /**
     * Method to set the value of field brand_name
     *
     * @param string $brand_name
     * @return static
     */
    public function setBrandName($brand_name)
    {
        $this->brand_name = $brand_name;

        return $this;
    }

    /**
     * Method to set the value of field in_price
     *
     * @param double $in_price
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Method to set the value of field detail_addr
     *
     * @param string $detail_addr
     * @return static
     */
    public function setDetailAddr($detail_addr)
    {
        $this->detail_addr = $detail_addr;

        return $this;
    }

    /**
     * Method to set the value of field number
     *
     * @param string $number
     * @return static
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Method to set the value of field extended
     *
     * @param integer $extended
     * @return static
     */
    public function setExtended($extended)
    {
        $this->extended = $extended;

        return $this;
    }

    /**
     * Method to set the value of field remark
     *
     * @param string $remark
     * @return static
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param integer $status
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * Returns the value of field buy_date
     *
     * @return string
     */
    public function getBuyDate()
    {
        return $this->buy_date;
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
     * Returns the value of field brand_name
     *
     * @return string
     */
    public function getBrandName()
    {
        return $this->brand_name;
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
     * Returns the value of field detail_addr
     *
     * @return string
     */
    public function getDetailAddr()
    {
        return $this->detail_addr;
    }

    /**
     * Returns the value of field number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
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
     * Returns the value of field remark
     *
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
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
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'second_bikes';
    }

}
