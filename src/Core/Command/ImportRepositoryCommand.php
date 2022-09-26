<?php

namespace App\Core\Command;

use Exception;
use App\Core\Service\Import\ImportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import:repository',
    description: 'Imports repository from provider.',
)]
class ImportRepositoryCommand extends Command
{
    public function __construct(
        private ImportService $importService
    ) {
        $this->importService = $importService;

        // you *must* call the parent constructor
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('ownerName', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('providerName', InputArgument::REQUIRED, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $ownerName = (string)$input->getArgument('ownerName');
        $providerName = (string)$input->getArgument('providerName');

        try {
            $io->section('Importing repositories.');
            
            $this->importService->importRepositories($providerName, $ownerName);
        } catch(Exception $e) {
            $io->error($e->getMessage());
        }

        $io->success('Repositories successfully imported.');

        return Command::SUCCESS;
    }
}
