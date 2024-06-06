<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Address;
use App\Entity\Company;

readonly class CompanyFactory extends BaseFactory implements CompanyFactoryInterface
{
    public function create(
        string $name,
        string $ident,
        string $type,
        int $companyNumber,
        ?Address $address = null,
    ): Company {
        $company = new Company();
        $company->setName($name);
        $company->setIdent($ident);
        $company->setType($type);
        $company->setIdent($ident);
        $company->setCompanyNumber($companyNumber);
        $company->setAddress($address);

        $this->validateObject($company);

        return $company;
    }
}
