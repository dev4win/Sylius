<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\CoreBundle\Console\Command;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\CoreBundle\Installer\Checker\CommandDirectoryChecker;
use Sylius\Bundle\CoreBundle\Installer\Executor\CommandExecutor;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractInstallCommand extends Command
{
    /** @var CommandExecutor|null */
    protected $commandExecutor;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CommandDirectoryChecker $commandDirectoryChecker,
    ) {
        parent::__construct();
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $application = $this->getApplication();
        $application->setCatchExceptions(false);

        $this->commandExecutor = new CommandExecutor($input, $output, $application);
    }

    protected function getEnvironment(): string
    {
        /** @var Application $application */
        $application = $this->getApplication();

        return $application->getKernel()->getEnvironment();
    }

    protected function isDebug(): bool
    {
        /** @var Application $application */
        $application = $this->getApplication();

        return $application->getKernel()->isDebug();
    }

    protected function createProgressBar(OutputInterface $output, int $length = 10): ProgressBar
    {
        $progress = new ProgressBar($output);
        $progress->setBarCharacter('<info>░</info>');
        $progress->setEmptyBarCharacter(' ');
        $progress->setProgressCharacter('<comment>░</comment>');

        $progress->start($length);

        return $progress;
    }

    /** @param array<array-key, mixed> $commands */
    protected function runCommands(array $commands, OutputInterface $output, bool $displayProgress = true): void
    {
        $progress = $this->createProgressBar($displayProgress ? $output : new NullOutput(), count($commands));

        foreach ($commands as $key => $value) {
            if (is_string($key)) {
                $command = $key;
                $parameters = $value;
            } else {
                $command = $value;
                $parameters = [];
            }

            $this->commandExecutor->runCommand($command, $parameters);

            // PDO does not always close the connection after Doctrine commands.
            // See https://github.com/symfony/symfony/issues/11750.
            $this->entityManager->getConnection()->close();

            $progress->advance();
        }

        $progress->finish();
    }

    protected function ensureDirectoryExistsAndIsWritable(string $directory, OutputInterface $output): void
    {
        $this->commandDirectoryChecker->setCommandName($this->getName());

        $this->commandDirectoryChecker->ensureDirectoryExists($directory, $output);
        $this->commandDirectoryChecker->ensureDirectoryIsWritable($directory, $output);
    }
}
