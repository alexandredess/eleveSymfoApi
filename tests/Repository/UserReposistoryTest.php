<?php
namespace App\tests\Repository;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase{

    public function testCount(){
        //récupération du repository
        //démarrage du kernel
       self::bootKernel();
       $user = self::$container->get(UserRepository::class)->count([]);
       $this->assertEquals(10,$user);
    }
}


?>