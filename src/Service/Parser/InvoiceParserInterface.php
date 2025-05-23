<?php

namespace App\Service\Parser;

/**
 * # Interface pour le parser de factures
 */
interface InvoiceParserInterface
{
    /**
     * ## Parse les factures à partir de différents formats (JSON, CSV, etc.)
     *
     * @param string $content Contenu du fichier à parser
     *
     * @return array Liste des factures parsées
     */
    public function parse(string $content): array;
}
