<?php

namespace Optimus\Heimdal\Formatters;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Optimus\Heimdal\Formatters\BaseFormatter;

class ExceptionFormatter extends BaseFormatter
{
    public function format(JsonResponse $response, Exception $e, array $reporterResponses)
    {
        $code = 500;
        $error_code = $e->getCode();
        if ($e instanceof HttpResponseException) {
            $code = $e->getCode();
        } elseif ($e instanceof AuthenticationException) {
            $code = 401;
            $error_code = 102;
        } elseif ($e instanceof ValidationException) {
            $code = 400;
        }
        $response->setStatusCode($code);
        $data = $response->getData(true);

        if ($this->debug) {
            $data = array_merge($data, [
                'code'   => $error_code,
                'message'   => $e->getMessage(),
                'exception' => (string) $e,
                'line'   => $e->getLine(),
                'file'   => $e->getFile()
            ]);
        } else {
            $data['message'] = $this->config['server_error_production'];
        }

        $response->setData($data);
    }
}
