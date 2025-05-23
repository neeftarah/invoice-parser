<?php

namespace App\Service\Parser;

use App\Exception\InvoiceParsingException;

/**
 * # Parser pour les factures au format JSON
 */
class JsonInvoiceParser implements InvoiceParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(string $content): array
    {
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($data)) {
            throw new InvoiceParsingException('Invalid JSON structure: expected an array.');
        }

        return $data;
    }
}
