<?php

namespace App\Service\Parser;

use App\Exception\InvoiceParsingException;

/**
 * # Parser pour les factures au format CSV
 */
class CsvInvoiceParser implements InvoiceParserInterface
{
    private const HEADERS = ['montant', 'devise', 'nom', 'date'];

    /**
     * @inheritDoc
     */
    public function parse(string $content): array
    {
        $lines = explode("\n", trim($content));
        if (count($lines) < 1) {
            throw new InvoiceParsingException('CSV must contain at least one data line.');
        }
        $invoices = [];

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue; // ignore empty lines
            }

            $row = str_getcsv($line, "\t", '"', '\\');

            if (count($row) !== count(self::HEADERS)) {
                throw new InvoiceParsingException('CSV row does not match header column count.');
            }

            $invoices[] = array_combine(self::HEADERS, $row);
        }

        return $invoices;
    }
}
