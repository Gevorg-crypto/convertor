<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiConvertRequest;
use App\Services\CurrencyService;

class BankOfRassiaController extends Controller
{

    /**
     * @var CurrencyService
     */
    protected CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * @return array
     */
    public function getCurrency(): array
    {
        return $this->currencyService->getCurrency();
    }

    /**
     * @param ApiConvertRequest $request
     * @return array
     */
    public function postConvert(ApiConvertRequest $request): array
    {
        return $this->currencyService->getConvert($request);
    }
}
