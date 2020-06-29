<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$connection->beginTransaction();

try{ 
$aStudent = new Student(null,
                        'Lilian mm', 
                        new DateTimeImmutable('1978-08-16'));

$studentRepository->save($aStudent);

$anotherStudent = new Student(null,
                              'Lilian Primo', 
                               new DateTimeImmutable('1922-08-16'));

$studentRepository->save($anotherStudent);

$connection->commit();

}catch(\RuntimeException $e){
    echo $e->getMessage();
    $connection->rollBack();
}