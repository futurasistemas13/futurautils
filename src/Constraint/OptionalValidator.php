<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Constraint;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;

class OptionalValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {

        if (!$constraint instanceof Optional) {
            throw new UnexpectedTypeException($constraint, Optional::class);
        }

        if (!isset($value)) {
            return ;
        }

        $validator = $this->context->getValidator();

        foreach ($constraint->constraints as $key => $item) {
            $executionContext = clone $this->context;
            $executionContext->setNode($value, $this->context->getObject(), $this->context->getMetadata(), $this->context->getPropertyPath());
            $violations = $validator->inContext($executionContext)->validate($value, $item, $this->context->getGroup())->getViolations();

            if (\count($this->context->getViolations()) === \count($violations)) {
                continue;
            }

            if ($constraint->includeInternalMessages) {
                $message = '';

                if ($item instanceof All || $item instanceof Collection) {
                    $message .= $constraint->messageCollection;
                } else {
                    $message .= $violations->get(\count($violations) - 1)->getMessage();
                }

                $this->context->buildViolation($message)
                    ->setCode(Optional::OPTIONAL_OF_ERROR)
                    ->addViolation()
                ;

            }
        }

    }

}