<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Server;

use Respect\Validation\Exceptions\NestedValidationException;
use Zend\Json\Server\Error;
use Zend\Json\Server\Server;
use Zend\Json\Server\Request;
use Zend\Json\Server\Response;
use Psr\Log\LoggerInterface;

class JsonRpcServer extends Server
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger){
        parent::__construct();
        $this->logger = $logger;
    }

    /**
     * Indicate fault response.
     *
     * @param  string $fault
     * @param  int $code
     * @param  mixed $data
     * @return Error
     */
    public function fault($fault = null, $code = 404, $data = null)
    {
        if ($data instanceof NestedValidationException) {
            if (count($data->getMessages()) > 1) {
                $fault = $data->getFullMessage();
            } else {
                $fault .= ': ' . $data->getFullMessage();
            }
        }
        $error = new Error($fault, $code, $data);
        $this->getResponse()->setError($error);
        return $error;
    }

    /**
     * @param bool $request
     * @return string|Response|null
     */
    public function handle($request = false)
    {
        $raw = $this->getRequest()->getRawJson();
        $raw = json_decode($raw, true);
        $results = [];
        if(isset($raw[0])){
            foreach ($raw as $part) {
                try {
                    $req = new Request();
                    $req->setOptions($part);
                    parent::setRequest($req);
                    parent::setResponse(new Response\Http());
                    $resp = parent::handle($request);
                    $results[] = $resp->toJson();
                } catch (\Exception $exception) {
                    $this->logger->error('Error handling request!!! Request: '.json_encode($part) . ", message: " .$exception->getMessage());
                    $results[] = '{"jsonrpc": "2.0", "error": {"code": -32000, "message": "Error. See logs."}, "id": 1}';
                }
            }
            $response = '['.implode(', ', $results).']';
        } else {
            $response = parent::handle($request);
        }
        return $response;
    }
}