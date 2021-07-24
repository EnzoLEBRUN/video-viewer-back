<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Timestampable;
use MediaEmbed\MediaEmbed;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class History
 * @package App\Entity
 *
 * @ORM\Entity
 * @ApiResource(
 *     attributes={
 *          "order"={
 *              "createdAt": "DESC"
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"api_history_get"}}
 *          }
 *     },
 *     collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"api_history_list"}}
 *          },
 *          "post"={
 *              "denormalization_context"={"groups"={"api_history_post"}},
 *              "normalization_context"={"groups"={"api_history_list"}},
 *              "validation_groups"={"api_history_post"}
 *          }
 *     }
 * )
 */
class History implements Timestampable
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
     *      "api_history_get", "api_history_post", "api_history_list"
     * })
     * @Assert\NotBlank(groups={"api_history_post"})
     * @Assert\Url(groups={"api_history_post"})
     */
    protected $url;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @var \DateTimeInterface
     * @Groups({
     *      "api_history_get", "api_history_list"
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
     * @return History
     */
    public function setId(int $id): History
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
     * @return History
     */
    public function setUrl(string $url): History
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
     * @return History
     */
    public function setCreatedAt(\DateTime $createdAt): History
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @Groups({
     *      "api_history_get", "api_history_post", "api_history_list"
     * })
     * @SerializedName("video_url")
     * @return string
     */
    public function getVideoURL() {
        $mediaEmbed = new MediaEmbed();
        return $mediaEmbed->parseUrl($this->getUrl())->getEmbedSrc();
    }

}