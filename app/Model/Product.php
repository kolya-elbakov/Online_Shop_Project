<?php

namespace Model;


use Core\Model\Model;

class Product extends Model
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

    private string $model;

    public function getModel(): string
    {
        return $this->model;
    }

    private int $price;

    public function getPrice(): int
    {
        return $this->price;
    }

    private string $link;

    public function getLink(): string
    {
        return $this->link;
    }

    public function __construct(int $id, string $name, string $model, int $price, string $link)
    {
        $this->id = $id;
        $this->name = $name;
        $this->model = $model;
        $this->price = $price;
        $this->link = $link;
    }

    public static function getAll(): array
    {
        $statement = static::getPdo()->query("SELECT * FROM products");
        $products = $statement->fetchAll();

        $result = [];
        foreach ($products as $product) {
            $result[] = self::hydrate($product);
        }
        return $result;
    }

    public static function getOneById(int $id): Product|null
    {
        $statement = self::getPdo()->prepare("SELECT * FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $productInfo = $statement->fetch();

        if (empty($productInfo)) {
            return null;
        }

        return self::hydrate($productInfo);
    }

    private static function hydrate($data): Product
    {
        return new self($data['id'], $data['name'], $data['model'], $data['price'], $data['link']);
    }
}