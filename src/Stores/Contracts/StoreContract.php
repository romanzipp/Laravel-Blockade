<?php

namespace romanzipp\Blockade\Stores\Contracts;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

interface StoreContract
{
    public function getHash(Request $request): ?string;

    public function storeSuccessState(Request $request, SymfonyResponse $response): SymfonyResponse;
}
