<?php

declare(strict_types=1);

namespace Doctrine\RST\HTML\Renderers;

use Doctrine\RST\Configuration;
use Doctrine\RST\Meta\Repository\IndexRepository;
use Doctrine\RST\Nodes\DocumentNode;
use Doctrine\RST\Renderers\DocumentNodeRenderer as BaseDocumentRender;
use Doctrine\RST\Renderers\FullDocumentNodeRenderer;
use Doctrine\RST\Renderers\FullGeneralIndexRenderer;
use Doctrine\RST\Renderers\NodeRenderer;
use Doctrine\RST\Templates\TemplateRenderer;
use Gajus\Dindent\Indenter;

final class GeneralIndexRenderer implements FullGeneralIndexRenderer
{
    private Configuration $configuration;

    private TemplateRenderer $templateRenderer;

    public function __construct(Configuration $configuration, TemplateRenderer $templateRenderer)
    {
        $this->configuration         = $configuration;
        $this->templateRenderer = $templateRenderer;
    }

    public function render(): string
    {
        $repository = $this->configuration->getIndexRepositoryFactory()->getIndexRepository();
        $html = $this->templateRenderer->render('genindex.html.twig', [
            'indexes' => $repository,
        ]);

        if ($this->configuration->getIndentHTML()) {
            return $this->indentHTML($html);
        }

        return $html;
    }

    private function indentHTML(string $html): string
    {
        return (new Indenter())->indent($html);
    }
}
