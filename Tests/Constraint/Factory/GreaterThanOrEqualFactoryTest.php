<?php

namespace JBen87\ParsleyBundle\Tests\Constraint\Factory;

use JBen87\ParsleyBundle\Constraint\Constraint;
use JBen87\ParsleyBundle\Constraint\Constraints as ParsleyAssert;
use JBen87\ParsleyBundle\Constraint\Factory\FactoryInterface;
use JBen87\ParsleyBundle\Constraint\Factory\GreaterThanOrEqualFactory;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;
use Symfony\Component\Validator\Constraints as Assert;

class GreaterThanOrEqualFactoryTest extends FactoryTestCase
{
    private const VALUE = 10;
    private const ORIGINAL_MESSAGE = 'This value should be greater than or equal to {{ compared_value }}.';
    private const TRANSLATED_MESSAGE = 'This value should be greater than or equal to '.self::VALUE.'.';

    /**
     * @inheritdoc
     */
    protected function setUpCreate(): void
    {
        $this->translator
            ->expects($this->once())
            ->method('trans')
            ->with(static::ORIGINAL_MESSAGE, ['{{ compared_value }}' => static::VALUE])
            ->willReturn(static::TRANSLATED_MESSAGE)
        ;
    }

    /**
     * @inheritdoc
     */
    protected function getExpectedConstraint(): Constraint
    {
        return new ParsleyAssert\GreaterThanOrEqual([
            'value' => static::VALUE,
            'message' => static::TRANSLATED_MESSAGE,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function getOriginalConstraint(): SymfonyConstraint
    {
        return new Assert\GreaterThanOrEqual(static::VALUE);
    }

    /**
     * @inheritdoc
     */
    protected function getUnsupportedConstraint(): SymfonyConstraint
    {
        return new Assert\Valid();
    }

    /**
     * @inheritdoc
     */
    protected function createFactory(): FactoryInterface
    {
        return new GreaterThanOrEqualFactory();
    }
}
