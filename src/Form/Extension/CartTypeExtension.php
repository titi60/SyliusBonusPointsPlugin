<?php

declare(strict_types=1);

namespace Titi60\SyliusBonusPointsPlugin\Form\Extension;

use Titi60\SyliusBonusPointsPlugin\Context\CustomerBonusPointsContextInterface;
use Titi60\SyliusBonusPointsPlugin\Resolver\BonusPointsResolverInterface;
use Titi60\SyliusBonusPointsPlugin\Validator\Constraints\BonusPointsApply;
use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Sylius\Bundle\OrderBundle\Form\Type\CartType;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;

final class CartTypeExtension extends AbstractTypeExtension
{
    /** @var CustomerBonusPointsContextInterface */
    private $customerBonusPointsContext;

    /** @var BonusPointsResolverInterface */
    private $bonusPointsResolver;

    /** @var CartContextInterface */
    private $cartContext;

    public function __construct(
        CustomerBonusPointsContextInterface $customerBonusPointsContext,
        BonusPointsResolverInterface $bonusPointsResolver,
        CartContextInterface $cartContext
    ) {
        $this->customerBonusPointsContext = $customerBonusPointsContext;
        $this->bonusPointsResolver = $bonusPointsResolver;
        $this->cartContext = $cartContext;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (null === $this->customerBonusPointsContext->getCustomerBonusPoints()) {
            return;
        }

        /** @var OrderInterface $cart */
        $cart = $this->cartContext->getCart();

        if ($this->bonusPointsResolver->resolveBonusPoints($cart) === 0) {
            return;
        }

        $builder
            ->add('bonusPoints', MoneyType::class, [
                'required' => false,
                'currency' => false,
                'constraints' => [
                    new Range([
                        'min' => 0,
                        'groups' => ['sylius'],
                    ]),
                    new BonusPointsApply([
                        'groups' => ['sylius'],
                    ])
                ],
                'data' => null
            ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [
            CartType::class
        ];
    }
}
