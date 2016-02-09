<?php

namespace Loobee\Ddd\Infrastructure\Domain\Mailer;

use Twig_Environment;
use Loobee\Ddd\Domain\Mailer\MailerMessage;
use Loobee\Ddd\Domain\Mailer\MailerMessageBuilder;
use Loobee\WorldWideWeb\Domain\Model\EmailAddress;

class TwigMailerMessageBuilder extends MailerMessageBuilder
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }


    public function build(array $parameters = [])
    {
        $template = $this->twig->loadTemplate($parameters['view']);

        return new MailerMessage(
            new EmailAddress($this->from),
            $this->to,
            $template->renderBlock('subject', $parameters['vars']),
            $template->renderBlock('body_text', $parameters['vars']),
            $template->renderBlock('body_html', $parameters['vars'])
        );
    }
}