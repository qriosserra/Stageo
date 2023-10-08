<?php

namespace Stageo\Controller;

class AdminController extends CoreController
{
    public function dashboard(): ControllerResponse
    {
        return new ControllerResponse(
            template: "admin/dashboard.html.twig"
        );
    }
}