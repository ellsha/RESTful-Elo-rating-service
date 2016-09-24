<?php
/**
 * Created by PhpStorm.
 * User: ellsha
 * Date: 24.09.16
 * Time: 3:07
 */

namespace App\Exceptions;


class ApiException extends Exception
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @link http://php.net/manual/en/exception.construct.php
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] HTTP Error code 4xx - 5xx
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     * @since 5.1.0
     */
    public function __construct($message = "", $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}