<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace CustomerValidation\Form;

use CustomerValidation\Form\Base\CustomerValidationStatusCreateForm as BaseCustomerValidationStatusCreateForm;

/**
 * Class CustomerValidationStatusCreateForm
 * @package CustomerValidation\Form
 */
class CustomerValidationStatusCreateForm extends BaseCustomerValidationStatusCreateForm
{
    public function getTranslationKeys()
    {
        return array(
            "code" => "Code",
            "title" => "Title",
            "description" => "Description",
            "chapo" => "Chapo",
            "postscriptum" => "Postscriptum",
        );
    }
}
