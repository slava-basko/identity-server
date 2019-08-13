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
use Symfony\Component\HttpFoundation\Response;

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
     * @return JsonResponse|Response
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

        try {
            return new Response($server->handle(), 200, [
                'content-type' => 'application/json'
            ]);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            return new Response('Error. See logs.', 200, [
                'content-type' => 'application/json'
            ]);
        }
    }
}
