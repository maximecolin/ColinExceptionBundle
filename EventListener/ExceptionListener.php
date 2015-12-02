<?php

namespace Colin\Bundle\ExceptionBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Templating\EngineInterface;

class ExceptionListener
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var array
     */
    private $expcetions;

    /**
     * ExceptionListener constructor.
     *
     * @param EngineInterface $templating
     * @param array           $expcetions
     */
    public function __construct(EngineInterface $templating, array $expcetions)
    {
        $this->templating = $templating;
        $this->expcetions = $expcetions;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $class     = get_class($exception);

        if (isset($this->expcetions[$class])) {
            $response = new Response($this->templating->render($this->expcetions[$class]), 500);
            $event->setResponse($response);
        }
    }
}
