<?php

namespace App\Tests\Fixtures\Factories;

use App\Entity\Log;
use App\Repository\LogRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Log>
 *
 * @method        Log|Proxy create(array|callable $attributes = [])
 * @method static Log|Proxy createOne(array $attributes = [])
 * @method static Log|Proxy find(object|array|mixed $criteria)
 * @method static Log|Proxy findOrCreate(array $attributes)
 * @method static Log|Proxy first(string $sortedField = 'id')
 * @method static Log|Proxy last(string $sortedField = 'id')
 * @method static Log|Proxy random(array $attributes = [])
 * @method static Log|Proxy randomOrCreate(array $attributes = [])
 * @method static LogRepository|RepositoryProxy repository()
 * @method static Log[]|Proxy[] all()
 * @method static Log[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Log[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Log[]|Proxy[] findBy(array $attributes)
 * @method static Log[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Log[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class LogFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'ipAddress' => self::faker()->text(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Log $log): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Log::class;
    }
}
