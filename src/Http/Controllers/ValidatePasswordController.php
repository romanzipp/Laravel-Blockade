<?php

namespace romanzipp\Blockade\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ValidatePasswordController extends Controller
{
    public function __invoke(Request $request): void
    {
        throw new BadRequestException('This route should not be called directly');
    }
}
