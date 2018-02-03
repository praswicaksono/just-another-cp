<?php
declare(strict_types=1);

namespace Homepage\Action;

use GameServer\Lib\GameServerStatusInterface;
use Homepage\ViewModel\HomePageViewModel;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class HomePageAction
 * @package Homepage\Action
 */
class HomePageAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $template;

    /**
     * @var GameServerStatusInterface
     */
    private $serverStatus;

    /**
     * HomePageAction constructor.
     * @param TemplateRendererInterface $template
     */
    public function __construct(
        TemplateRendererInterface $template,
        GameServerStatusInterface $serverStatus
    )
    {
        $this->serverStatus = $serverStatus;
        $this->template = $template;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $viewModel = HomePageViewModel::withArray([
            'title' => 'Home',
            'isMapServerOnline' => $this->serverStatus->isMapServerOnline(),
            'isCharServerOnline' => $this->serverStatus->isCharServerOnline(),
            'isLoginServerOnline' => $this->serverStatus->isLoginServerOnline(),
        ]);

        return new HtmlResponse(
            $this->template->render('homepage::index', ['view' => $viewModel])
        );
    }
}
