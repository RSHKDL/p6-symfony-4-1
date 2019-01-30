<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_videos")
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(type="string", length=255, name="video_id")
     */
    private $videoId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;

    /**
     * @ORM\Column(type="string", length=255, name="raw_url")
     * @var string
     */
    private $rawUrl;

    /**
     * Video constructor.
     * @param string $rawUrl
     */
    public function __construct(string $rawUrl)
    {
        $this->rawUrl = $rawUrl;
    }

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

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;
        return $this;
    }

    public function unsetTrick()
    {
        $this->trick = null;
    }

    /**
     * @return string|null
     */
    public function getRawUrl(): ?string
    {
        return $this->rawUrl;
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
     * Use explode to cut the url in half at the "=" sign
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
        $url = $this->getRawUrl();

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

    /**
     * @return string
     */
    private function generateUrlForIframe(): string
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

    /**
     * @return string
     */
    public function generateVideo(): string
    {
        $video = "<iframe width='100%' 
                          height='100%' 
                          src='".$this->generateUrlForIframe()."' 
                          frameborder='0' 
                          allowfullscreen></iframe>";
        return $video;
    }
}
