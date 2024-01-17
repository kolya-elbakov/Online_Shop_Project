<?php

namespace Model;

class Order extends Model
{
    public function createOrder(string $name, string $email, string $city, string $street, int $zip, string $payment)
    {
        $statement = $this->pdo->prepare("INSERT INTO orders (name, email, city, street, zip, payment) VALUES (:name, :email, :city, :street, :zip, :payment)");
        return $statement->execute(['name' => $name, 'email' => $email, 'city' => $city, 'street' => $street, 'zip' => $zip, 'payment' => $payment]);
    }
}