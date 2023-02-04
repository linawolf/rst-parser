<?php

declare(strict_types=1);

namespace Doctrine\RST\TextRoles;

use Doctrine\RST\Span\SpanProcessor;
use Doctrine\RST\Span\SpanToken;

use function preg_replace_callback;

class BrTextRole extends SpecialTextRole
{
    public function __construct()
    {
        parent::__construct('br');
    }

    public function replaceAndRegisterTokens(SpanProcessor $spanProcessor, string $span): string
    {
        $span = (string) preg_replace_callback(
            '/ \n/',
            function (array $match) use ($spanProcessor): string {
                $id = $spanProcessor->generateId();
                $spanProcessor->addToken(
                    new SpanToken($this, $id, [
                        'type' => $this->getName(),
                    ])
                );

                return $id;
            },
            $span,
        );

        return $span;
    }

    public function hasRecursiveSyntax(): bool
    {
        return true;
    }
}