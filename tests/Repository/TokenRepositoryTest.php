<?php
/**
 * Created by IntelliJ IDEA.
 * User: santa
 * Date: 22.07.19
 * Time: 11:55
 */

namespace Tests\App\Repository;

use App\Entity\Token;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TokenRepositoryTest extends KernelTestCase
{
    private $em;
    private $user;

    protected function setUp():void
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()->get('doctrine')->getManager();

        $this->user = new User('test@gmail.com', 'test', []);

        $this->em->persist($this->user);
        $this->em->flush();
    }

    public function testCreateNewFor()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['id' => $this->user->getId()]);
        $token =  $this->em->getRepository(Token::class)->createNewFor($user);
        $this->assertInstanceOf(Token::class, $token);
    }

    protected function tearDown():void
    {
        parent::tearDown();

        $user = $this->em->merge($this->user);
        $this->em->remove($user);

        $this->em->flush();

        $this->em->close();
        $this->em= null;
    }

}