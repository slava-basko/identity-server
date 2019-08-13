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

class JsonRpcServer extends Server
{
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
        $keys = array_keys($raw);
        $results = [];
        if ($keys == array_keys($keys)) {
            foreach ($raw as $part) {
                $req = new Request();
                $req->loadJson(json_encode($part));
                parent::setRequest($req);
                parent::setResponse(new Response\Http());
                $resp = parent::handle($request);
                $results[] = $resp->toJson();
            }
            $response = '['.implode(', ', $results).']';
        } else {
            $response = parent::handle($request);
        }
        return $response;
    }
}