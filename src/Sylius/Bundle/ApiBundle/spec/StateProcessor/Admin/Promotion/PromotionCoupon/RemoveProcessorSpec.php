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

namespace spec\Sylius\Bundle\ApiBundle\StateProcessor\Admin\Promotion\PromotionCoupon;

use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\ApiBundle\Exception\PromotionCouponCannotBeRemoved;
use Sylius\Component\Core\Model\PromotionCouponInterface;

final class RemoveProcessorSpec extends ObjectBehavior
{
    function let(ProcessorInterface $removeProcessor): void
    {
        $this->beConstructedWith($removeProcessor);
    }

    function it_is_a_processor_interface(): void
    {
        $this->shouldImplement(ProcessorInterface::class);
    }

    public function it_processes_remove_operation(
        ProcessorInterface $removeProcessor,
        Operation $operation,
        PromotionCouponInterface $promotionCoupon,
    ) {
        $operation->implement(DeleteOperationInterface::class);
        $removeProcessor->process($promotionCoupon, $operation, [], [])->willReturn(null);

        $this->process($promotionCoupon, $operation, [], [])->shouldReturn(null);
    }

    public function it_throws_an_exception_when_foreign_key_constraint_violation_occurs(
        ProcessorInterface $removeProcessor,
        Operation $operation,
        PromotionCouponInterface $promotionCoupon,
    ) {
        $operation->implement(DeleteOperationInterface::class);
        $removeProcessor->process($promotionCoupon, $operation, [], [])->willThrow(ForeignKeyConstraintViolationException::class);

        $this->shouldThrow(PromotionCouponCannotBeRemoved::class)->during('process', [$promotionCoupon, $operation, [], []]);
    }

    public function it_throws_exception_if_operation_is_not_delete(
        Operation $operation,
        PromotionCouponInterface $promotionCoupon,
    ) {
        $this->shouldThrow(\InvalidArgumentException::class)->during('process', [$promotionCoupon, $operation, [], []]);
    }

    public function it_throws_exception_if_data_is_not_promotion_interface(
        Operation $operation,
        \stdClass $nonPromotion,
    ) {
        $this->shouldThrow(\InvalidArgumentException::class)->during('process', [$nonPromotion, $operation, [], []]);
    }
}
