<?php

namespace App\Controller;

use Symfony\Component\Form\FormInterface;

trait FormErrorTrait
{
    /**
     * @return array<mixed>
     */
    private function getFlattenErrors(FormInterface $form): array
    {
        return iterator_to_array(
            new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->getErrorsFromForm($form))),
        );
    }
    /**
     * @return array<mixed>
     */
    private function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ([] !== $childErrors = $this->getErrorsFromForm($childForm)) {
                $errors[$childForm->getName()] = $childErrors;
            }
        }

        return $errors;
    }

}
