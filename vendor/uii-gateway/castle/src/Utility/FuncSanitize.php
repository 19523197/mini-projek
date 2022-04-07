<?php

namespace UIIGateway\Castle\Utility;

trait FuncSanitize
{
    public static function entityEncode($data)
    {
        $typeData = gettype($data);
        if ($typeData == 'array' || $typeData == 'object') {
            if ($typeData == 'object') {
                $data = $data->toArray();
            }

            array_walk_recursive($data, function (&$value) {
                $type = gettype($value);
                switch ($type) {
                    case 'boolean':
                        $value = (bool) htmlentities($value);
                        break;
                    case 'integer':
                        $value = (int) htmlentities($value);
                        break;
                    case 'double':
                        $value = (double) htmlentities($value);
                        break;
                    default:
                        $value = htmlentities($value);
                        break;
                }
            });

            $data = (object) $data;
        } else {
            $data = htmlentities($data);
        }

        return $data;
    }

    public static function entityDecode($data)
    {
        $typeData = gettype($data);
        if ($typeData == 'array' || $typeData == 'object') {
            if ($typeData == 'object') {
                $data = $data->toArray();
            }

            array_walk_recursive($data, function (&$value) {
                $type = gettype($value);
                switch ($type) {
                    case 'boolean':
                        $value = (bool) html_entity_decode($value);
                        break;
                    case 'integer':
                        $value = (int) html_entity_decode($value);
                        break;
                    case 'double':
                        $value = (double) html_entity_decode($value);
                        break;
                    default:
                        $value = html_entity_decode($value);
                        break;
                }
            });
        } else {
            $data = html_entity_decode($data);
        }

        return $data;
    }
}
