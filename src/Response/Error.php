<?php

declare(strict_types=1);

namespace App\Response;

use JsonSerializable;
use Symfony\Component\Form\FormInterface;

class Error implements JsonSerializable
{
    public function __construct(
        private readonly FormInterface $form,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'status' => 'error',
            'errors' => $this->getFormErrors(),
        ];
    }

    private function getFormErrors()
    {
        $errors = [];
        foreach ($this->form->all() as $child) {
            if (!$child->isValid()) {
                $errorsChild = [];

                foreach ($child->getErrors(true) as $item) {
                    $errorsChild[] = $item;
                }

                $errors[$child->getName()] = array_map(fn ($error) => $error->getMessage(), $errorsChild);
            }
        }

        return $errors;
    }
}
