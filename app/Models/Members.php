<?php

namespace Ddb\Models;

class Members extends \Phalcon\Mvc\Model
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
     * @Column(type="string", length=160, nullable=false)
     */
    protected $avatarUrl;

    /**
     *
     * @var string
     * @Column(type="string", length=6, nullable=false)
     */
    protected $province;

    /**
     *
     * @var string
     * @Column(type="string", length=6, nullable=false)
     */
    protected $city;

    /**
     *
     * @var string
     * @Column(type="string", length=6, nullable=false)
     */
    protected $district;

    /**
     *
     * @var string
     * @Column(type="string", length=10, nullable=false)
     */
    protected $country;

    /**
     *
     * @var string
     * @Column(type="string", length=10, nullable=false)
     */
    protected $language;

    /**
     *
     * @var integer
     * @Column(type="integer", length=2, nullable=false)
     */
    protected $gender;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $nickName;

    /**
     *
     * @var string
     * @Column(type="string", length=11, nullable=true)
     */
    protected $mobile;

    /**
     *
     * @var string
     * @Column(type="string", length=4, nullable=false)
     */
    protected $points;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    protected $type;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $auth_time;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=true)
     */
    protected $token;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $token_time;

    /**
     *
     * @var string
     * @Column(type="string", length=6, nullable=true)
     */
    protected $scene_code;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=true)
     */
    protected $open_id;

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
     * Method to set the value of field avatarUrl
     *
     * @param string $avatarUrl
     * @return $this
     */
    public function setAvatarUrl($avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;

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
     * Method to set the value of field country
     *
     * @param string $country
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Method to set the value of field language
     *
     * @param string $language
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Method to set the value of field gender
     *
     * @param integer $gender
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Method to set the value of field nickName
     *
     * @param string $nickName
     * @return $this
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;

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
     * Method to set the value of field points
     *
     * @param string $points
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;

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
     * Method to set the value of field auth_time
     *
     * @param string $auth_time
     * @return $this
     */
    public function setAuthTime($auth_time)
    {
        $this->auth_time = $auth_time;

        return $this;
    }

    /**
     * Method to set the value of field token
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Method to set the value of field token_time
     *
     * @param string $token_time
     * @return $this
     */
    public function setTokenTime($token_time)
    {
        $this->token_time = $token_time;

        return $this;
    }

    /**
     * Method to set the value of field scene_code
     *
     * @param string $scene_code
     * @return $this
     */
    public function setSceneCode($scene_code)
    {
        $this->scene_code = $scene_code;

        return $this;
    }

    /**
     * Method to set the value of field open_id
     *
     * @param string $open_id
     * @return $this
     */
    public function setOpenId($open_id)
    {
        $this->open_id = $open_id;

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
     * Returns the value of field avatarUrl
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
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
     * Returns the value of field country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Returns the value of field language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Returns the value of field gender
     *
     * @return integer
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Returns the value of field nickName
     *
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
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
     * Returns the value of field points
     *
     * @return string
     */
    public function getPoints()
    {
        return $this->points;
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
     * Returns the value of field auth_time
     *
     * @return string
     */
    public function getAuthTime()
    {
        return $this->auth_time;
    }

    /**
     * Returns the value of field token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Returns the value of field token_time
     *
     * @return string
     */
    public function getTokenTime()
    {
        return $this->token_time;
    }

    /**
     * Returns the value of field scene_code
     *
     * @return string
     */
    public function getSceneCode()
    {
        return $this->scene_code;
    }

    /**
     * Returns the value of field open_id
     *
     * @return string
     */
    public function getOpenId()
    {
        return $this->open_id;
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
        $this->setSource("members");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'members';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Members[]|Members|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Members|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
