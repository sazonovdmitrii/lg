<?php
namespace App\Service;
use App\Service\ApiManager\ApiManager;

class OnService extends ApiManager
{
    const URL = 'https://www.ochkov.net/landing/sync';

    public function __construct()
    {
        $this->setUrl(self::URL);
    }
}