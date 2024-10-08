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

namespace Sylius\Bundle\PayumBundle\Extension;

use Payum\Core\Extension\Context;
use Payum\Core\Extension\ExtensionInterface;
use Payum\Core\Request\Generic;
use Payum\Core\Request\GetStatusInterface;
use Payum\Core\Request\Notify;
use Sylius\Abstraction\StateMachine\StateMachineInterface;
use Sylius\Bundle\PayumBundle\Request\GetStatus;
use Sylius\Component\Payment\Model\PaymentInterface;
use Sylius\Component\Payment\PaymentTransitions;

final class UpdatePaymentStateExtension implements ExtensionInterface
{
    public function __construct(private StateMachineInterface $factory)
    {
    }

    public function onPreExecute(Context $context): void
    {
    }

    public function onExecute(Context $context): void
    {
    }

    public function onPostExecute(Context $context): void
    {
        $previousStack = $context->getPrevious();
        $previousStackSize = count($previousStack);

        if ($previousStackSize > 1) {
            return;
        }

        if ($previousStackSize === 1) {
            $previousActionClassName = $previousStack[0]->getAction()::class;
            if (false === stripos($previousActionClassName, 'NotifyNullAction')) {
                return;
            }
        }

        $request = $context->getRequest();

        if (!$request instanceof Generic) {
            return;
        }

        if (!$request instanceof GetStatusInterface && !$request instanceof Notify) {
            return;
        }

        $payment = $request->getFirstModel();

        if (!$payment instanceof PaymentInterface) {
            return;
        }

        if (null !== $context->getException()) {
            return;
        }

        $context->getGateway()->execute($status = new GetStatus($payment));
        $value = $status->getValue();
        if ($payment->getState() !== $value && PaymentInterface::STATE_UNKNOWN !== $value) {
            $this->updatePaymentState($payment, $value);
        }
    }

    private function updatePaymentState(PaymentInterface $payment, string $nextState): void
    {
        if (null !== $transition = $this->factory->getTransitionToState($payment, PaymentTransitions::GRAPH, $nextState)) {
            $this->factory->apply($payment, PaymentTransitions::GRAPH, $transition);
        }
    }
}
