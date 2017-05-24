<?php

namespace CustomerValidation\EventListeners;

use CustomerValidation\CustomerValidation;
use CustomerValidation\Model\CustomerValidation as CustomerValidationModel;
use CustomerValidation\Model\CustomerValidationQuery;
use CustomerValidation\Model\CustomerValidationStatusQuery;
use CustomerValidation\Model\CustomerValidationStatusI18nQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\TheliaFormEvent;
use Thelia\Core\Event\Customer\CustomerCreateOrUpdateEvent;
use Thelia\Core\Event\Customer\CustomerEvent;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\Translation\Translator;



class AddParamToCustomerUpdateFormListener extends BaseAction implements EventSubscriberInterface
{
    /** @var Request $request */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function updateCustomer(CustomerCreateOrUpdateEvent $event)
    {
        $this->traiterChampSupplementaire($event, 'thelia_customer_update');
    }

    public function createCustomer(CustomerEvent $event)
    {
        $this->addCustomerValidation($event);
    }

    protected function traiterChampSupplementaire(CustomerCreateOrUpdateEvent $event, $formName)
    {

        $formData = $this->request->get($formName, []);
        $customer_id = $event->getCustomer()->getId();

        $customerValidationModel = CustomerValidationQuery::create()->findOneById($customer_id);
        if (null === $customerValidationModel) {
            $customerValidationModel = new CustomerValidationModel();
            $customerValidationModel->setId($customer_id);
        }
        if (isset($formData['status'])) {
            $ChampStatus = $formData['status'];
            $customerValidationModel
                ->setStatus($ChampStatus)
            ;
        }
        else {
            $customerValidationModel
                ->setStatus(1)
            ;
        }
        $customerValidationModel
            ->save()
        ;

    }

    protected function addCustomerValidation(CustomerEvent $event)
    {

        $customer_id = $event->getCustomer()->getId();

        $customerValidationModel = CustomerValidationQuery::create()->findOneById($customer_id);
        if (null === $customerValidationModel) {
            $customerValidationModel = new CustomerValidationModel();
            $customerValidationModel->setId($customer_id);

            $customerValidationModel
                ->setStatus(1)
            ;

            $customerValidationModel
                ->save()
            ;
        }

    }


    public function ajouterChampFormulaire(TheliaFormEvent $event)
    {
        $customerId = $this->request->get('customer_id');
        $event->getForm()->getFormBuilder()
            ->add(
                'status',
                'choice',
                [
                    'choices' => $this->getCustomerValidationStatusList(),
                    'data' => $this->getCustomerValidationStatusValue($customerId),
                    'label' => Translator::getInstance()->trans('Status', [], CustomerValidation::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => 'status'
                    ]
                ]
            )
        ;
    }

    public function getCustomerValidationStatusList()
    {
        $locale = $this->request->getSession()->getLang()->getLocale();
        $list_status = [];
        $status = CustomerValidationStatusQuery::create()->joinWithI18n($locale)->orderById();
        foreach($status as $value)
        {
            $key = $value->getTitle();
            $list_status[$value->getId()] = $key;
        }
        return $list_status;
    }

    public function getCustomerValidationStatusValue($customerId)
    {
        $type_status = 0;
        if($customerId) {
            $value = CustomerValidationQuery::create()->filterById($customerId)->findOne();
            if (null !== $value)
            {
                $type_status = $value->getStatus();
            }
        }
        return $type_status;
    }

    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_customer_update" => ['ajouterChampFormulaire', 128],
            TheliaEvents::CUSTOMER_UPDATEACCOUNT => array("updateCustomer", 10),
            TheliaEvents::AFTER_CREATECUSTOMER => array("createCustomer", 10),
        ];
    }
}
