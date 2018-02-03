<?php
declare(strict_types=1);

namespace WebUser\Action;

use Core\Lib\Flash\FlashMessageTrait;
use Core\Lib\Form\CaptchaResolver;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebUser\Event\AfterWebUserRegisterEvent;
use WebUser\Form\RegisterForm;
use WebUser\TableGateway\WebUserTableGatewayInterface;
use WebUser\ViewModel\RegisterViewModel;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\EventManager\EventManagerInterface;
use Zend\Expressive\Csrf\CsrfGuardInterface;
use Zend\Expressive\Csrf\CsrfMiddleware;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class WebUserRegisterAction
 * @package WebUser\Action
 */
final class WebUserRegisterPageAction implements MiddlewareInterface
{
    use FlashMessageTrait;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var TemplateRendererInterface
     */
    private $template;

    /**
     * @var WebUserTableGatewayInterface
     */
    private $tableGateway;

    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     * WebUserRegisterPageAction constructor.
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     * @param WebUserTableGatewayInterface $tableGateway
     * @param EventManagerInterface $eventManager
     */
    public function __construct(
        RouterInterface $router,
        TemplateRendererInterface $template,
        WebUserTableGatewayInterface $tableGateway,
        EventManagerInterface $eventManager
    ) {
        $this->router = $router;
        $this->template = $template;
        $this->tableGateway = $tableGateway;
        $this->eventManager = $eventManager;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        switch ($request->getMethod()) {
            case 'GET' :
                return $this->getAction($request);
                break;
            case 'POST' :
                return $this->postAction($request);
                break;
            default :
                return new EmptyResponse(404);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    private function getAction(ServerRequestInterface $request) : ResponseInterface
    {
        /** @var CsrfGuardInterface $guard */
        $guard = $request->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE);
        $flash = $this->getFlashFromRequest($request);

        $viewModel = RegisterViewModel::withArray([
            'form'  => RegisterForm::getForm(),
            'title' => 'Registration'
        ]);

        return new HtmlResponse(
            $this->template->render(
                'web-user::register',
                [
                    'view' => $viewModel,
                    'flash' => $flash,
                    'old' => $flash->old(),
                    '__csrf' => $guard->generateToken()
                ]
            )
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function postAction(ServerRequestInterface $request) : ResponseInterface
    {
        $flash = $this->getFlashFromRequest($request);

        $formData = new \ArrayObject();

        $form = RegisterForm::getForm();
        $form->setData($request->getParsedBody());
        $form->bind($formData);

        $captcha = CaptchaResolver::getCaptchaInstance();

        if (! $captcha->isValid((string) $request->getParsedBody()['g-recaptcha-response'], [])) {
            $flash['errors'] = ['g-recaptcha-response' => 'Captcha token is not valid'];
            $flash['old'] = (array) $request->getParsedBody();

            return new RedirectResponse($this->router->generateUri('register'));
        }

        if (! $form->isValid()) {
            $flash['errors'] = (array) $form->getMessages();
            $flash['old'] = (array) $request->getParsedBody();

            return new RedirectResponse($this->router->generateUri('register'));
        }

        $user = $this->tableGateway->findByEmail($formData['email']);

        // is email exist?
        if ($user !== null) {
            $flash['errors'] = ['email' => 'Email already registered'];
            $flash['old'] = (array) $form->getData();

            return new RedirectResponse($this->router->generateUri('register'));
        }

        $this->tableGateway->insert([
            'email'     => $form->getData()['email'],
            'password'  => password_hash($form->getData()['password'], PASSWORD_ARGON2_DEFAULT_TIME_COST),
            'status'    => 0
        ]);

        $flash['success'] = 'Please check your email to activate your account!';

        $this->eventManager->triggerEvent(new AfterWebUserRegisterEvent($user));

        return new RedirectResponse($this->router->generateUri('home'));
    }
}
