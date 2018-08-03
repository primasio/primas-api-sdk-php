<?php

namespace Primas\Kernel\Contract;

interface MetadataContract
{
    /**
     * @return string
     */
    public function toJson(): string ;

    /**
     * @return array
     */
    public function toFormParams(): array;

    /**
     * @return array
     */
    public function toMultipart(): array;
}