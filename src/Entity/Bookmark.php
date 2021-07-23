<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Timestampable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Bookmark
 * @package App\Entity
 *
 * @ORM\Entity
 * @UniqueEntity(fields={"url"})
 * @ApiResource(
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"api_bookmark_get"}}
 *          }
 *     },
 *     collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"api_bookmark_list"}}
 *          },
 *          "post"={
 *              "denormalization_context"={"groups"={"api_bookmark_post"}},
 *              "normalization_context"={"groups"={"api_bookmark_list"}},
 *              "validation_groups"={"api_bookmark_post"}
 *          }
 *     }
 * )
 */
class Bookmark implements Timestampable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     * @Groups({
     *      "api_bookmark_get", "api_bookmark_post", "api_bookmark_list"
     * })
     * @Assert\NotBlank(groups={"api_bookmark_post"})
     * @Assert\Url(groups={"api_bookmark_post"})
     */
    protected $url;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @var \DateTimeInterface
     * @Groups({
     *      "api_bookmark_get", "api_bookmark_list"
     * })
     */
    protected $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Bookmark
     */
    public function setId(int $id): Bookmark
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Bookmark
     */
    public function setUrl(string $url): Bookmark
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Bookmark
     */
    public function setCreatedAt(\DateTime $createdAt): Bookmark
    {
        $this->createdAt = $createdAt;
        return $this;
    }

}