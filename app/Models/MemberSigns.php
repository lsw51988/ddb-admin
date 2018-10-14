<?php

namespace Ddb\Models;

/**
 * MemberSigns
 * 
 * @package Ddb\Models
 * @autogenerated by Phalcon Developer Utils
 * @date 2018-10-14, 14:08:22
 * 
 * @method static static findFirstByMemberId($member_id)
 * @method static static[] findByMemberId($member_id)
 * @method static int countByMemberId($member_id)
 * @method static static findFirstByDay($day)
 * @method static static[] findByDay($day)
 * @method static int countByDay($day)
 * @method static static findFirstByWeek($week)
 * @method static static[] findByWeek($week)
 * @method static int countByWeek($week)
 * @method static static findFirstByCreatedAt($created_at)
 * @method static static[] findByCreatedAt($created_at)
 * @method static int countByCreatedAt($created_at)
 * @method static static findFirstByUpdatedAt($updated_at)
 * @method static static[] findByUpdatedAt($updated_at)
 * @method static int countByUpdatedAt($updated_at)
 */
class MemberSigns extends BaseModel
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
    protected $day;

    /**
     *
     * @var integer
     */
    protected $week;

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
     * Method to set the value of field day
     *
     * @param string $day
     * @return static
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Method to set the value of field week
     *
     * @param integer $week
     * @return static
     */
    public function setWeek($week)
    {
        $this->week = $week;

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
     * Returns the value of field day
     *
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Returns the value of field week
     *
     * @return integer
     */
    public function getWeek()
    {
        return $this->week;
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
        return 'member_signs';
    }

}
