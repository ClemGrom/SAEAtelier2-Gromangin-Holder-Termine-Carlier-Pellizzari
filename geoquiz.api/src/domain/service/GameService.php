<?php

namespace geoquiz\api\domain\service;

use geoquiz\api\domain\entities\Difficulty_Levels;
use Psr\Log\LoggerInterface;

class GameService implements GameServiceInterface
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getDifficulties(): array
    {
        $this->logger->info('Getting difficulties');
        return Difficulty_Levels::all()->map(function ($difficulty) {
            return $difficulty->toDTO();
        })->toArray();
    }
}