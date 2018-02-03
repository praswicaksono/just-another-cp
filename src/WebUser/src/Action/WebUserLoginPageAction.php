<?php
declare(strict_types=1);


namespace WebUser\Action;

use Core\Lib\Flash\FlashMessageTrait;
use Fig\Http\Message\StatusCodeInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebUser\Form\LoginForm;
use WebUser\Lib\Auth\AuthInterface;
use WebUser\TableGateway\WebUserTableGatewayInterface;
use WebUser\ViewModel\LoginPageViewModel;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Csrf\CsrfGuardInterface;
use Zend\Expressive\Csrf\CsrfMiddleware;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Session\SessionInterface;
use Zend\Expressive\Session\SessionMiddleware;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class WebUserLoginPageAction
 * @package WebUser\Action
 */
final class WebUserLoginPageAction implements MiddlewareInterface
{
    use FlashMessageTrait;

    /**
     * @var TemplateRendererInterface
     */
    private $template;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var AuthInterface
     */
    private $auth;

    /**
     * @var WebUserTableGatewayInterface
     */
    private $tableGateway;

    /**
     * WebUserLoginPageAction constructor.
     * @param TemplateRendererInterface $template
     * @param RouterInterface $router
     * @param AuthInterface $auth
     * @param WebUserTableGatewayInterface $tableGateway
     */
    public function __construct(
        TemplateRendererInterface $template,
        RouterInterface $router,
        AuthInterface $auth,
        WebUserTableGatewayInterface $tableGateway
    )
    {
        $this->template = $template;
        $this->router = $router;
        $this->auth = $auth;
        $this->tableGateway = $tableGateway;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        switch ($request->getMethod()) {
            case 'GET':
                return $this->getAction($request);
            case 'POST':
                return $this->postAction($request);
            default:
                return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
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

        $viewModel = LoginPageViewModel::withArray([
            'form'  => LoginForm::getForm(),
            'title' => 'Login'
        ]);

        return new HtmlResponse(
            $this->template->render(
                'web-user::login',
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

        $form = LoginForm::getForm();
        $form->setData($request->getParsedBody());
        $form->bind($formData);

        if (! $form->isValid()) {
            $flash['errors'] = (array) $form->getMessages();
            $flash['old'] = (array) $form->getData();

            return new RedirectResponse($this->router->generateUri('login'));
        }

        $user = $this->tableGateway->findByEmail($formData['email']);

        // is email exist?
        if ($user === null) {
            $flash['errors'] = ['email' => 'Email not found in our database'];
            $flash['old'] = (array) $form->getData();

            return new RedirectResponse($this->router->generateUri('login'));
        }

        // validate password
        if (! $this->auth->authenticate($formData['password'], $user['password'])) {
            $flash['errors'] = ['password' => 'Password is not valid'];
            $flash['old'] = (array) $form->getData();

            return new RedirectResponse($this->router->generateUri('login'));
        }

        /** @var SessionInterface $session */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        $session->set('web_user_id', $user['id']);

        $flash['success'] = 'You are successfully logged in';

        return new RedirectResponse($this->router->generateUri('home'));
    }
}
