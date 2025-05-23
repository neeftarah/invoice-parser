<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\InvoiceParser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:parse')]
class ParseInvoicesCommand extends Command
{
    private InvoiceParser $parser;

    public function __construct(InvoiceParser $parser)
    {
        parent::__construct();
        $this->parser = $parser;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info('Parsing JSON invoices...');
        try {
            $this->parser->parse('data/invoices.json');
            $io->success('JSON invoices successfully processed!');
        } catch (\Exception $e) {
            $io->error('Error parsing JSON invoices: '.$e->getMessage());

            return Command::FAILURE;
        }

        $io->info('Parsing CSV invoices...');
        try {
            $this->parser->parse('data/invoices.csv');
            $io->success('CSV invoices successfully processed!');
        } catch (\Exception $e) {
            $io->error('Error parsing CSV invoices: '.$e->getMessage());

            return Command::FAILURE;
        }

        $io->success('All invoices successfully processed!');

        return Command::SUCCESS;
    }
}
