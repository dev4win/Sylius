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

use Sylius\Bundle\CoreBundle\Command\Admin\Account\ResetPassword;
use Sylius\Bundle\CoreBundle\Security\UserPasswordResetterInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ResetPasswordHandler
{
    public function __construct(private UserPasswordResetterInterface $userPasswordResetter)
    {
    }

    public function __invoke(ResetPassword $command): void
    {
        $this->userPasswordResetter->reset($command->token, $command->newPassword);
    }
}
