<?php
namespace ManaPHP\Serializer\Adapter;

use ManaPHP\Serializer\AdapterInterface;

class StringType implements AdapterInterface
{
    /**
     * @param mixed $data
     *
     * @return string
     * @throws \ManaPHP\Serializer\Adapter\Exception
     */
    public function serialize($data)
    {
        if (is_string($data)) {
            return $data;
        } elseif ($data === false || $data === null) {
            return '';
        } else {
            throw new Exception('data is not a string: `:data`'/**m0302aa8f9d395d68a*/, ['data' => json_encode(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)]);
        }
    }

    /**
     * @param string $serialized
     *
     * @return mixed
     */
    public function deserialize($serialized)
    {
        return $serialized;
    }
}