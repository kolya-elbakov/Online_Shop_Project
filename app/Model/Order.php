<?php

namespace Model;

class Order extends Model
{
    public static function createOrder(string $name, string $email, string $city, string $street, int $zip, string $payment): bool|string
    {
        $statement = static::getPdo()->prepare("INSERT INTO orders (name, email, city, street, zip, payment) VALUES (:name, :email, :city, :street, :zip, :payment)");
        $statement->execute(['name' => $name, 'email' => $email, 'city' => $city, 'street' => $street, 'zip' => $zip, 'payment' => $payment]);
        return static::getPdo()->lastInsertId();
    }
}