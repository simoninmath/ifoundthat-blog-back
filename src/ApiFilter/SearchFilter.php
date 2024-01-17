<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;


final class SearchFilter extends AbstractFilter   // Custom search filter for API Platform
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        // Condition: check if the property is ready for filter
        if (
            !$this->isPropertyEnabled($property, $resourceClass) ||
            !$this->isPropertyMapped($property, $resourceClass)
        ) {
            return;
        }

        $parameterName = $queryNameGenerator->generateParameterName($property);  // Generate a parameter name for the query to avoid conflicts
        $queryBuilder  // Add a WHERE clause using REGEX for search (nota: REGEXP is a specific instruction for MySQL database. It is possible to use LIKE)
            ->andWhere(sprintf('REGEXP(o.%s, :%s) = 1', $property, $parameterName))  // sprintf() format the query with the column and property name
            ->setParameter($parameterName, $value);  // Bind value with variable $parameterName
    }

    // Get the filter description for OpenAPI documentation (optionnal)
    public function getDescription(string $resourceClass): array
    {
        
        if (!$this->properties) {  // If there are no properties, return an empty array
            return [];
        }

        $description = [];
        foreach ($this->properties as $property => $strategy) {
            // Generate description for each property
            $description["searchp_$property"] = [
                'property' => $property,
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
                'description' => 'Filter using a search. This will appear in the OpenApi documentation!',
                'openapi' => [
                    'example' => 'Custom example that will be in the documentation and be the default value of the sandbox',
                    'allowReserved' => false,
                    'allowEmptyValue' => true,
                    'explode' => false,
                ],
            ];
        }

        return $description;
    }
}