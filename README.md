## 1. Bundle description
- What this bundle do
    - Handle forms "behind the scenes", ***before*** controller's action is being called - keep this in mind,
    - Validate forms, and update Repository's state,
    - Read data from Request and keep it as form-bound model,
- What this bundle does't not do
    - You cannot define more than one form for same Request method (POST|GET|...)
    - With this package you cannot manage `validation groups` outside of Form class, however you can still manage them from there ([documentation](https://symfony.com/doc/current/form/validation_groups.html)) 
___
### 2. Before you go
In order to start working with this bundle, you have to understand that:
- Lucek\FormHandlerBundle\Repository\FormRequestRepository is **shared service** and it **should not** be modified manually (unless you know what you do),
- Most of this bundle's logic is managed by `symfony/form` package, this is only simplified version of whole process,
___
## 3. Installation 
```bash
composer require lucek/form-handler-bundle
```
___
## 4. Configuration
If you're using autowire feature under your symfony project, you should FQN to service ID map in order to use this package features:
```yaml
services:
    _defaults:
        autowire: true
        autoconfigure: true
    Lucek\FormHandlerBundle\Repository\FormRequestRepository: "@lucek.form_handler.repository.form_request_repository"
```
___
## 5. Usage
### 5.1. As simple as possible - click [here](/doc/simple.md)
### 5.2. With data from Request - click [here](/doc/data_from_request.md)
### 5.3. Multiple annotations - click [here](/doc/multiple_annotations.md)

## 6. The `FormRequestRepository` service
The `FormRequestRepository` is **mutable** service, and is shared between services in container (at least for now). Normally you shouldn't perform any changes to this service manually unless you're aware of what might happen next. In most cases you should use this service in **controller action only**

6.1. Repository state

| Request method | Configured for | getFormInstance()        | getMethod()          | getData()                         | isSubmitted() | isValid() | isFresh() | getValidation() |
| :--------------: | :--------------: | ------------------------ |:---------------------:| --------------------------------:| -------------:| ---------:| ---------:| ---------------:|
| GET | GET | instance of (object) App\Form\Type\TestType      | (string) GET | model | true | true | false | (array) [] |
| POST | GET | null      | (string) POST | null | false | true | true | (array) [] |


## 7. Validation
In order to work with validation (symfony-based) you have to install additional package (if missing) `symfony/validator`, then simply add `constraints` to your form, or work with `validation_groups` in form and create Assertions for your model.

To keep validation error structure same as configured form (with nesting), remember to work with `error_bubbling` and keep this property set to `false` (default value) for every form field.
