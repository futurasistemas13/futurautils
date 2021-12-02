<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Component\Document;

use Futuralibs\Futurautils\Component\AbstractComponent;
use Symfony\Component\Validator\Constraints as Assert;
use Futuralibs\Futurautils\Component\Document\Constraint as MyAssert;

/**
 * @MyAssert\CpfCnpj(mask="true")
 */
class Document extends AbstractComponent
{

    /**
     * @var string|null
     * @MyAssert\Optional({
     *      @Assert\NotBlank,
     *      @Assert\NotNull,
     *      @Assert\Choice(callback={"Futuralibs\Futurautils\Type\TypeDocument", "getArray"})
     * })
     */
    private ?string $type = null;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private string $number;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Document
     */
    public function setType(?string $type): self
    {
        $this->type = strtoupper($type);
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return Document
     */
    public function setNumber(string $number): self
    {
        $this->number = preg_replace('/[^0-9]/', '', $number);
        return $this;
    }

}