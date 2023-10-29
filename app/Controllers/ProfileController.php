<?php

namespace App\Controllers;

use App\Controllers\MainController;

class ProfileController extends MainController
{

    public function renderProfile(): void
    {
        $this->render();
    }
}