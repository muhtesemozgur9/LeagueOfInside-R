<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FixtureService;

class GenerateFixtures extends Command
{
    protected $signature = 'fixtures:generate';
    protected $description = 'Generate fixtures for all teams and save to the database';

    protected FixtureService $fixtureService;

    public function __construct(FixtureService $fixtureService)
    {
        parent::__construct();
        $this->fixtureService = $fixtureService;
    }

    public function handle(): int
    {
        try {
            $this->fixtureService->generateAndSaveFixtures();
            $this->info('Fixtures successfully generated!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
