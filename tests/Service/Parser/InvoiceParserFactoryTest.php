<?php

declare(strict_types=1);

namespace App\Tests\Service\Parser;

use App\Exception\UnsupportedFileTypeException;
use App\Service\InvoiceParserService;
use App\Service\Parser\CsvInvoiceParser;
use App\Service\Parser\InvoiceParserFactory;
use App\Service\Parser\InvoiceParserInterface;
use App\Service\Parser\JsonInvoiceParser;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Vérification de la fabrique de parser de factures
 * - un fichier JSON doit retourner un parser JsonInvoiceParser
 * - un fichier CSV doit retourner un parser CsvInvoiceParser
 */
class InvoiceParserFactoryTest extends KernelTestCase
{
    /**
     * Test la fabrique de parser pour une facture JSON
     * - la fabrique doit retourner un parser JsonInvoiceParser
     *
     * @throws UnsupportedFileTypeException
     */
    public function testParseJson(): void
    {
        $factory = new InvoiceParserFactory();
        $parser = $factory->createFromFile('data/invoices.json');
        $this->assertInstanceOf(InvoiceParserInterface::class, $parser);
        $this->assertInstanceOf(JsonInvoiceParser::class, $parser);
    }

    /**
     * Test la fabrique de parser pour une facture CSV
     * - la fabrique doit retourner un parser CsvInvoiceParser
     *
     * @throws UnsupportedFileTypeException
     */
    public function testParseCsv(): void
    {
        $factory = new InvoiceParserFactory();
        $parser = $factory->createFromFile('data/invoices.csv');
        $this->assertInstanceOf(InvoiceParserInterface::class, $parser);
        $this->assertInstanceOf(CsvInvoiceParser::class, $parser);
    }
}
