<?php

namespace Model;

use Elbakov\MyCore\Model\Model;

class Order extends Model
{
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }
    private string $email;

    public function getEmail(): string
    {
        return $this->email;
    }
    private string $city;

    public function getCity(): string
    {
        return $this->city;
    }
    private string $street;

    public function getStreet(): string
    {
        return $this->street;
    }
    private int $zip;

    public function getZip(): int
    {
        return $this->zip;
    }
    private string $payment;

    public function getPayment(): string
    {
        return $this->payment;
    }

    public function __construct($name, $email, $city, $street, $zip, $payment)
    {
        $this->name = $name;
        $this->email = $email;
        $this->city = $city;
        $this->street = $street;
        $this->zip = $zip;
        $this->payment = $payment;
    }


    public static function createOrder(string $name, string $email, string $city, string $street, int $zip, string $payment): bool|string
    {
        $statement = static::getPdo()->prepare("INSERT INTO orders (name, email, city, street, zip, payment) VALUES (:name, :email, :city, :street, :zip, :payment)");
        $statement->execute(['name' => $name, 'email' => $email, 'city' => $city, 'street' => $street, 'zip' => $zip, 'payment' => $payment]);
        return static::getPdo()->lastInsertId();
    }

    public function save(): void
    {
        $statement = static::getPdo()->prepare("INSERT INTO orders (name, email, city, street, zip, payment) VALUES (:name, :email, :city, :street, :zip, :payment)");
        $statement->execute(['name' => $this->name, 'email' => $this->email, 'city' => $this->city, 'street' => $this->street, 'zip' => $this->zip, 'payment' => $this->payment]);
        $this->id = static::getPdo()->lastInsertId();
    }
}