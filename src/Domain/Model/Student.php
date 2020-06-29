<?php

namespace Alura\Pdo\Domain\Model;

#Esta classe Student não é uma classe anêmica porque
#contém regras de negócio. Também é uma classe que está 
#usando o padrão Entity, isso porque ela possui um 
#identificador que neste caso é o atributo $id 
#que faz com que ela seja persistivel,
class Student
{
    #O sinal de interrogação significa que o
    #atributo pode receber um valor null
    private ?int $id;
    private string $name;
    private \DateTimeInterface $birthDate;
    #Annotation
    /** @var Phone[] */
    private array $phones = [];

    #Ao usarmos a classe como tipo de um atributo, estamos a fazer uso do padrão
    #injeção de dependçencia
    public function __construct(?int $id, string $name, \DateTimeInterface $birthDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    public function defineId(int $id): void
    {
        if (!is_null($this->id)){
            throw new \DomainException('Você só pode definir o ID uma vez.');
        }
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function changeName(string $newName): void
    {
        $this->name = $newName;
    }

    public function birthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function age(): int
    {
        return $this->birthDate
            ->diff(new \DateTimeImmutable())
            ->y;
    }

    public function addPhone(Phone $phone): void
    {
        $this->phone = $phone;
    }

    /** @return Phone[] */
    public function phones(): array
    {
        return $this->phone;
    }
}
