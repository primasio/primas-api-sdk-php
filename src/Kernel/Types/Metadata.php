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

    public function toJson(): string
    {
        return Json::json_encode($this->data);
    }

    public function toFormParams(): array
    {
        return $this->data;
    }

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

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function init(array $data)
    {
        return new static($data);
    }
}
