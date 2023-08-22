<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $uuid = null;

    #[ORM\Column(length: 255)]
    private ?string $sku;



//    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductPromotion::class)]
//    private $productPromotions;
//
//    public function __construct()
//    {
//        $this->productPromotions = new ArrayCollection();
//    }


    public function __construct(
         int $price,
         string $uuid,
         string $sku,
    ){
        $this->price=$price;
        $this->uuid=$uuid;
        $this->sku=$sku;
    }

    public static function fromResult(array $result): self
    {
        return new self(
            (int)$result['price'],
            $result['uuid'],
            $result['code'],
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }




//    /**
//     * @return Collection<int, ProductPromotion>
//     */
//    public function getProductPromotions(): Collection
//    {
//        return $this->productPromotions;
//    }
//
//    public function addProductPromotion(ProductPromotion $productPromotion): static
//    {
//        if (!$this->productPromotions->contains($productPromotion)) {
//            $this->productPromotions->add($productPromotion);
//            $productPromotion->setProduct($this);
//        }
//
//        return $this;
//    }
//
//    public function removeProductPromotion(ProductPromotion $productPromotion): static
//    {
//        if ($this->productPromotions->removeElement($productPromotion)) {
//            // set the owning side to null (unless already changed)
//            if ($productPromotion->getProduct() === $this) {
//                $productPromotion->setProduct(null);
//            }
//        }
//
//        return $this;
//    }

public function getUuid(): ?string
{
    return $this->uuid;
}

public function setUuid(string $uuid): static
{
    $this->uuid = $uuid;

    return $this;
}

public function getSku(): ?string
{
    return $this->sku;
}

public function setSku(string $sku): static
{
    $this->sku = $sku;

    return $this;
}
}
