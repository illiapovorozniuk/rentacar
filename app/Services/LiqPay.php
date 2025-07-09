<?php

namespace App\Services;

class LiqPay
{
    private string $public_key;
    private string $private_key;

    public function __construct(string $public_key, string $private_key)
    {
        $this->public_key = $public_key;
        $this->private_key = $private_key;
    }

    public function cnb_form(array $params): string
    {
        $params['public_key'] = $this->public_key;
        $data = base64_encode(json_encode($params));
        $signature = base64_encode(sha1($this->private_key . $data . $this->private_key, true));

        return '
            <form method="POST" action="https://www.liqpay.ua/api/3/checkout" accept-charset="utf-8">
                <input type="hidden" name="data" value="' . $data . '" />
                <input type="hidden" name="signature" value="' . $signature . '" />
                <button type="submit">Оплатити через LiqPay</button>
            </form>
        ';
    }
}
