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
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;

class TokenRepositoryTest extends KernelTestCase
{
    private $em;
    private $user;
    private $application;

    protected function setUp():void
    {
        $kernel = static::createKernel();
        $this->application = new Application($kernel);
        $this->application->setAutoExit(false);
        $this->runCommand('doctrine:database:drop --force');
        $this->runCommand('doctrine:database:create');
        $this->runCommand('doctrine:schema:create');
//        $this->runCommand('doctrine:fixtures:load --append --no-interaction');
        
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()->get('doctrine')->getManager();
        $this->user = new User('test@gmail.com', 'test', []);

        $this->em->persist($this->user);
        $this->em->flush();
    }


    protected function runCommand($command)
    {
//        $command = sprintf('%s ', $command);
        return $this->application->run(new StringInput($command));
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
        $this->runCommand('doctrine:database:drop --force');
    }

}