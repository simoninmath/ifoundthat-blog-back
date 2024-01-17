<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

final class RegexpFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        // Otherwise filter is applied to order and page as well
        if (
            !$this->isPropertyEnabled($property, $resourceClass) ||
            !$this->isPropertyMapped($property, $resourceClass)
        ) {
            return;
        }

        $parameterName = $queryNameGenerator->generateParameterName($property); // Generate a unique parameter name to avoid collisions with other filters
        $queryBuilder
            ->andWhere(sprintf('REGEXP(o.%s, :%s) = 1', $property, $parameterName))
            ->setParameter($parameterName, $value);
    }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }

        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description["regexp_$property"] = [
                'property' => $property,
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
                'description' => 'Filter using a regex. This will appear in the OpenApi documentation!',
                'openapi' => [
                    'example' => 'Custom example that will be in the documentation and be the default value of the sandbox',
                    'allowReserved' => false,// if true, query parameters will be not percent-encoded
                    'allowEmptyValue' => true,
                    'explode' => false, // to be true, the type must be Type::BUILTIN_TYPE_ARRAY, ?product=blue,green will be ?product=blue&product=green
                ],
            ];
        }

        return $description;
    }
}



// namespace App\ApiFilter;

// use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
// // use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractFilter;
// use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
// use Doctrine\ORM\QueryBuilder;

// final class SearchFilter extends AbstractFilter
// {
//     protected function filterProperty(
//         string $property,
//         $value,
//         QueryBuilder $queryBuilder,
//         QueryNameGeneratorInterface $queryNameGenerator,
//         string $resourceClass,
//         string $operationName = null
//     ) {
//         // Appliquez votre logique de liste blanche ici
//         // Assurez-vous de sécuriser correctement la recherche pour éviter les injections ou les abus
//         if ('search' === $property && $this->isPropertyEnabled($property, $resourceClass)) {
//             // Par exemple, ajoutez une condition WHERE pour filtrer la recherche
//             $queryBuilder->andWhere('...'); // Votre condition ici
//         }
//     }

//     public function getDescription(string $resourceClass): array
//     {
//         // Vous pouvez également fournir une description pour la documentation
//         return [
//             'search' => [
//                 'property' => 'search',
//                 'type' => 'string',
//                 'required' => false,
//                 'description' => 'Filter by search query.',
//             ],
//         ];
//     }
// }
