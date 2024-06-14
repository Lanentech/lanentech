<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Director;
use App\Entity\Lanentech;
use App\Validator\Constraint\Directors;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\Collection as DoctrineCollection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;

readonly class LanentechFactory extends BaseFactory implements LanentechFactoryInterface
{
    public function create(
        string $name,
        int $companyNumber,
        CarbonImmutable $incorporationDate,
        DoctrineCollection $directors,
    ): Lanentech {
        $this->performPreValidationChecks(
            value: $this->getPreValidationData($directors),
            constraints: $this->getPreValidationValidationConstraints(),
        );

        $lanentech = new Lanentech();
        $lanentech->setName($name);
        $lanentech->setCompanyNumber($companyNumber);
        $lanentech->setIncorporationDate($incorporationDate);

        if ($directors->count() > 0) {
            foreach ($directors as $director) {
                $lanentech->addDirector($director);
            }
        }

        $this->validateObject($lanentech);

        return $lanentech;
    }

    /**
     * @param DoctrineCollection<int, Director> $directors
     *
     * @return array<string, mixed>
     */
    private function getPreValidationData(DoctrineCollection $directors): array
    {
        return [
            'directors' => $directors,
        ];
    }

    /**
     *  This should return an array of Symfony Constraints, that will be used to pre-validate the data passed into
     *  the `create` method.
     *
     * @return array<int, Constraint>
     */
    protected function getPreValidationValidationConstraints(): array
    {
        return [
            new Collection([
                'directors' => [
                    new Directors(),
                ],
            ]),
        ];
    }
}
