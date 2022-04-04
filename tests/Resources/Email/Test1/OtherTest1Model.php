<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Tests\Resources\Email\Test1;

use RichId\EmailTemplateBundle\Domain\Model\EmailModelInterface;

final class OtherTest1Model implements EmailModelInterface
{
    private string $value;

    public function getValue(): string
    {
        return $this->value;
    }

    public static function build(string $value): self
    {
        $model = new self();

        $model->value = $value;

        return $model;
    }
}
