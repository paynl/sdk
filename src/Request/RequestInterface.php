<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request;

use PayNL\Sdk\Response;

/**
 * Interface RequestInterface
 *
 * @package PayNL\Sdk\Request
 */
interface RequestInterface
{
    public const FORMAT_JSON   = 'json';
    public const FORMAT_XML    = 'xml';
    public const FORMAT_OBJECTS = 'object';

    public const METHOD_OPTIONS  = 'OPTIONS';
    public const METHOD_GET      = 'GET';
    public const METHOD_HEAD     = 'HEAD';
    public const METHOD_POST     = 'POST';
    public const METHOD_PUT      = 'PUT';
    public const METHOD_DELETE   = 'DELETE';
    public const METHOD_TRACE    = 'TRACE';
    public const METHOD_CONNECT  = 'CONNECT';
    public const METHOD_PATCH    = 'PATCH';
    public const METHOD_PROPFIND = 'PROPFIND';

    /**
     * @return string
     */
    public function getUri(): string;

    public function getMethod(): string;

    public function execute(): Response;
}
