<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Article;
use App\Tests\Fixtures\Factories\ArticleFactory;
use App\Tests\Fixtures\Factories\UserFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use function Zenstruck\Foundry\lazy;

class ArticleTest extends ApiTestCase
{
    // This trait provided by Foundry will take care of refreshing the database content to a known state before each test
    use ResetDatabase, Factories;

    public function testGetCollection(): void
    {
        // Create 100 articles using our factory
        ArticleFactory::createMany(10);
    
        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response = static::createClient()->request('GET', '/api/articles');

        $this->assertResponseIsSuccessful();

        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            '@context' => '/api/contexts/Article',
            '@id' => '/api/articles',
            "@type" => "hydra:Collection",
            "hydra:totalItems" => 10,
            'hydra:member' => []
        ]);

        // Because test fixtures are automatically loaded between each test, you can assert on them
        $this->assertCount(10, $response->toArray()['hydra:member']);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        // This generated JSON Schema is also used in the OpenAPI spec!
        $this->assertMatchesResourceCollectionJsonSchema(Article::class);


    }





    // public function testCreateArticle(): void
    // {

    //     // UserFactory::createMany(1);

    //     $response = static::createClient()->request('POST', '/articles', ['json' => [
    //         'chapo' => 'aaaaaaaaaaaaaaa',
    //         'content' => 'bbbbbbbbbbbbbbbbb',
    //         'title' => 'ccccccccccccccc',
    //         'author' => 'Margaret Atwood',
    //         'user' => lazy(fn() => UserFactory::randomOrCreate()),
    //     ]]);

    //     $this->assertResponseStatusCodeSame(201);
    //     // $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    //     // $this->assertJsonContains([
    //     //     '@context' => '/contexts/Book',
    //     //     '@type' => 'Book',
    //     //     'isbn' => '0099740915',
    //     //     'title' => 'The Handmaid\'s Tale',
    //     //     'description' => 'Brilliantly conceived and executed, this powerful evocation of twenty-first century America gives full rein to Margaret Atwood\'s devastating irony, wit and astute perception.',
    //     //     'author' => 'Margaret Atwood',
    //     //     'publicationDate' => '1985-07-31T00:00:00+00:00',
    //     //     'reviews' => [],
    //     // ]);
    //     // $this->assertMatchesRegularExpression('~^/books/\d+$~', $response->toArray()['@id']);
    //     // $this->assertMatchesResourceItemJsonSchema(Book::class);
    // }










//     public function testCreateInvalidBook(): void
//     {
//         static::createClient()->request('POST', '/books', ['json' => [
//             'isbn' => 'invalid',
//         ]]);

//         $this->assertResponseStatusCodeSame(422);
//         $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

//         $this->assertJsonContains([
//             '@context' => '/contexts/ConstraintViolationList',
//             '@type' => 'ConstraintViolationList',
//             'hydra:title' => 'An error occurred',
//             'hydra:description' => 'isbn: This value is neither a valid ISBN-10 nor a valid ISBN-13.
// title: This value should not be blank.
// description: This value should not be blank.
// author: This value should not be blank.
// publicationDate: This value should not be null.',
//         ]);
//     }

//     public function testUpdateBook(): void
//     {
//         // Only create the book we need with a given ISBN
//         BookFactory::createOne(['isbn' => '9781344037075']);
    
//         $client = static::createClient();
//         // findIriBy allows to retrieve the IRI of an item by searching for some of its properties.
//         $iri = $this->findIriBy(Book::class, ['isbn' => '9781344037075']);

//         // Use the PATCH method here to do a partial update
//         $client->request('PATCH', $iri, [
//             'json' => [
//                 'title' => 'updated title',
//             ],
//             'headers' => [
//                 'Content-Type' => 'application/merge-patch+json',
//             ]           
//         ]);

//         $this->assertResponseIsSuccessful();
//         $this->assertJsonContains([
//             '@id' => $iri,
//             'isbn' => '9781344037075',
//             'title' => 'updated title',
//         ]);
//     }

//     public function testDeleteBook(): void
//     {
//         // Only create the book we need with a given ISBN
//         BookFactory::createOne(['isbn' => '9781344037075']);

//         $client = static::createClient();
//         $iri = $this->findIriBy(Book::class, ['isbn' => '9781344037075']);

//         $client->request('DELETE', $iri);

//         $this->assertResponseStatusCodeSame(204);
//         $this->assertNull(
//             // Through the container, you can access all your services from the tests, including the ORM, the mailer, remote API clients...
//             static::getContainer()->get('doctrine')->getRepository(Book::class)->findOneBy(['isbn' => '9781344037075'])
//         );
//     }


}
