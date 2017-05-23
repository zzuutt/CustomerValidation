<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace CustomerValidation\Controller\Base;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Controller\Admin\AbstractCrudController;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Tools\URL;
use CustomerValidation\Event\CustomerValidationStatusEvent;
use CustomerValidation\Event\CustomerValidationStatusEvents;
use CustomerValidation\Model\CustomerValidationStatusQuery;

/**
 * Class CustomerValidationStatusController
 * @package CustomerValidation\Controller\Base
 * @author TheliaStudio
 */
class CustomerValidationStatusController extends AbstractCrudController
{
    public function __construct()
    {
        parent::__construct(
            "customer_validation_status",
            "id",
            "order",
            AdminResources::MODULE,
            CustomerValidationStatusEvents::CREATE,
            CustomerValidationStatusEvents::UPDATE,
            CustomerValidationStatusEvents::DELETE,
            null,
            null,
            "CustomerValidation"
        );
    }

    /**
     * Return the creation form for this object
     */
    protected function getCreationForm()
    {
        return $this->createForm("customer_validation_status.create");
    }

    /**
     * Return the update form for this object
     */
    protected function getUpdateForm($data = array())
    {
        if (!is_array($data)) {
            $data = array();
        }

        return $this->createForm("customer_validation_status.update", "form", $data);
    }

    /**
     * Hydrate the update form for this object, before passing it to the update template
     *
     * @param mixed $object
     */
    protected function hydrateObjectForm($object)
    {
        $data = array(
            "id" => $object->getId(),
            "code" => $object->getCode(),
            "title" => $object->getTitle(),
            "description" => $object->getDescription(),
            "chapo" => $object->getChapo(),
            "postscriptum" => $object->getPostscriptum(),
        );

        return $this->getUpdateForm($data);
    }

    /**
     * Creates the creation event with the provided form data
     *
     * @param mixed $formData
     * @return \Thelia\Core\Event\ActionEvent
     */
    protected function getCreationEvent($formData)
    {
        $event = new CustomerValidationStatusEvent();

        $event->setCode($formData["code"]);
        $event->setTitle($formData["title"]);
        $event->setDescription($formData["description"]);
        $event->setChapo($formData["chapo"]);
        $event->setPostscriptum($formData["postscriptum"]);

        return $event;
    }

    /**
     * Creates the update event with the provided form data
     *
     * @param mixed $formData
     * @return \Thelia\Core\Event\ActionEvent
     */
    protected function getUpdateEvent($formData)
    {
        $event = new CustomerValidationStatusEvent();

        $event->setId($formData["id"]);
        $event->setCode($formData["code"]);
        $event->setTitle($formData["title"]);
        $event->setDescription($formData["description"]);
        $event->setChapo($formData["chapo"]);
        $event->setPostscriptum($formData["postscriptum"]);

        return $event;
    }

    /**
     * Creates the delete event with the provided form data
     */
    protected function getDeleteEvent()
    {
        $event = new CustomerValidationStatusEvent();

        $event->setId($this->getRequest()->request->get("customer_validation_status_id"));

        return $event;
    }

    /**
     * Return true if the event contains the object, e.g. the action has updated the object in the event.
     *
     * @param mixed $event
     */
    protected function eventContainsObject($event)
    {
        return null !== $this->getObjectFromEvent($event);
    }

    /**
     * Get the created object from an event.
     *
     * @param mixed $event
     */
    protected function getObjectFromEvent($event)
    {
        return $event->getCustomerValidationStatus();
    }

    /**
     * Load an existing object from the database
     */
    protected function getExistingObject()
    {
        return CustomerValidationStatusQuery::create()
            ->findPk($this->getRequest()->query->get("customer_validation_status_id"))
        ;
    }

    /**
     * Returns the object label form the object event (name, title, etc.)
     *
     * @param mixed $object
     */
    protected function getObjectLabel($object)
    {
        return $object->getTitle();
    }

    /**
     * Returns the object ID from the object
     *
     * @param mixed $object
     */
    protected function getObjectId($object)
    {
        return $object->getId();
    }

    /**
     * Render the main list template
     *
     * @param mixed $currentOrder , if any, null otherwise.
     */
    protected function renderListTemplate($currentOrder)
    {
        $this->getParser()
            ->assign("order", $currentOrder)
        ;

        return $this->render("customer-validation-statuss");
    }

    /**
     * Render the edition template
     */
    protected function renderEditionTemplate()
    {
        $this->getParserContext()
            ->set(
                "customer_validation_status_id",
                $this->getRequest()->query->get("customer_validation_status_id")
            )
        ;

        return $this->render("customer-validation-status-edit");
    }

    /**
     * Must return a RedirectResponse instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToEditionTemplate()
    {
        $id = $this->getRequest()->query->get("customer_validation_status_id");

        return new RedirectResponse(
            URL::getInstance()->absoluteUrl(
                "/admin/module/CustomerValidation/customer_validation_status/edit",
                [
                    "customer_validation_status_id" => $id,
                ]
            )
        );
    }

    /**
     * Must return a RedirectResponse instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToListTemplate()
    {
        return new RedirectResponse(
            URL::getInstance()->absoluteUrl("/admin/module/CustomerValidation/customer_validation_status")
        );
    }
}
