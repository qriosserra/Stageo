<?php

namespace Stageo\Controller;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MainController extends CoreController
{
    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function home(): ControllerResponse
    {
        return new ControllerResponse(
            template: "home.html.twig"
        );
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function about(): ControllerResponse
    {
        return new ControllerResponse(
            template: "about.html.twig"
        );
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function faq(): ControllerResponse
    {
        return new ControllerResponse(
            template: "faq.html.twig"
        );
    }
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function contactForm(): ControllerResponse
    {
        return new ControllerResponse(
            template: "contact.html.twig"
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function contact(): ControllerResponse
    {
        return new ControllerResponse();
    }
}