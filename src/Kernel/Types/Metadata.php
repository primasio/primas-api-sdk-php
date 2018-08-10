<?php

namespace Primas\Kernel\Types;

use Primas\Kernel\Contract\MetadataContract;
use Primas\Kernel\Support\Json;

class Metadata implements MetadataContract
{

    /**
     * @var array
     */
    protected $data;

    /**
     * @return string
     */
    public function toJson(): string
    {
        return Json::json_encode($this->data);
    }

    /**
     * @return array
     */
    public function toFormParams(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function toMultipart(): array
    {
        $multipart = [];
        foreach ($this->data as $k => $v) {
            $multipart[] = [
                "name" => $k,
                "contents" => $v
            ];
        }
        return $multipart;
    }

    /**
     * Metadata constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function init(array $data)
    {
        return new static($data);
    }
}
