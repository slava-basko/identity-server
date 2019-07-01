<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Server;

use Respect\Validation\Exceptions\NestedValidationException;
use Zend\Json\Server\Error;
use Zend\Json\Server\Server;

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
}