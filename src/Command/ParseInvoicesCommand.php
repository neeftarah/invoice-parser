<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\InvoiceRepository;
use App\Service\InvoiceParserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:parse',
    description: 'Parse les fichiers de factures et met à jour la base de données',
)]
class ParseInvoicesCommand extends Command
{
    public function __construct(
        private readonly InvoiceParserService $parser,
        private readonly InvoiceRepository $invoiceRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info('Parsing JSON invoices...');
        try {
            $invoicesData = $this->parser->parse('data/invoices.json');
            $this->invoiceRepository->saveAll($invoicesData);
            $io->success('JSON invoices successfully processed!');
        } catch (\Exception $e) {
            $io->error('Error parsing JSON invoices: ' . $e->getMessage());

            return Command::FAILURE;
        }

        $io->info('Parsing CSV invoices...');
        try {
            $invoicesData = $this->parser->parse('data/invoices.csv');
            $this->invoiceRepository->saveAll($invoicesData);
            $io->success('CSV invoices successfully processed!');
        } catch (\Exception $e) {
            $io->error('Error parsing CSV invoices: ' . $e->getMessage());

            return Command::FAILURE;
        }

        $io->success('All invoices successfully processed!');

        return Command::SUCCESS;
    }
}
