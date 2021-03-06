Controller:
```php
<?php
declare(strict_types=1);

namespace App\Controller;

use Lucek\FormHandlerBundle\Annotation\FormHandler;
use Lucek\FormHandlerBundle\Repository\FormRequestRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class IndexAction
 * Package App\Controller
 */
class IndexAction
{
    /**
     * @param FormRequestRepository $repository
     * @FormHandler(method="GET", form="App\Form\Type\TestType")
     * @FormHandler(method="POST", form="App\Form\Type\Test2Type")
     *                                         
     * @return Response
     */
    public function __invoke(FormRequestRepository $repository): Response
    {
        if(true === $repository->isSubmitted() && false === $repository->isValid()){
            return new JsonResponse(['errors' => $repository->getValidation()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['data' => $repository->getData()]);
    }
}

```
Form #1 class:
```php
<?php
declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class TestType
 * Package App\Form\Type
 */
class TestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('test', TextType::class, ['empty_data' => 'i\'m empty!']);
        $builder->add('xyz', TextType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'         => null,
                'allow_extra_fields' => true,
            ]
        );
    }

}
```
Form #2 class:
```php
<?php
declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TestType
 * Package App\Form\Type
 */
class Test2Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('some_property', TextType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'         => null,
                'allow_extra_fields' => true,
            ]
        );
    }

}
```
### Return to [index](https://github.com/kptLucek/symfony-form-handler-bundle)
