<?php

namespace Stageo\Controller;

use Stageo\Lib\Response;

class AdminController
{
    public function dashboard(): Response
    {
        return new Response(
            template: "admin/dashboard.html.twig"
        );
    }
}