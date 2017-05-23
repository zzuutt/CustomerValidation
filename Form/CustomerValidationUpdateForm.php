<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace CustomerValidation\Form;

use CustomerValidation\Form\Base\CustomerValidationUpdateForm as BaseCustomerValidationUpdateForm;

/**
 * Class CustomerValidationUpdateForm
 * @package CustomerValidation\Form
 */
class CustomerValidationUpdateForm extends BaseCustomerValidationUpdateForm
{
    public function getTranslationKeys()
    {
        return array(
            "id" => "id",
            "customer_id" => "customer_id",
            "status" => "status",
        );
    }
}