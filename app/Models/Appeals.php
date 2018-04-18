<?php

namespace Ddb\Models;

class Appeals extends \Phalcon\Mvc\Model
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
    protected $ask_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $awr_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=50, nullable=false)
     */
    protected $type;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $desc;

    /**
     *
     * @var string
     * @Column(type="string", length=11, nullable=true)
     */
    protected $mobile;

    /**
     *
     * @var string
     * @Column(type="string", length=10, nullable=true)
     */
    protected $longitude;

    /**
     *
     * @var string
     * @Column(type="string", length=10, nullable=true)
     */
    protected $latitude;

    /**
     *
     * @var integer
     * @Column(type="integer", length=6, nullable=false)
     */
    protected $points;

    /**
     *
     * @var integer
     * @Column(type="integer", length=6, nullable=false)
     */
    protected $updates;

    /**
     *
     * @var string
     * @Column(type="string", length=128, nullable=false)
     */
    protected $update_desc;

    /**
     *
     * @var integer
     * @Column(type="integer", length=128, nullable=false)
     */
    protected $status;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $awr_time;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $awr_cancel_time;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $awr_fin_time;

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
     * Method to set the value of field ask_id
     *
     * @param integer $ask_id
     * @return $this
     */
    public function setAskId($ask_id)
    {
        $this->ask_id = $ask_id;

        return $this;
    }

    /**
     * Method to set the value of field awr_id
     *
     * @param integer $awr_id
     * @return $this
     */
    public function setAwrId($awr_id)
    {
        $this->awr_id = $awr_id;

        return $this;
    }

    /**
     * Method to set the value of field type
     *
     * @param integer $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Method to set the value of field desc
     *
     * @param string $desc
     * @return $this
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;

        return $this;
    }

    /**
     * Method to set the value of field mobile
     *
     * @param string $mobile
     * @return $this
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Method to set the value of field longitude
     *
     * @param string $longitude
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Method to set the value of field latitude
     *
     * @param string $latitude
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Method to set the value of field points
     *
     * @param integer $points
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Method to set the value of field updates
     *
     * @param integer $updates
     * @return $this
     */
    public function setUpdates($updates)
    {
        $this->updates = $updates;

        return $this;
    }

    /**
     * Method to set the value of field update_desc
     *
     * @param string $update_desc
     * @return $this
     */
    public function setUpdateDesc($update_desc)
    {
        $this->update_desc = $update_desc;

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
     * Method to set the value of field awr_time
     *
     * @param string $awr_time
     * @return $this
     */
    public function setAwrTime($awr_time)
    {
        $this->awr_time = $awr_time;

        return $this;
    }

    /**
     * Method to set the value of field awr_cancel_time
     *
     * @param string $awr_cancel_time
     * @return $this
     */
    public function setAwrCancelTime($awr_cancel_time)
    {
        $this->awr_cancel_time = $awr_cancel_time;

        return $this;
    }

    /**
     * Method to set the value of field awr_fin_time
     *
     * @param string $awr_fin_time
     * @return $this
     */
    public function setAwrFinTime($awr_fin_time)
    {
        $this->awr_fin_time = $awr_fin_time;

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
     * Returns the value of field ask_id
     *
     * @return integer
     */
    public function getAskId()
    {
        return $this->ask_id;
    }

    /**
     * Returns the value of field awr_id
     *
     * @return integer
     */
    public function getAwrId()
    {
        return $this->awr_id;
    }

    /**
     * Returns the value of field type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the value of field desc
     *
     * @return string
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * Returns the value of field mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Returns the value of field longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Returns the value of field latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Returns the value of field points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Returns the value of field updates
     *
     * @return integer
     */
    public function getUpdates()
    {
        return $this->updates;
    }

    /**
     * Returns the value of field update_desc
     *
     * @return string
     */
    public function getUpdateDesc()
    {
        return $this->update_desc;
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
     * Returns the value of field awr_time
     *
     * @return string
     */
    public function getAwrTime()
    {
        return $this->awr_time;
    }

    /**
     * Returns the value of field awr_cancel_time
     *
     * @return string
     */
    public function getAwrCancelTime()
    {
        return $this->awr_cancel_time;
    }

    /**
     * Returns the value of field awr_fin_time
     *
     * @return string
     */
    public function getAwrFinTime()
    {
        return $this->awr_fin_time;
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
        $this->setSource("appeals");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'appeals';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Appeals[]|Appeals|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Appeals|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
