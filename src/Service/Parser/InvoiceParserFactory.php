<?php

namespace App\Service\Parser;

use App\Exception\UnsupportedFileTypeException;

/**
 * # Factory pour créer des parsers de factures
 */
class InvoiceParserFactory
{
    /**
     * Crée un parser de factures en fonction de l'extension du fichier
     *
     * @param string $filePath Chemin du fichier à parser
     * @return InvoiceParserInterface Instance du parser approprié
     * @throws UnsupportedFileTypeException Si le type de fichier n'est pas supporté
     */
    public function createFromFile(string $filePath): InvoiceParserInterface
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        return match ($extension) {
            'csv' => new CsvInvoiceParser(),
            'json' => new JsonInvoiceParser(),
            default => throw new UnsupportedFileTypeException(
                'Le format du fichier "' . $filePath . '" n\'est pas supporté! Formats attendus : csv, json'
            ),
        };
    }
}
