<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace CustomerValidation\Form;

use CustomerValidation\Form\Base\CustomerValidationCreateForm as BaseCustomerValidationCreateForm;

/**
 * Class CustomerValidationCreateForm
 * @package CustomerValidation\Form
 */
class CustomerValidationCreateForm extends BaseCustomerValidationCreateForm
{
    public function getTranslationKeys()
    {
        return array(
            "customer_id" => "Customer id",
            "status" => "Status",
        );
    }
}
