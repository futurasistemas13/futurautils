<?php

declare(strict_types=1);

namespace Futuralibs\Futurautils\Component\Document\Constraint;

use Futuralibs\Futurautils\Component\Document\Constraint\CpfCnpj;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CpfCnpjValidator extends ConstraintValidator
{

    const CPF_REGEXP = '/^(\d{3}\.\d{3}\.\d{3}\-\d{2})$/';
    const CNPJ_REGEXP = '/^(\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2})$/';

    const CPF = 'CPF';
    const CNPJ = 'CNPJ';

    protected bool $document = false;

    /**
     * @param mixed $value
     * @param Constraint $constraint
     * @return false|void
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof CpfCnpj) {
            throw new UnexpectedTypeException($constraint, CpfCnpj::class);
        }

        if (($value->getType() !== null ) && (!in_array(strtoupper($value->getType()), [self::CPF, self::CNPJ]))) {
            $this->context->buildViolation(
                $constraint->messageType,
                array('{{ type }}' => $value->getType())
            )
                ->setCode(CpfCnpj::CPF_CNPJ_TYPE_OF_ERROR)
                ->addViolation();
            return false;
        }

        if (!$this->validator($value, $constraint)) {
            $this->context->buildViolation(
                $constraint->messageDocument,
                array('{{ document }}' => $value->getNumber())
            )
                ->setCode(CpfCnpj::CPF_CNPJ_DOCUMENT_OF_ERROR)
                ->addViolation();
            return false;
        }

        if ($constraint->mask && !$this->maskValidator($value, $constraint)) {
            $this->context->addViolation(
                $constraint->messageMask,
                array('{{ mask }}' => $this->document ? self::CNPJ : self::CPF)
            );

            return false;
        }
    }

    /**
     * Verificando se está em um formato válido
     *
     * @param mixed $object
     * @param CpfCnpj $constraint
     * @return bool
     */
    protected function maskValidator(mixed $object, CpfCnpj $constraint): bool
    {

        if (($object->getType() === self::CPF) && !preg_match(self::CPF_REGEXP, $object->getNumber())) {
            return false;
        } else if (($object->getType() === self::CNPJ)  && !preg_match(self::CNPJ_REGEXP, $object->getNumber())) {
            return false;
        }

        return true;
    }

    /**
     * Verificar se é um documento válido
     *
     * @param mixed $object
     * @param CpfCnpj $constraint
     * @return bool
     */
    protected function validator(mixed $object, CpfCnpj $constraint): bool
    {
        $number = preg_replace('/[^0-9]/', '', $object->getNumber());

        if (empty($value)) {
            return false;
        }

        //Verificando se há números repetidos como: 0000000000, 1111111111, etc
        for ($i = 0; $i <= 9; $i++) {
            $repetidos = str_pad('', strlen($number), (string)$i);
            if ($number === $repetidos) {
                return false;
            }
        }

        if (!$object->getType() === null) {
            if (($object->getType() === self::CPF) && strlen($number) !== 11) {
                return false;
            } else if (($object->getType() === self::CNPJ) && strlen($number) !== 14) {
                return false;
            }
        } else {
            if (strlen($number) === 11) {
                $object->setType(self::CPF);
            } else if (strlen($number) === 14) {
                $object->setType(self::CNPJ);
            } else {
                throw new ConstraintDefinitionException(sprintf($constraint->messageException, $object->getType()));
            }
        }

        if (($object->getType() == self::CPF) && $number == "01234567890") {
            return false;
        }

        $weights = ($object->getType() == self::CNPJ) ? 6 : 11;

        //Para o CPF serão os pesos 10 e 11
        //Para o CNPJ serão os pesos 5 e 6
        for ($weight = ($weights - 1), $digit = (strlen($number) - 2); $weight <= $weights; $weight++, $digit++) {
            for ($sum = 0, $i = 0, $position = $weight; $position >= 2; $position--, $i++) {
                $sum = $sum + ($number[$i] * $position);

                // Parte específica para CNPJ Ex.: 5-4-3-2-9-8-7-6-5-4-3-2
                if (($object->getType() == self::CNPJ) && $position < 3 && $i < 5) {
                    $position = 10;
                }
            }

            $sum = ((10 * $sum) % 11) % 10;

            if ($number[$digit] != $sum) {
                return false;
            }
        }
        return true;
    }

}