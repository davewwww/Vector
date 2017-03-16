<?php

namespace Dwo\Vector\Restrictor;

use Dwo\Vector\Vector;

interface LimitedVectorRestrictorInterface extends VectorRestrictorInterface
{
    /**
     * @param Vector $vector
     *
     * @return bool
     */
    public function isUsable(Vector $vector);

    /**
     * @param Vector $vector
     */
    public function used(Vector $vector);
}