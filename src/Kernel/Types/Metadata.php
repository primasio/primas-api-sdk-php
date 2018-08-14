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
        return $this->createMultipart($this->data);
    }

    /**
     * @param array $parameters
     * @param string $prefix
     * @return array
     */
    protected function createMultipart(array $parameters, $prefix = '')
    {
        $return = [];
        foreach ($parameters as $name => $value) {
            $item = [
                'name' => empty($prefix) ? $name : "{$prefix}[{$name}]",
            ];
            switch (true) {
                case (is_object($value) && ($value instanceof \CURLFile)):
                    $item['contents'] = fopen($value->getFilename(), 'r');
                    if ($value->getPostFilename()) {
                        $item['filename'] = $value->getPostFilename();
                    }
                    if ($value->getMimeType()) {
                        $item['headers'] = [
                            'content-type' => $value->getMimeType(),
                        ];
                    }
                    break;
                case (is_string($value) && is_file($value)):
                    $item['contents'] = fopen($value, 'r');
                    break;
                case is_array($value):
                    $return = array_merge($return, self::createMultipart($value, $item['name']));
                    continue 2;
                default:
                    $item['contents'] = $value;
            }
            $return[] = $item;
        }

        return $return;
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
