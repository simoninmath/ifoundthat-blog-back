<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Newsletter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NewsletterTest extends KernelTestCase
{


    public function getEntity(): Newsletter
    {
        return (new Newsletter())
        ->setEmail('aaa@aaa.aaa')
        ;
    }


    public function testInvalidEmail(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $newsletter = $this->getEntity();

        $newsletter->setEmail('aaa');

        $errors = $container->get('validator')->validate($newsletter);

        $this->assertCount(1, $errors);

    }
}
