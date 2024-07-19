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

    public ?string $categorySlug = null;
    public ?string $categoryName = null;

    /** @param string[] $allowedValues */
    public static function build(
        string $slug,
        string $name,
        string $value,
        array $allowedValues,
        ?string $categorySlug = null,
        ?string $categoryName = null
    ): self {
        $model = new self();

        $model->slug = $slug;
        $model->name = $name;
        $model->value = $value;
        $model->allowedValues = $allowedValues;
        $model->categorySlug = $categorySlug;
        $model->categoryName = $categoryName;

        return $model;
    }
}
