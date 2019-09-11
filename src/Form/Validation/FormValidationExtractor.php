<?php
declare(strict_types=1);

namespace Lucek\FormHandlerBundle\Form\Validation;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

/**
 * Class FormValidationExtractor
 * Package Lucek\FormHandlerBundle\Form\Validation
 */
class FormValidationExtractor
{
    /**
     * @param FormInterface $form
     *
     * @return array
     */
    public function extract(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->extract($child);
            }
        }

        return $errors;
    }
}
