<?php

declare(strict_types=1);

namespace Doctrine\RST\LaTeX\Renderers;

use Doctrine\RST\Environment;
use Doctrine\RST\Nodes\SpanNode;
use Doctrine\RST\Renderers\SpanNodeRenderer as BaseSpanNodeRenderer;
use Doctrine\RST\Templates\TemplateRenderer;

final class SpanNodeRenderer extends BaseSpanNodeRenderer
{
    private TemplateRenderer $templateRenderer;

    public function __construct(
        Environment $environment,
        SpanNode $spanNode,
        TemplateRenderer $templateRenderer
    ) {
        parent::__construct($environment, $spanNode);

        $this->templateRenderer = $templateRenderer;
    }

    public function escape(string $span): string
    {
        return $span;
    }
}
