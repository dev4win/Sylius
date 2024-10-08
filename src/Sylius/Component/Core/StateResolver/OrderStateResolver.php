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

namespace Sylius\Component\Core\StateResolver;

use Sylius\Abstraction\StateMachine\StateMachineInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\OrderPaymentStates;
use Sylius\Component\Core\OrderShippingStates;
use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Order\OrderTransitions;
use Sylius\Component\Order\StateResolver\StateResolverInterface;
use Webmozart\Assert\Assert;

final class OrderStateResolver implements StateResolverInterface
{
    public function __construct(private StateMachineInterface $stateMachine)
    {
    }

    public function resolve(BaseOrderInterface $order): void
    {
        Assert::isInstanceOf($order, OrderInterface::class);

        if (
            $this->canOrderBeFulfilled($order) &&
            $this->stateMachine->can($order, OrderTransitions::GRAPH, OrderTransitions::TRANSITION_FULFILL)
        ) {
            $this->stateMachine->apply($order, OrderTransitions::GRAPH, OrderTransitions::TRANSITION_FULFILL);
        }
    }

    private function canOrderBeFulfilled(OrderInterface $order): bool
    {
        return
            (OrderPaymentStates::STATE_PAID === $order->getPaymentState() ||
            OrderPaymentStates::STATE_PARTIALLY_REFUNDED === $order->getPaymentState()) &&
            OrderShippingStates::STATE_SHIPPED === $order->getShippingState()
        ;
    }
}
