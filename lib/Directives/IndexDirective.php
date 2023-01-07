<?php

declare(strict_types=1);

namespace Doctrine\RST\Directives;

use Doctrine\RST\ErrorManager;
use Doctrine\RST\Meta\Model\Index;
use Doctrine\RST\Meta\Repository\IndexRepository;
use Doctrine\RST\Nodes\DocumentNode;
use Doctrine\RST\Nodes\IndexNode;
use Doctrine\RST\Nodes\Node;
use Doctrine\RST\Parser;

class IndexDirective extends Directive
{

    public function getName(): string
    {
        return 'index';
    }

    public function processNode(
        Parser $parser,
        string $variable,
        string $data,
        array $options
    ): ?Node {
        $errorManager = $parser->getEnvironment()->getErrorManager();
        if ($data === '') {
            return null;
        }
        $text = trim($data);
        $mode = IndexNode::INDEX_MODE_SINGLE;
        $important = false;
        if (strpos($text, '!') === 0) {
            $important = true;
            $text = substr($text, 1);
        }
        if (str_contains($text, ':')) {
            $parts = explode(':', $text, 2);
            $mode = trim(strtolower($parts[0]));
            $text = trim($parts[1]);
        }
        $entryParts = explode(';', $text, 2);
        foreach ($entryParts as $key => $part) {
            $entryParts[$key] = trim($part);
        }
        switch ($mode) {
            case IndexNode::INDEX_MODE_SINGLE:
                if (count($entryParts) > 2) {
                    $errorManager->warning('Index of mode "single:" expects at most 2 entries.');
                    return null;
                }
                break;
            case IndexNode::INDEX_MODE_PAIR:
            case IndexNode::INDEX_MODE_SEE:
            case IndexNode::INDEX_MODE_SEEALSO:
                if (count($entryParts) !== 2) {
                    $errorManager->warning('Index of mode "' . $mode . ':" expects exactly 2 entries.');
                    return null;
                }
                break;
            case IndexNode::INDEX_MODE_TRIPPLE:
                if (count($entryParts) !== 3) {
                    $errorManager->warning('Index of mode "tripple:" expects exactly 3 entries.');
                    return null;
                }
                break;
            default:
                $errorManager->warning('Index mode ' . $mode . ' is not supported');
                return null;
        }
        return new IndexNode($entryParts, '', $mode, $important);
    }

    /**
     * Called at the end of the parsing to finalize the document (add something or tweak nodes)
     */
    public function finalize(DocumentNode $document): void
    {
        $filename = $document->getEnvironment()->getCurrentFileName();
    }
}
