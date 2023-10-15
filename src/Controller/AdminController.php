<?php

namespace Stageo\Controller;

class AdminController extends CoreController
{
    public function dashboard(): Response
    {
        return new Response(
            template: "admin/dashboard.html.twig"
        );
    }
}