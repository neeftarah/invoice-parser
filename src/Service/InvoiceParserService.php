<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\InvoiceParsingException;
use App\Service\Parser\InvoiceParserFactory;

/**
 * # Service pour parser les factures
 *
 * Ce service utilise le pattern Strategy pour permettre le parsing de différents formats de factures (JSON, CSV, etc.)
 */
class InvoiceParserService
{
    public function __construct(
        private readonly InvoiceParserFactory $parserFactory,
    ) {
    }

    /**
     * Parse un fichier de facture
     *
     * @param string $filepath Chemin du fichier à parser
     * @return array Liste des factures parsées
     * @throws InvoiceParsingException
     */
    public function parse(string $filepath): array
    {
        try {
            // Vérifie si le fichier existe
            if (!file_exists($filepath)) {
                throw new \InvalidArgumentException('Le fichier spécifié n\'existe pas.');
            }

            // Vérifie si le fichier est lisible
            if (!is_readable($filepath)) {
                throw new \RuntimeException('Le fichier spécifié n\'est pas lisible.');
            }

            // Lit le contenu du fichier
            $content = file_get_contents($filepath);

            // Vérifie si le contenu a été lu avec succès
            if ($content === false) {
                throw new \RuntimeException('Unable to read file content.');
            }

            // Crée le parser en fonction de l'extension du fichier
            $parser = $this->parserFactory->createFromFile($filepath);

            // Parse et retourne le contenu du fichier sous forme de tableau
            return $parser->parse($content);
        } catch (\Throwable $e) {
            throw new InvoiceParsingException('Error while parsing the file: ' . $e->getMessage(), 0, $e);
        }
    }
}
