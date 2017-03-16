<?php

namespace Dwo\Vector\Restrictor;

use Dwo\Vector\Vector;

class LimitedVectorRestrictor extends DefaultVectorRestrictor implements LimitedVectorRestrictorInterface
{
    private $limited = [];
    private $counts = [];

    /**
     * @param mixed $maxVectorSize
     * @param array $limited
     */
    public function __construct($maxVectorSize, array $limited)
    {
        parent::__construct($maxVectorSize);

        $this->limited = $limited;
    }

    /**
     * @param Vector $vector
     *
     * @return bool
     */
    public function isUsable(Vector $vector)
    {
        $key = $this->buildKey($vector);

        $available = array_key_exists($key, $this->limited) ? $this->limited[$key] : -1;

        if ((-1 === $available) || '1x1' === implode('x', $vector->getDimension())) {
            return true;
        }

        $count = isset($this->counts[$key]) ? $this->counts[$key] : 0;

        return $count < $available;
    }

    /**
     * @param Vector $vector
     */
    public function used(Vector $vector)
    {
        if (!isset($this->counts[$key = $this->buildKey($vector)])) {
            $this->counts[$key] = 0;
        }
        $this->counts[$key]++;
    }

    /**
     * @param Vector $vector
     *
     * @return string
     */
    private function buildKey(Vector $vector)
    {
        return implode('x', $vector->getDimension()).$vector->getValue();
    }
}