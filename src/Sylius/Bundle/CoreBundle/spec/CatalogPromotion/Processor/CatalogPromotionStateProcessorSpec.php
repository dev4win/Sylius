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

namespace spec\Sylius\Bundle\CoreBundle\CatalogPromotion\Processor;

use PhpSpec\ObjectBehavior;
use Sylius\Abstraction\StateMachine\StateMachineInterface;
use Sylius\Bundle\CoreBundle\CatalogPromotion\Checker\CatalogPromotionEligibilityCheckerInterface;
use Sylius\Bundle\CoreBundle\CatalogPromotion\Processor\CatalogPromotionStateProcessorInterface;
use Sylius\Component\Core\Model\CatalogPromotionInterface;
use Sylius\Component\Promotion\Model\CatalogPromotionTransitions;

final class CatalogPromotionStateProcessorSpec extends ObjectBehavior
{
    function let(
        CatalogPromotionEligibilityCheckerInterface $catalogPromotionEligibilityChecker,
        StateMachineInterface $stateMachine,
    ): void {
        $this->beConstructedWith($catalogPromotionEligibilityChecker, $stateMachine);
    }

    function it_implements_catalog_promotion_state_processor_interface(): void
    {
        $this->shouldImplement(CatalogPromotionStateProcessorInterface::class);
    }

    function it_processes_a_catalog_promotion(
        CatalogPromotionEligibilityCheckerInterface $catalogPromotionEligibilityChecker,
        CatalogPromotionInterface $catalogPromotion,
        StateMachineInterface $stateMachine,
    ): void {
        $catalogPromotionEligibilityChecker->isCatalogPromotionEligible($catalogPromotion)->willReturn(true);

        $stateMachine->can($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_PROCESS)->willReturn(true);
        $stateMachine->apply($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_PROCESS)->shouldBeCalled();

        $stateMachine->apply($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_ACTIVATE)->shouldNotBeCalled();
        $stateMachine->apply($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_DEACTIVATE)->shouldNotBeCalled();

        $this->process($catalogPromotion);
    }

    function it_activates_a_catalog_promotion(
        CatalogPromotionEligibilityCheckerInterface $catalogPromotionEligibilityChecker,
        CatalogPromotionInterface $catalogPromotion,
        StateMachineInterface $stateMachine,
    ): void {
        $catalogPromotionEligibilityChecker->isCatalogPromotionEligible($catalogPromotion)->willReturn(true);

        $stateMachine->can($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_PROCESS)->willReturn(false);
        $stateMachine->can($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_ACTIVATE)->willReturn(true);
        $stateMachine->apply($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_ACTIVATE)->shouldBeCalled();

        $stateMachine->apply($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_PROCESS)->shouldNotBeCalled();
        $stateMachine->apply($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_DEACTIVATE)->shouldNotBeCalled();

        $this->process($catalogPromotion);
    }

    function it_deactivates_a_catalog_promotion(
        CatalogPromotionEligibilityCheckerInterface $catalogPromotionEligibilityChecker,
        CatalogPromotionInterface $catalogPromotion,
        StateMachineInterface $stateMachine,
    ): void {
        $catalogPromotionEligibilityChecker->isCatalogPromotionEligible($catalogPromotion)->willReturn(false);

        $stateMachine->can($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_PROCESS)->willReturn(false);
        $stateMachine->can($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_DEACTIVATE)->willReturn(true);
        $stateMachine->apply($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_DEACTIVATE)->shouldBeCalled();

        $stateMachine->apply($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_PROCESS)->shouldNotBeCalled();
        $stateMachine->apply($catalogPromotion, CatalogPromotionTransitions::GRAPH, CatalogPromotionTransitions::TRANSITION_ACTIVATE)->shouldNotBeCalled();

        $this->process($catalogPromotion);
    }
}
