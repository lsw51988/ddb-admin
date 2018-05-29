<?php

namespace Ddb\Models;

/**
 * LostBikes
 * 
 * @package Ddb\Models
 * @autogenerated by Phalcon Developer Utils
 * @date 2018-05-29, 10:37:29
 * 
 * @method static static findFirstByMemberId($member_id)
 * @method static static[] findByMemberId($member_id)
 * @method static int countByMemberId($member_id)
 * @method static static findFirstByMemberBikeId($member_bike_id)
 * @method static static[] findByMemberBikeId($member_bike_id)
 * @method static int countByMemberBikeId($member_bike_id)
 * @method static static findFirstByLostDate($lost_date)
 * @method static static[] findByLostDate($lost_date)
 * @method static int countByLostDate($lost_date)
 * @method static static findFirstByProvince($province)
 * @method static static[] findByProvince($province)
 * @method static int countByProvince($province)
 * @method static static findFirstByCity($city)
 * @method static static[] findByCity($city)
 * @method static int countByCity($city)
 * @method static static findFirstByDistrict($district)
 * @method static static[] findByDistrict($district)
 * @method static int countByDistrict($district)
 * @method static static findFirstByAddress($address)
 * @method static static[] findByAddress($address)
 * @method static int countByAddress($address)
 * @method static static findFirstByMemo($memo)
 * @method static static[] findByMemo($memo)
 * @method static int countByMemo($memo)
 * @method static static findFirstByRewards($rewards)
 * @method static static[] findByRewards($rewards)
 * @method static int countByRewards($rewards)
 * @method static static findFirstByContactTime($contact_time)
 * @method static static[] findByContactTime($contact_time)
 * @method static int countByContactTime($contact_time)
 * @method static static findFirstByFinishTime($finish_time)
 * @method static static[] findByFinishTime($finish_time)
 * @method static int countByFinishTime($finish_time)
 * @method static static findFirstByFailTime($fail_time)
 * @method static static[] findByFailTime($fail_time)
 * @method static int countByFailTime($fail_time)
 * @method static static findFirstByCreatedAt($created_at)
 * @method static static[] findByCreatedAt($created_at)
 * @method static int countByCreatedAt($created_at)
 * @method static static findFirstByUpdatedAt($updated_at)
 * @method static static[] findByUpdatedAt($updated_at)
 * @method static int countByUpdatedAt($updated_at)
 */
class LostBikes extends BaseModel
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
     * @var integer
     */
    protected $member_bike_id;

    /**
     *
     * @var string
     */
    protected $lost_date;

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
    protected $address;

    /**
     *
     * @var string
     */
    protected $memo;

    /**
     *
     * @var integer
     */
    protected $rewards;

    /**
     *
     * @var string
     */
    protected $contact_time;

    /**
     *
     * @var string
     */
    protected $finish_time;

    /**
     *
     * @var string
     */
    protected $fail_time;

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
     * Method to set the value of field member_bike_id
     *
     * @param integer $member_bike_id
     * @return static
     */
    public function setMemberBikeId($member_bike_id)
    {
        $this->member_bike_id = $member_bike_id;

        return $this;
    }

    /**
     * Method to set the value of field lost_date
     *
     * @param string $lost_date
     * @return static
     */
    public function setLostDate($lost_date)
    {
        $this->lost_date = $lost_date;

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
     * Method to set the value of field address
     *
     * @param string $address
     * @return static
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Method to set the value of field memo
     *
     * @param string $memo
     * @return static
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;

        return $this;
    }

    /**
     * Method to set the value of field rewards
     *
     * @param integer $rewards
     * @return static
     */
    public function setRewards($rewards)
    {
        $this->rewards = $rewards;

        return $this;
    }

    /**
     * Method to set the value of field contact_time
     *
     * @param string $contact_time
     * @return static
     */
    public function setContactTime($contact_time)
    {
        $this->contact_time = $contact_time;

        return $this;
    }

    /**
     * Method to set the value of field finish_time
     *
     * @param string $finish_time
     * @return static
     */
    public function setFinishTime($finish_time)
    {
        $this->finish_time = $finish_time;

        return $this;
    }

    /**
     * Method to set the value of field fail_time
     *
     * @param string $fail_time
     * @return static
     */
    public function setFailTime($fail_time)
    {
        $this->fail_time = $fail_time;

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
     * Returns the value of field member_bike_id
     *
     * @return integer
     */
    public function getMemberBikeId()
    {
        return $this->member_bike_id;
    }

    /**
     * Returns the value of field lost_date
     *
     * @return string
     */
    public function getLostDate()
    {
        return $this->lost_date;
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
     * Returns the value of field address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Returns the value of field memo
     *
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * Returns the value of field rewards
     *
     * @return integer
     */
    public function getRewards()
    {
        return $this->rewards;
    }

    /**
     * Returns the value of field contact_time
     *
     * @return string
     */
    public function getContactTime()
    {
        return $this->contact_time;
    }

    /**
     * Returns the value of field finish_time
     *
     * @return string
     */
    public function getFinishTime()
    {
        return $this->finish_time;
    }

    /**
     * Returns the value of field fail_time
     *
     * @return string
     */
    public function getFailTime()
    {
        return $this->fail_time;
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
        return 'lost_bikes';
    }

}
