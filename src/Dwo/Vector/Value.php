<?php

namespace Dwo\Vector;

class Value
{
    public static function isValue($value)
    {
        return !(null === $value || $value instanceof Vector || $value instanceof VectorReference);
    }
}