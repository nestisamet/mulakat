<?php
/**
 * Created by PhpStorm.
 * User: usr0
 * Date: 9/23/19
 * Time: 2:17 AM
 */

namespace App\Exceptions;


use Throwable;

/**
 * Class ApiException
 * @package App\Exceptions
 */
class ApiException extends \Exception
{
    protected $msg;
    protected $responseCode;

    /**
     * ApiException constructor.
     * @param array $msg
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(array $msg = [], int $code = 200, Throwable $previous = null)
    {
        // parent::__construct($message, $code, $previous);
        $this->msg = $msg;
        $this->responseCode = $code;
    }

    /**
     * @return array
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @return int
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }
}
