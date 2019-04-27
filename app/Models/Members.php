<?php

namespace Ddb\Models;

/**
 * Members
 * 
 * @package Ddb\Models
 * @autogenerated by Phalcon Developer Utils
 * @date 2018-10-14, 14:14:55
 * 
 * @method static static findFirstByAvatarUrl($avatar_url)
 * @method static static[] findByAvatarUrl($avatar_url)
 * @method static int countByAvatarUrl($avatar_url)
 * @method static static findFirstByProvince($province)
 * @method static static[] findByProvince($province)
 * @method static int countByProvince($province)
 * @method static static findFirstByCity($city)
 * @method static static[] findByCity($city)
 * @method static int countByCity($city)
 * @method static static findFirstByDistrict($district)
 * @method static static[] findByDistrict($district)
 * @method static int countByDistrict($district)
 * @method static static findFirstByGender($gender)
 * @method static static[] findByGender($gender)
 * @method static int countByGender($gender)
 * @method static static findFirstByNickName($nick_name)
 * @method static static[] findByNickName($nick_name)
 * @method static int countByNickName($nick_name)
 * @method static static findFirstByRealName($real_name)
 * @method static static[] findByRealName($real_name)
 * @method static int countByRealName($real_name)
 * @method static static findFirstByMobile($mobile)
 * @method static static[] findByMobile($mobile)
 * @method static int countByMobile($mobile)
 * @method static static findFirstByPoints($points)
 * @method static static[] findByPoints($points)
 * @method static int countByPoints($points)
 * @method static static findFirstByType($type)
 * @method static static[] findByType($type)
 * @method static int countByType($type)
 * @method static static findFirstByAuthTime($auth_time)
 * @method static static[] findByAuthTime($auth_time)
 * @method static int countByAuthTime($auth_time)
 * @method static static findFirstByToken($token)
 * @method static static[] findByToken($token)
 * @method static int countByToken($token)
 * @method static static findFirstByTokenTime($token_time)
 * @method static static[] findByTokenTime($token_time)
 * @method static int countByTokenTime($token_time)
 * @method static static findFirstBySceneCode($scene_code)
 * @method static static[] findBySceneCode($scene_code)
 * @method static int countBySceneCode($scene_code)
 * @method static static findFirstByOpenId($open_id)
 * @method static static[] findByOpenId($open_id)
 * @method static int countByOpenId($open_id)
 * @method static static findFirstByPlatformOpenId($platform_open_id)
 * @method static static[] findByPlatformOpenId($platform_open_id)
 * @method static int countByPlatformOpenId($platform_open_id)
 * @method static static findFirstByUnionId($union_id)
 * @method static static[] findByUnionId($union_id)
 * @method static int countByUnionId($union_id)
 * @method static static findFirstByPrivilege($privilege)
 * @method static static[] findByPrivilege($privilege)
 * @method static int countByPrivilege($privilege)
 * @method static static findFirstByPrivilegeTime($privilege_time)
 * @method static static[] findByPrivilegeTime($privilege_time)
 * @method static int countByPrivilegeTime($privilege_time)
 * @method static static findFirstByCreatedAt($created_at)
 * @method static static[] findByCreatedAt($created_at)
 * @method static int countByCreatedAt($created_at)
 * @method static static findFirstByUpdatedAt($updated_at)
 * @method static static[] findByUpdatedAt($updated_at)
 * @method static int countByUpdatedAt($updated_at)
 */
class Members extends BaseModel
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
    protected $avatar_url;

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
     * @var integer
     */
    protected $gender;

    /**
     *
     * @var string
     */
    protected $nick_name;

    /**
     *
     * @var string
     */
    protected $real_name;

    /**
     *
     * @var string
     */
    protected $mobile;

    /**
     *
     * @var integer
     */
    protected $points;

    /**
     *
     * @var integer
     */
    protected $type;

    /**
     *
     * @var string
     */
    protected $auth_time;

    /**
     *
     * @var string
     */
    protected $token;

    /**
     *
     * @var string
     */
    protected $token_time;

    /**
     *
     * @var string
     */
    protected $scene_code;

    /**
     *
     * @var string
     */
    protected $open_id;

    /**
     *
     * @var string
     */
    protected $platform_open_id;

    /**
     *
     * @var string
     */
    protected $union_id;

    /**
     *
     * @var integer
     */
    protected $status;

    /**
     *
     * @var integer
     */
    protected $privilege;

    /**
     *
     * @var string
     */
    protected $privilege_time;

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
     * Method to set the value of field avatar_url
     *
     * @param string $avatar_url
     * @return static
     */
    public function setAvatarUrl($avatar_url)
    {
        $this->avatar_url = $avatar_url;

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
     * Method to set the value of field gender
     *
     * @param integer $gender
     * @return static
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Method to set the value of field nick_name
     *
     * @param string $nick_name
     * @return static
     */
    public function setNickName($nick_name)
    {
        $this->nick_name = $nick_name;

        return $this;
    }

    /**
     * Method to set the value of field real_name
     *
     * @param string $real_name
     * @return static
     */
    public function setRealName($real_name)
    {
        $this->real_name = $real_name;

        return $this;
    }

    /**
     * Method to set the value of field mobile
     *
     * @param string $mobile
     * @return static
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Method to set the value of field points
     *
     * @param integer $points
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
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
     * @return static
     */
    public function setOpenId($open_id)
    {
        $this->open_id = $open_id;

        return $this;
    }

    /**
     * Method to set the value of field platform_open_id
     *
     * @param string $platform_open_id
     * @return static
     */
    public function setPlatformOpenId($platform_open_id)
    {
        $this->platform_open_id = $platform_open_id;

        return $this;
    }

    /**
     * Method to set the value of field union_id
     *
     * @param string $union_id
     * @return static
     */
    public function setUnionId($union_id)
    {
        $this->union_id = $union_id;

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
     * Method to set the value of field privilege
     *
     * @param integer $privilege
     * @return static
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;

        return $this;
    }

    /**
     * Method to set the value of field privilege_time
     *
     * @param string $privilege_time
     * @return static
     */
    public function setPrivilegeTime($privilege_time)
    {
        $this->privilege_time = $privilege_time;

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
     * Returns the value of field avatar_url
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return $this->avatar_url;
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
     * Returns the value of field gender
     *
     * @return integer
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Returns the value of field nick_name
     *
     * @return string
     */
    public function getNickName()
    {
        return $this->nick_name;
    }

    /**
     * Returns the value of field real_name
     *
     * @return string
     */
    public function getRealName()
    {
        return $this->real_name;
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
     * @return integer
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
     * Returns the value of field platform_open_id
     *
     * @return string
     */
    public function getPlatformOpenId()
    {
        return $this->platform_open_id;
    }

    /**
     * Returns the value of field union_id
     *
     * @return string
     */
    public function getUnionId()
    {
        return $this->union_id;
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
     * Returns the value of field privilege
     *
     * @return integer
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * Returns the value of field privilege_time
     *
     * @return string
     */
    public function getPrivilegeTime()
    {
        return $this->privilege_time;
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
        return 'members';
    }

}
