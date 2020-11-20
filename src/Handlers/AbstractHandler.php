<?php

namespace romanzipp\Blockade\Handlers;

use Illuminate\Http\Request;
use romanzipp\Blockade\Stores\Contracts\StoreContract;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class AbstractHandler
{
    private const CSS_ASSET_PATH = 'vendor/blockade/blockade.css';
    /**
     * @var \romanzipp\Blockade\Stores\Contracts\StoreContract
     */
    protected $store;

    public function __construct(StoreContract $store)
    {
        $this->store = $store;
    }

    /**
     * Check if the current request is excluded for blockade authentication.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function isExcludedForRequest(Request $request): bool
    {
        return $request->is(...config('blockade.excluded'))
            || $request->routeIs(...config('blockade.excluded'));
    }

    /**
     * Render the failed view and attach the current url for redirect.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $view
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function displayView(Request $request, string $view, array $data = []): SymfonyResponse
    {
        $data['returnTo'] = $request->fullUrl();
        $data['cssAsset'] = $this->getCssAssetUrl();
        $data['cssAssetLocal'] = $this->isCssAssetAvailableLocally();

        return response()->view($view, $data, 401);
    }

    /**
     * Check if the CSS asset provided by the package has been published.
     *
     * @return bool
     */
    private function isCssAssetAvailableLocally(): bool
    {
        return file_exists(public_path(self::CSS_ASSET_PATH));
    }

    /**
     * If the CSS asset has not been published a fallback version from the unpkg CDN will be used.
     *
     * @return string
     */
    private function getCssAssetUrl(): string
    {
        if ( ! $this->isCssAssetAvailableLocally()) {
            return 'https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css';
        }

        return asset(self::CSS_ASSET_PATH);
    }
}
