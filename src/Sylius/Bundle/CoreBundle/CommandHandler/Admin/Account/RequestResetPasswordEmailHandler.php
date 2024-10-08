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

namespace Sylius\Bundle\CoreBundle\CommandHandler\Admin\Account;

use Sylius\Bundle\CoreBundle\Command\Admin\Account\RequestResetPasswordEmail;
use Sylius\Bundle\CoreBundle\Command\Admin\Account\SendResetPasswordEmail;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Component\Clock\ClockInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

#[AsMessageHandler]
final class RequestResetPasswordEmailHandler
{
    /** @param UserRepositoryInterface<AdminUserInterface> $userRepository */
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private GeneratorInterface $generator,
        private ClockInterface $clock,
        private MessageBusInterface $commandBus,
    ) {
    }

    public function __invoke(RequestResetPasswordEmail $requestResetPasswordEmail): void
    {
        /** @var AdminUserInterface|null $adminUser */
        $adminUser = $this->userRepository->findOneByEmail($requestResetPasswordEmail->email);
        if (null === $adminUser) {
            return;
        }

        $adminUser->setPasswordResetToken($this->generator->generate());
        $adminUser->setPasswordRequestedAt($this->clock->now());

        $this->commandBus->dispatch(
            new SendResetPasswordEmail($adminUser->getEmail(), $adminUser->getLocaleCode()),
            [new DispatchAfterCurrentBusStamp()],
        );
    }
}
