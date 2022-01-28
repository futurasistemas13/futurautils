<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Constraint;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Afranio Martins <afranioce@gmail.com>
 *
 * @api
 */
class CpfCnpj extends Constraint
{
    public bool $cpf = false;
    public bool $cnpj = false;
    public bool $mask = false;
    public string $messageMask = 'The {{ type }} is not valid.';
    public string $message = 'The {{ type }} informed is not valid.';

//    public function validatedBy(): string
//    {
//        return static::class.'Validator';
//    }
//
//    public function getTargets(): array|string
//    {
//        return self::PROPERTY_CONSTRAINT;
//    }

}