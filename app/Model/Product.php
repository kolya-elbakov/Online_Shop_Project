<?php

namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private string $model;
    private int $price;
    private string $link;

    public function __construct(int $id, string $name, string $model, int $price, string $link)
    {
        $this->id = $id;
        $this->name = $name;
        $this->model = $model;
        $this->price = $price;
        $this->link = $link;
    }
    public static function getAll(): Product|array
    {
        $statement = static::getPdo()->query("SELECT * FROM products");
        $products = $statement->fetchAll();

        $result = [];
        foreach ($products as $product){
            $result[] = new self($product['id'], $product['name'], $product['model'], $product['price'], $product['link']);
        }
        return $result;
    }

    public static function getProductName(int $id)
    {
        $statement = static::getPdo()->prepare("SELECT name FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $productName = $statement->fetchColumn();
        return $productName;
    }

    public static function getProductModel(int $id)
    {
        $statement = static::getPdo()->prepare("SELECT model FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $productModel = $statement->fetchColumn();
        return $productModel;
    }

    public static function getProductLink(int $id)
    {
        $statement = static::getPdo()->prepare("SELECT link FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $productLink = $statement->fetchColumn();
        return $productLink;
    }

    public static function getProductPrice(int $id)
    {
        $statement = static::getPdo()->prepare("SELECT price FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $productPrice = $statement->fetchColumn();
        return $productPrice;
    }
}