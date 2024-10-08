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

namespace Sylius\Bundle\ApiBundle\CommandHandler\Account;

use Sylius\Bundle\ApiBundle\Command\Account\RequestResetPasswordToken;
use Sylius\Bundle\ApiBundle\Command\Account\SendResetPasswordEmail;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Component\Clock\ClockInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

#[AsMessageHandler]
final readonly class RequestResetPasswordTokenHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private MessageBusInterface $commandBus,
        private GeneratorInterface $generator,
        private ClockInterface $clock,
    ) {
    }

    public function __invoke(RequestResetPasswordToken $command): void
    {
        $user = $this->userRepository->findOneByEmail($command->email);
        if (null === $user) {
            return;
        }

        $user->setPasswordResetToken($this->generator->generate());
        $user->setPasswordRequestedAt($this->clock->now());

        $this->commandBus->dispatch(
            new SendResetPasswordEmail(
                $command->email,
                $command->channelCode,
                $command->localeCode,
            ),
            [new DispatchAfterCurrentBusStamp()],
        );
    }
}
