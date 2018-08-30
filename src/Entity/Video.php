<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="app_videos")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $videoId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Figure", inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $figure;

    /**
     * @Assert\Regex(
     *     pattern="#^(http|https)://(www.youtube.com|www.dailymotion.com|vimeo.com)/#",
     *     match=true,
     *     message="The url must match a valid Youtube, DailyMotion or Vimeo video raw url"
     * )
     */
    private $url;

    public function getId()
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(string $videoId): self
    {
        $this->videoId = $videoId;
        return $this;
    }

    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    public function setFigure(?Figure $figure): self
    {
        $this->figure = $figure;
        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Youtube urls look like this : https://www.youtube.com/watch?v=u20epr7tSEU
     * Use explode to cut the url in half at the "=" sign
     * and keep the second part as id.
     * Then set the videoId and the type.
     *
     * @param $url
     */
    private function youtubeId($url)
    {
        $haystack = explode("=", $url);
        $needle = $haystack[1];

        $this->setVideoId($needle);
        $this->setType('youtube');
    }

    /**
     * Dailymotion urls look like this : https://www.dailymotion.com/video/x1nzpqv
     * ???
     * and keep the second part as id.
     * Then set the videoId and the type.
     *
     * @param $url
     */
    private function dailymotionId($url)
    {
        $haystack = explode("/video/", $url);
        $needle = $haystack[1];

        $this->setVideoId($needle);
        $this->setType('dailymotion');
    }

    /**
     * Vimeo urls look like this : https://vimeo.com/77477140
     * Use explode to cut the url in half at the "/" sign
     * and keep the second part as id.
     * Then set the videoId and the type.
     *
     * @param $url
     */
    private function vimeoId($url)
    {
        $haystack = explode("/", $url);
        $needle = $haystack[count($haystack)-1];

        $this->setVideoId($needle);
        $this->setType('vimeo');
    }

    /**
     * Get the current url and execute the corresponding function.
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @ORM\PreFlush()
     */
    public function extractVideoId()
    {
        $url = $this->getUrl();

        if (preg_match("#^(http|https)://www.youtube.com/#", $url))
        {
            $this->youtubeId($url);
        }
        else if((preg_match("#^(http|https)://www.dailymotion.com/#", $url)))
        {
            $this->dailymotionId($url);
        }
        else if((preg_match("#^(http|https)://vimeo.com/#", $url)))
        {
            $this->vimeoId($url);
        }

    }

    private function generateUrl(): string
    {
        $type = $this->getType();
        $videoId = strip_tags($this->getVideoId());

        if($type == 'youtube')
        {
            $embed = "https://www.youtube.com/embed/".$videoId;
            return $embed;
        }
        else if ($type == 'dailymotion')
        {
            $embed = "https://www.dailymotion.com/embed/video/".$videoId;
            return $embed;
        }
        else if($type == 'vimeo')
        {
            $embed = "https://player.vimeo.com/video/".$videoId;
            return $embed;
        }
    }

    public function generateVideo(): string
    {
        $video = "<iframe width='100%' 
                          height='100%' 
                          src='".$this->generateUrl()."' 
                          frameborder='0' 
                          allowfullscreen></iframe>";
        return $video;
    }
}
