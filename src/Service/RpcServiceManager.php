<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Service;

class RpcServiceManager
{
    /**
     * @var array
     */
    private $apiServices = [];

    /**
     * @return array
     */
    public function getServices()
    {
        return $this->apiServices;
    }

    /**
     * @param $apiService
     * @return $this
     */
    public function addApiService($apiService)
    {
        $this->apiServices[get_class($apiService)] = $apiService;
        return $this;
    }
}