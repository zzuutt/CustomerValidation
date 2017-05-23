<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace CustomerValidation\EventListeners;

use CustomerValidation\CustomerValidation;
use CustomerValidation\Model\CustomerValidationQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Customer\CustomerCreateOrUpdateEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Template\ParserInterface;
use Thelia\Log\Tlog;
use Thelia\Mailer\MailerFactory;
use Thelia\Model\ConfigQuery;
use Thelia\Model\MessageQuery;
use Thelia\Model\LangQuery;


/**
 * Class SendMail
 * @package CustomerValidation\Listener
 * @author Zzuutt34 <zzuutt34@free.fr>
 */
class SendMail implements EventSubscriberInterface
{

    protected $parser;

    protected $mailer;

    public function __construct(ParserInterface $parser, MailerFactory $mailer)
    {
        $this->parser = $parser;
        $this->mailer = $mailer;
    }

    public function updateStatus(CustomerCreateOrUpdateEvent $event)
    {
        $customer = $event->getCustomer();
        $customer_id = $customer->getId();
        $status = CustomerValidationQuery::create()->filterById($customer_id)->findOne();

        if ($status->getStatus() === 2 ) {
            $contact_email = ConfigQuery::getStoreEmail();

            if ($contact_email) {

                $message = MessageQuery::create()
                    ->filterByName('mail_customer_validation')
                    ->findOne();

                if (false === $message) {
                    throw new \Exception("Failed to load message 'order_confirmation'.");
                }

                $this->parser->assign('customer_id', $customer_id);
                $locale = LangQuery::create()->filterById($customer->getLangId())->findOne();
                $message
                    ->setLocale($locale->getLocale());

                $instance = \Swift_Message::newInstance()
                    ->addTo($customer->getEmail(), $customer->getFirstname()." ".$customer->getLastname())
                    ->addFrom($contact_email, ConfigQuery::getStoreName())
                ;

                // Build subject and body

                $message->buildMessage($this->parser, $instance);

                $this->mailer->send($instance);

                Tlog::getInstance()->debug("Customer Validation message sent to customer ".$customer->getEmail());
            }
            else {
                 Tlog::getInstance()->debug("Customer Validation message no contact email customer_id", $customer->getId());
            }
        }
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            TheliaEvents::CUSTOMER_UPDATEACCOUNT => array("updateStatus", 5)
        );
    }
}
