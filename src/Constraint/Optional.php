<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Constraint;


use Symfony\Component\Validator\Constraints\Composite;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 */
class Optional extends Composite
{

    public const OPTIONAL_OF_ERROR = 'c120f066-921f-40cd-9fa5-05c690986b53';

    protected static $errorNames = [
        self::OPTIONAL_OF_ERROR => 'OPTIONAL_OF_ERROR',
    ];

    public $constraints = [];
    public $message = 'This value should satisfy at least one of the following constraints:';
    public $messageCollection = 'Each element of this collection should satisfy its own set of constraints.';
    public $includeInternalMessages = true;

    public function getDefaultOption(): string
    {
        return 'constraints';
    }

    public function getRequiredOptions(): array
    {
        return ['constraints'];
    }

    protected function getCompositeOption(): string
    {
        return 'constraints';
    }
}