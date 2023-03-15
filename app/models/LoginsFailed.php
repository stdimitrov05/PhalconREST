<?php

namespace App\Models;

use Phalcon\Mvc\Model;

/**
 * FailedLogins
 * This model registers unsuccessfull logins registered and non-registered users have made
 */
class LoginsFailed extends Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $user_id;

    /**
     *
     * @var string
     * @Column(type="varchar", length=39, nullable=true)
     */
    public $ip_address;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $user_agent;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $attempted;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('failed_logins');
    }
}