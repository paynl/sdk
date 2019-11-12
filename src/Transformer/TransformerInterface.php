<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\Model\ModelInterface;

/**
 * Interface TransformerInterface
 *
 * @package PayNL\Sdk\Transformer
 */
interface TransformerInterface
{
    /**
     * @param mixed $inputToTransform
     *
     * @return array|ModelInterface
     */
    public function transform($inputToTransform);
}

/*
           ▄▄▄▄▄▄▄▄▄
        ▄█████████████▄
█████  █████████████████  █████
▐████▌ ▀███▄       ▄███▀ ▐████▌
 █████▄  ▀███▄   ▄███▀  ▄█████
 ▐██▀███▄  ▀███▄███▀  ▄███▀██▌
  ███▄▀███▄  ▀███▀  ▄███▀▄███
  ▐█▄▀█▄▀███ ▄ ▀ ▄ ███▀▄█▀▄█▌
   ███▄▀█▄██ ██▄██ ██▄█▀▄███
    ▀███▄▀██ █████ ██▀▄███▀
   █▄ ▀█████ █████ █████▀ ▄█
   ███        ███        ███
   ███▄    ▄█ ███ █▄    ▄███
   █████ ▄███ ███ ███▄ █████
   █████ ████ ███ ████ █████
   █████ ████ ███ ████ █████
   █████ ████ ███ ████ █████
   █████ ████▄▄▄▄▄████ █████
    ▀███ █████████████ ███▀
      ▀█ ███ ▄▄▄▄▄ ███ █▀
         ▀█▌▐█████▌▐█▀
            ███████
 */
