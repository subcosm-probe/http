<?php
/**
 * This file is part of the subcosm-probe.
 *
 * (c)2017 Matthias Kaschubowski
 *
 * This code is licensed under the MIT license,
 * a copy of the license is stored at the project root.
 */

namespace Singularity\Http;


use Singularity\Primitive\StreamInterface;
use Singularity\Primitive\UriInterface;

/**
 * Interface RequestInterface
 *
 * General Request Interface
 *
 * @package Singularity\Http
 * @author Matthias Kaschubowski <nihylum@gmail.com>
 */
interface RequestInterface
{
    /**
     * returns the header contents of the provided header name, if any, otherwise null.
     *
     * @param string $header
     * @return null|string
     */
    public function getHeader(string $header): ? string;

    /**
     * checks whether the provided header names exists, or not.
     *
     * @param string[] ...$headers
     * @return bool
     */
    public function hasHeader(string ... $headers): bool;

    /**
     * returns the current request method.
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * checks whether the request is using one of the provided methods, or not.
     *
     * @param string[] ...$methods
     * @return bool
     */
    public function usesMethod(string ... $methods): bool;

    /**
     * returns the query (_GET) value of the provided key, or null when the key is not know.
     *
     * @param string $key
     * @return string|array|null
     */
    public function getQueryItem(string $key);

    /**
     * checks whether the request's query string contains all provided keys, or not.
     *
     * @param string[] ...$keys
     * @return bool
     */
    public function hasQueryItem(string ... $keys): bool;

    /**
     * returns the request (_POST) value of the provided key.
     *
     * @param string $key
     * @return string|array|null
     */
    public function getRequestItem(string $key);

    /**
     * checks whether the request's request string contains all provided keys, or not.
     *
     * @param string[] ...$keys
     * @return bool
     */
    public function hasRequestItem(string ... $keys): bool;

    /**
     * returns the cookie value of the provided key, or null if the key (cookie) is not known.
     *
     * @param string $key
     * @return string|null
     */
    public function getCookie(string $key): ? string;

    /**
     * checks whether the request's cookies contains all provided cookie names (keys), or not.
     *
     * @param string[] ...$keys
     * @return bool
     */
    public function hasCookie(string ... $keys): bool;

    /**
     * returns the uploaded file instance of the provided key, or null if the key (file) is not known.
     *
     * # ToDo: UploadedFile-class goes here
     *
     * @param string $key
     * @return mixed|null
     */
    public function getFile(string $key);

    /**
     * checks whether the request's uploaded files contains all provided file keys, or not.
     *
     * @param string[] ...$keys
     * @return bool
     */
    public function hasFile(string ... $keys): bool;

    /**
     * return the query or request value of the provided key, if any, otherwise null.
     *
     * @param string $key
     * @return string|array|null
     */
    public function getItem(string $key);

    /**
     * checks whether the request's query string or request string contains all provided keys, or not.
     *
     * @param string[] ...$keys
     * @return bool
     */
    public function hasItem(string ... $keys): bool;

    /**
     * checks whether the request is serving a query (_GET items), or not.
     *
     * @return bool
     */
    public function hasQuery(): bool;

    /**
     * checks whether the required headers for a file uploaded are known to this request, or not.
     *
     * @return bool
     */
    public function isUpload(): bool;

    /**
     * checks whether the request has a X-Requested-With header with provided value.
     *
     * Usually used for detecting AJAX or AJAJ requests.
     *
     * @param string $string
     * @return bool
     */
    public function isRequestedWith(string $string): bool;

    /**
     * returns the stream instance for the body contents of the request, if any, otherwise null.
     *
     * @return null|StreamInterface
     */
    public function getBody(): ? StreamInterface;

    /**
     * checks whether the request has a body, or not.
     *
     * @return bool
     */
    public function hasBody(): bool;

    /**
     * returns the contents of the request body as a string, if any, otherwise null.
     *
     * @return null|string
     */
    public function getContents(): ? string;

    /**
     * returns the content type of the request.
     *
     * This content type belongs to the body of the request and can continue other parameters like the charset.
     *
     * @return null|string
     */
    public function getContentType(): ? string;

    /**
     * returns the content mime type of the request.
     *
     * Equal to getContentType(), but returns only the mime type part of the content type.
     *
     * @return null|string
     */
    public function getContentMimeType(): ? string;

    /**
     * returns the client ip of the request.
     *
     * This IP is the proxy IP when the user is using a proxy server to connect to the application.
     *
     * @return string
     */
    public function getClientIP(): string;

    /**
     * returns the real client ip of the request.
     *
     * The method tries to locate the IP behind a proxy (if there is any detectable proxy) and returns the IP.
     * The IP resolving for proxy usage will not work in case of transparent proxies and is always relying on
     * the served additional headers.
     *
     * @return string
     */
    public function getRealClientIP(): string;

    /**
     * checks whether the request was done using a proxy server, or not.
     *
     * This method tries to locate the IP behind a proxy (if there is any detectable proxy) and checks it against
     * the client ip and considers known proxy headers as an qualified indicator for a proxy request.
     *
     * @return bool
     */
    public function isProxyRequest(): bool;

    /**
     * checks whether the client emitting this request does accept one of the provided values for the provided accept
     * rule.
     *
     * @param string $rule
     * @param string[] ...$values
     * @return bool
     */
    public function clientAccepts(string $rule, string ... $values): bool;

    /**
     * redirects the request emitting client to the provided uri.
     *
     * This method will orchestrate a redirect response instance. You have to send the response or use it in a regular
     * mechanism which takes care of responses (like a return command of a controller).
     *
     * @param UriInterface $uri
     * @return ResponseInterface
     */
    public function redirectTo(UriInterface $uri): ResponseInterface;

    /**
     * aborts the request and outputs the optionally provided message using a HTTP Status Code 500.
     *
     * This method will orchestrate a abort message response instance. You have to send the response or use it in a
     * regular mechanism which takes care of responses (like a return command of a controller).
     *
     * @param string $message
     * @return ResponseInterface
     */
    public function abort(string $message = null): ResponseInterface;
}