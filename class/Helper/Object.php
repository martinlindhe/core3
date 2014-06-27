<?php
namespace Helper;

class Object
{
    /**
     * @return string describing public properties
     */
    public static function describePropertiesWithValues($obj, array $excludeProperties = array())
    {
        if (!is_object($obj)) {
            throw new \InvalidArgumentException();
        }

        $res = array();
        foreach ($obj as $property => $value) {
            if (!in_array($property, $excludeProperties) && $value) {
                $res[] = $property.': '.$value;
            }
        }

        return implode("\n", $res);
    }
}
