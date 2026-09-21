<?php

namespace App\Domain\Webservice;

class WebserviceService
{
    public function __construct(
        private WebserviceRepository $repository
    ) {}

    public function getMilitar($field, $value)
    {
        return $this->repository->militar($field, $value);
    }

    public function getTotais()
    {
        return $this->repository->totais();
    }
}
