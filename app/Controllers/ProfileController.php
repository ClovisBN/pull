<?php

namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\PostModel;

class ProfileController extends MainController
{

    public function renderProfile(): void
    {
        $this->render();
    }
}