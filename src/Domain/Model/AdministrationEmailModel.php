<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Model;

final class AdministrationEmailModel
{
    public string $slug;
    public string $name;
    public string $value;

    /** @var string[] */
    public array $allowedValues;

    /** @param string[] $allowedValues */
    public static function build(
        string $slug,
        string $name,
        string $value,
        array $allowedValues
    ): self {
        $model = new self();

        $model->slug = $slug;
        $model->name = $name;
        $model->value = $value;
        $model->allowedValues = $allowedValues;

        return $model;
    }
}
