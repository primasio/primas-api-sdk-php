<?php

namespace Primas\Kernel;

/**
 * error code 说明.
 * <ul>
 *    <li> 400: Client error</li>
 *    <li> 401: Invalid post data</li>
 *    <li> 402: Invalid JSON string</li>
 *    <li> 403: Signature verification failed</li>
 *    <li> 404: Invalid parameter</li>
 *    <li> 405: Empty parameter</li>
 *    <li> 406: Nonce is used before</li>
 *    <li> 500: Server error</li>
 * </ul>
 */
class Code
{
    const OK = 0;
    const CLIENT_ERROR = 400;
    const INVALID_POST_DATA = 401;
    const INVALID_JSON = 402;
    const SIGNATURE_VERIFY_ERROR = 403;
    const INVALID_PARAMETER = 404;
    const EMPTY_PARAMETER = 405;
    const NONCE_USED = 406;
    const SEVER_ERROR = 500;
}