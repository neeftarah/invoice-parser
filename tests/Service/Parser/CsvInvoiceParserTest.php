<?php

declare(strict_types=1);

namespace App\Tests\Service\Parser;

use App\Exception\InvoiceParsingException;
use App\Service\Parser\CsvInvoiceParser;
use App\Service\Parser\JsonInvoiceParser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Vérification du parser de factures JSON
 */
class CsvInvoiceParserTest extends KernelTestCase
{
    /**
     * Test le parser pour une facture JSON
     *
     * @throws InvoiceParsingException
     */
    public function testParseCsv(): void
    {
        $data = <<<EOS
670.43	EUR	Frank Green	2025-02-03
852.38	EUR	John Doe	2025-02-03
135.87	USD	Jane Smith	2025-02-03
EOS;
        $expected = [
            [
                'montant' => 670.43,
                'devise' => 'EUR',
                'nom' => 'Frank Green',
                'date' => '2025-02-03',
            ],
            [
                'montant' => 852.38,
                'devise' => 'EUR',
                'nom' => 'John Doe',
                'date' => '2025-02-03',
            ],
            [
                'montant' => 135.87,
                'devise' => 'USD',
                'nom' => 'Jane Smith',
                'date' => '2025-02-03',
            ],
        ];

        $parser = new CsvInvoiceParser();
        $this->assertEquals($expected, $parser->parse($data));
    }
}
