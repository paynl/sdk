<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request;

use PayNL\Sdk\Response\Response;
use PayNL\Sdk\Transformer\TransformerInterface;

/**
 * Interface RequestInterface
 *
 * @package PayNL\Sdk\Request
 */
interface RequestInterface
{
    /*
     * Format constants declaration
     */
    public const FORMAT_JSON    = 'json';
    public const FORMAT_XML     = 'xml';
    public const FORMAT_OBJECTS = 'objects';

    /*
     * Request method constants declaration
     */
//    public const METHOD_OPTIONS  = 'OPTIONS';
    public const METHOD_GET      = 'GET';
//    public const METHOD_HEAD     = 'HEAD';
    public const METHOD_POST     = 'POST';
//    public const METHOD_PUT      = 'PUT';
    public const METHOD_DELETE   = 'DELETE';
//    public const METHOD_TRACE    = 'TRACE';
//    public const METHOD_CONNECT  = 'CONNECT';
    public const METHOD_PATCH    = 'PATCH';
//    public const METHOD_PROPFIND = 'PROPFIND';

    /*
     * Request header constants declaration
     */
    public const HEADER_ACCEPT        = 'Accept';
    public const HEADER_AUTHORIZATION = 'Authorization';
    public const HEADER_CONTENT_TYPE  = 'Content-Type';

    /**
     * @return string
     */
    public function getUri(): string;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @param Response $response
     *
     * @return void
     */
    public function execute(Response $response): void;

    /**
     *
     * @return TransformerInterface
     */
//    public function getTransformer(): TransformerInterface;
}
