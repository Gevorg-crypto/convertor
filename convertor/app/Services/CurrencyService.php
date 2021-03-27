<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    /**
     * @var array
     */
    private array $cbrResponse;

    public function __construct()
    {
        try {
            $cbrUrlCurl = Http::get('http://www.cbr.ru/scripts/XML_daily.asp'); // Cbr Url request
            $xml = simplexml_load_string($cbrUrlCurl->body(), "SimpleXMLElement", LIBXML_NOCDATA); // get simple xml
            $json = json_encode($xml); // convert xml to json
            $array = json_decode($json, TRUE); // convert json to array
            $currency = [];
            foreach ($array['Valute'] as $item) {
                $currency[$item['CharCode']] = [
                    'value' => $item['Value'],
                    'nominal' => $item['Nominal']
                ];
            }
            $this->cbrResponse = $currency;
            unset($currency);
        } catch (\Exception $exception) {
            Log::error($exception);
            return [
                'code' => 400,
                'message' => $exception->getMessage(),
            ];
        }
    }

    /**
     * @return array
     */
    public function getCurrency(): array
    {
        return array_keys($this->cbrResponse);
    }

    /**
     * @param $request
     * @return array
     */
    public function getConvert($request): array
    {
        try {
            $data = $request->validated();
            $from = $this->cbrResponse[strtoupper($data['from'])];
            $to = $this->cbrResponse[strtoupper($data['to'])];
            $output = round(($data['amount'] * str_replace(',', '.', $from['value']) / $from['nominal'])
                / str_replace(',', '.', $to['value']) * $to['nominal']); // Convert curse by rub
            return [
                'amount' => $output,
                'code' => 200,
                'message' => 'Convert Success',
            ];
        } catch (\Exception $exception) {
            Log::error($exception);
            return [
                'amount' => 0,
                'code' => 400,
                'message' => 'Convert Failed',
            ];
        }
    }
}
