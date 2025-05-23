<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class InvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoice::class);
    }

    /**
     * Sauvegarde les factures dans la base de données.
     *
     * @param array $invoicesData Tableau de factures à sauvegarder.
     * @return void
     */
    public function saveAll(array $invoicesData): void
    {
        $em = $this->getEntityManager();

        foreach ($invoicesData as $data) {
            $invoice = $this->findOneBy(['name' => $data['nom']]) ?? new Invoice();
            $invoice->setAmount((float) $data['montant']);
            $invoice->setCurrency($data['devise']);
            $invoice->setName($data['nom']);
            $invoice->setDate(new \DateTime($data['date']));

            $em->persist($invoice);
        }

        $em->flush();
    }
}
