<?php

#O comando 'composer dumpautoload' recarrega a lista 
#de classes, pacotes e bibliotecas que estão dentro 
#do seu projeto no arquivo de autoload

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$student = new Student(
    null,
    'Vinicius Dias',
    new \DateTimeImmutable('1988-09-22')
);

echo $student->age();
