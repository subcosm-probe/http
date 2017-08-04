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

/**
 * Interface ResponseInterface
 *
 * General Response Interface
 *
 * @package Singularity\Http
 */
interface ResponseInterface
{
    /**
     * Sets the request this response will follow.
     *
     * Once a request is set to a response, the response can be validated using isValid() against this request.
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function follows(RequestInterface $request): ResponseInterface;

    /**
     * Sets the provided status code.
     *
     * @param int $statusCode
     * @return ResponseInterface
     */
    public function withStatusCode(int $statusCode): ResponseInterface;

    /**
     * sets the provided message which will follow the status code.
     *
     * @param string $message
     * @return ResponseInterface
     */
    public function withMessage(string $message): ResponseInterface;

    /**
     * sets the provided header field with the provided values.
     *
     * Values given to this method will be automatically properly combined.
     *
     * @param string $field
     * @param string[] ...$values
     * @return ResponseInterface
     */
    public function withHeader(string $field, string ... $values): ResponseInterface;

    /**
     * sets the provided header field with the provided values only when the provided header field is not known yet.
     *
     * @param string $field
     * @param string[] ...$values
     * @return ResponseInterface
     */
    public function withHeaderIf(string $field, string ... $values): ResponseInterface;

    /**
     * sets the provided content mime type.
     *
     * @param string $contentType
     * @return ResponseInterface
     */
    public function withContentMimeType(string $contentType): ResponseInterface;

    /**
     * sets the provided content mime type only when the content type was not orchestrated yet.
     *
     * @param string $contentType
     * @return ResponseInterface
     */
    public function withContentMimeTypeIf(string $contentType): ResponseInterface;

    /**
     * sets the provided charset.
     *
     * @param string $charset
     * @return ResponseInterface
     */
    public function withContentCharSet(string $charset): ResponseInterface;

    /**
     * sets the provided charset only when the charset was not orchestrated yet.
     *
     * @param string $charset
     * @return ResponseInterface
     */
    public function withContentCharSetIf(string $charset): ResponseInterface;

    /**
     * sets the provided string content.
     *
     * Once you do use this method, previously applied contents (string content or body streams) are automatically
     * removed from the response.
     *
     * @param string $content
     * @return ResponseInterface
     */
    public function withContent(string $content): ResponseInterface;

    /**
     * sets the provided body stream as the stream content of the response.
     *
     * @param StreamInterface $stream
     * @param string|null $forcedContentMimeType
     * @return ResponseInterface
     */
    public function withBody(StreamInterface $stream, string $forcedContentMimeType = null): ResponseInterface;

    /**
     * sets the provided stream interface as the stream content of the response and applies headers who will
     * enforce web browsers to enforce a download of the file.
     *
     * @param StreamInterface $stream
     * @param string $proposedFilename
     * @param callable|null $throttleCallback
     * @return ResponseInterface
     */
    public function forceDownloadOf(StreamInterface $stream, string $proposedFilename, callable $throttleCallback = null): ResponseInterface;

    /**
     * checks if the current settings of this response fulfills the needs of a followed request.
     *
     * This method will return true when no request is followed.
     *
     * @return bool
     */
    public function isValid(): bool;

    /**
     * sends the response only if no sender callback is provided. Once a sender callback is provided, only the sender
     * callback will be called without sending the response and an array will be given as the first parameter,
     * serving the following fields:
     *
     * - status-code        Served as an integer, representing the HTTP Status Code of the response.
     * - message            Served as an string, representing the HTTP Status Code Message
     * - headers            Served as an associative array, containing strings associated to their fields.
     * - stream             Served as an StreamInterface instance, containing the body of the response.
     *
     * @param callable|null $sender
     */
    public function send(callback $sender = null): void;
}