<?php

declare(strict_types=1);

namespace Doctrine\RST\HTML\Nodes;

use Doctrine\RST\Nodes\AnchorNode as Base;

class AnchorNode extends Base
{
    protected function doRender() : string
    {
        return '<a id="' . $this->value . '"></a>';
    }
}
