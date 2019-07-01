<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Controller;

use App\Server\JsonRpcServer;
use App\Service\RpcServiceManager;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Zend\Json\Server\Smd;

class ApiController extends AbstractController
{
    /**
     * @var RpcServiceManager
     */
    private $rpcServiceManager;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ApiController constructor.
     * @param RpcServiceManager $rpcServiceManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        RpcServiceManager $rpcServiceManager,
        LoggerInterface $logger
    )
    {
        $this->rpcServiceManager = $rpcServiceManager;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @return \App\Http\JsonResponse|null|JsonResponse|\Zend\Json\Server\Response
     */
    public function index(Request $request)
    {
        $server = new JsonRpcServer();
        $server->setEnvelope(Smd::ENV_JSONRPC_2);
        $server->setReturnResponse(true);

        foreach ($this->rpcServiceManager->getServices() as $name => $apiService) {
            $implementedInterfaces = class_implements($name);
            $jsonRpcNamespace = array_shift($implementedInterfaces);
            $server->setClass($apiService, $jsonRpcNamespace);
        }

        if ($request->isMethod('get')) {
            return new JsonResponse($server->getServiceMap()->toArray());
        }

        return \App\Http\JsonResponse::fromZendResponse($server->handle(), $this->logger);
    }
}
