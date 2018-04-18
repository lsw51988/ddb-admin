<?php

namespace Ddb\Models;

class AppealAnswers extends \Phalcon\Mvc\Model
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
    protected $appeal_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $awr_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    protected $type;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    protected $status;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $cancel_reason;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $cancel_time;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $finish_time;

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
     * Method to set the value of field appeal_id
     *
     * @param integer $appeal_id
     * @return $this
     */
    public function setAppealId($appeal_id)
    {
        $this->appeal_id = $appeal_id;

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
     * Method to set the value of field cancel_reason
     *
     * @param string $cancel_reason
     * @return $this
     */
    public function setCancelReason($cancel_reason)
    {
        $this->cancel_reason = $cancel_reason;

        return $this;
    }

    /**
     * Method to set the value of field cancel_time
     *
     * @param string $cancel_time
     * @return $this
     */
    public function setCancelTime($cancel_time)
    {
        $this->cancel_time = $cancel_time;

        return $this;
    }

    /**
     * Method to set the value of field finish_time
     *
     * @param string $finish_time
     * @return $this
     */
    public function setFinishTime($finish_time)
    {
        $this->finish_time = $finish_time;

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
     * Returns the value of field appeal_id
     *
     * @return integer
     */
    public function getAppealId()
    {
        return $this->appeal_id;
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
     * Returns the value of field status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns the value of field cancel_reason
     *
     * @return string
     */
    public function getCancelReason()
    {
        return $this->cancel_reason;
    }

    /**
     * Returns the value of field cancel_time
     *
     * @return string
     */
    public function getCancelTime()
    {
        return $this->cancel_time;
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
        $this->setSource("appeal_answers");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'appeal_answers';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AppealAnswers[]|AppealAnswers|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AppealAnswers|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
