<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Component\Document\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CpfCnpj extends Constraint
{

    public bool $mask = false;

    public const CPF_CNPJ_DOCUMENT_OF_ERROR = 'CPF_CNPJ_DOCUMENT_OF_ERROR';
    public const CPF_CNPJ_MASK_OF_ERROR = 'CPF_CNPJ_MASK_OF_ERROR';
    public const CPF_CNPJ_TYPE_OF_ERROR = 'CPF_CNPJ_DOCUMENT_OF_ERROR';

    protected static $errorNames = [
        self::CPF_CNPJ_DOCUMENT_OF_ERROR => 'CPF_CNPJ_DOCUMENT_OF_ERROR',
        self::CPF_CNPJ_MASK_OF_ERROR => 'CPF_CNPJ_MASK_OF_ERROR',
        self::CPF_CNPJ_TYPE_OF_ERROR => 'CPF_CNPJ_TYPE_OF_ERROR'
    ];

    public string $messageType = 'This document type {{ type }} informed is not valid.';
    public string $messageMask = 'The {{ mask }} is not valid.';
    public string $messageDocument = 'This {{ document }} informed is not valid.';
    public string $messageException = 'Validation for %s expects a valid value';

    public function __construct(array $options = null, string $message = null, string $service = null, array $groups = null, $payload = null)
    {
        parent::__construct($options, $groups, $payload);
    }

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }

}