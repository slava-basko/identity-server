<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Controller;

use App\Service\RpcServiceManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Zend\Json\Server\Smd;
use Symfony\Component\HttpFoundation\Response;
use Zend\Server\AbstractServer;

class ApiController extends AbstractController
{
    /**
     * @var RpcServiceManager
     */
    private $rpcServiceManager;
    /**
     * @var AbstractServer
     */
    private $server;

    /**
     * ApiController constructor.
     * @param RpcServiceManager $rpcServiceManager
     * @param AbstractServer $server
     */
    public function __construct(
        RpcServiceManager $rpcServiceManager,
        AbstractServer $server
    )
    {
        $this->rpcServiceManager = $rpcServiceManager;
        $this->server = $server;
    }

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function index(Request $request)
    {
        $this->server->setEnvelope(Smd::ENV_JSONRPC_2);
        $this->server->setReturnResponse(true);

        foreach ($this->rpcServiceManager->getServices() as $name => $apiService) {
            $implementedInterfaces = class_implements($name);
            $jsonRpcNamespace = array_shift($implementedInterfaces);
            $this->server->setClass($apiService, $jsonRpcNamespace);
        }

        if ($request->isMethod('get')) {
            return new JsonResponse($this->server->getServiceMap()->toArray());
        }

        return new Response($this->server->handle(), 200, [
            'content-type' => 'application/json'
        ]);
    }
}
