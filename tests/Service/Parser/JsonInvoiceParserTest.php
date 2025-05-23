<?php

declare(strict_types=1);

namespace App\Tests\Service\Parser;

use App\Exception\InvoiceParsingException;
use App\Exception\UnsupportedFileTypeException;
use App\Service\Parser\CsvInvoiceParser;
use App\Service\Parser\InvoiceParserFactory;
use App\Service\Parser\InvoiceParserInterface;
use App\Service\Parser\JsonInvoiceParser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Vérification du parser de factures JSON
 */
class JsonInvoiceParserTest extends KernelTestCase
{
    /**
     * Test le parser pour une facture JSON
     *
     * @throws InvoiceParsingException
     */
    public function testParseJson(): void
    {
        $data = <<<EOS
[
  {"montant": 670.43,"devise": "EUR","nom": "Frank Green","date": "2025-02-03"},
  {"montant": 852.38,"devise": "EUR","nom": "John Doe","date": "2025-02-03"},
  {"montant": 135.87,"devise": "USD","nom": "Jane Smith","date": "2025-02-03"}
]
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

        $parser = new JsonInvoiceParser();
        $this->assertEquals($expected, $parser->parse($data));
    }
}
