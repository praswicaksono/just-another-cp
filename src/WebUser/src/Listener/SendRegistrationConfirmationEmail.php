<?php
declare(strict_types=1);

namespace WebUser\Listener;

use WebUser\Event\AfterWebUserRegisterEvent;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;

/**
 * Class SendRegistrationConfirmationEmail
 * @package WebUser\Listener
 */
final class SendRegistrationConfirmationEmail
{
    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * @var TemplateRendererInterface
     */
    private $template;

    /**
     * @var array
     */
    private $config;

    /**
     * SendRegistrationConfirmationEmail constructor.
     * @param TransportInterface $transport
     * @param TemplateRendererInterface $template
     * @param array $config
     */
    public function __construct(
        TransportInterface $transport,
        TemplateRendererInterface $template,
        array $config
    ) {
        $this->transport = $transport;
        $this->template = $template;
        $this->config = $config;
    }

    /**
     * @param AfterWebUserRegisterEvent $event
     */
    public function __invoke(AfterWebUserRegisterEvent $event)
    {
        $message = new Message();
        $message->setSubject($this->config['name'] . '- Confirm your email');
        $message->setFrom($this->config['from_email'], $this->config['from_name']);
        $message->setTo($event->getParam('user')['email']);
        $message->setBody($this->template->render('web-user::email/register'));

        $this->transport->send($message);
    }
}
