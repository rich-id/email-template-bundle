<?php

declare(strict_types=1);

namespace RichId\EmailTemplateBundle\Domain\Email\Trait;

use RichId\EmailTemplateBundle\Domain\Model\EmailModelInterface;

trait EmailDataTrait
{
    protected ?EmailModelInterface $data = null;

    public function setData(?EmailModelInterface $data): self
    {
        $this->data = $data;

        return $this;
    }
}
