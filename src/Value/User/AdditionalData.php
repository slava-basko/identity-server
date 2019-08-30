<?php

namespace App\Value\User;

class AdditionalData
{
    /**
     * @var string|null
     */
    private $ip = null;
    /**
     * @var string|null
     */
    private $userAgent = null;

    /**
     * AdditionalData constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->ip = isset($options['ip']) ? $options['ip'] : null;
        $this->userAgent = isset($options['userAgent']) ? $options['userAgent'] : null;
    }

    /**
     * @return string|null
     */
    public function getIp()
    {
        return $this->ip;
    }
    
    /**
     * @return string|null
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

}
