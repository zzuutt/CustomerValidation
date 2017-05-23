<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace CustomerValidation\Event\Base;

use CustomerValidation\Event\Module\CustomerValidationEvents as ChildCustomerValidationEvents;

/*
 * Class CustomerValidationStatusEvents
 * @package CustomerValidation\Event\Base
 * @author TheliaStudio
 */
class CustomerValidationStatusEvents
{
    const CREATE = ChildCustomerValidationEvents::CUSTOMER_VALIDATION_STATUS_CREATE;
    const UPDATE = ChildCustomerValidationEvents::CUSTOMER_VALIDATION_STATUS_UPDATE;
    const DELETE = ChildCustomerValidationEvents::CUSTOMER_VALIDATION_STATUS_DELETE;
}