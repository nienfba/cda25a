<?php


namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Trait for sluggable objects entity
 *
 */
trait SlugableEntity
{
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var SluggerInterface
     */
    private SluggerInterface $slugger;


    /**
     * Compute slug with use of method getSlugField()
     */
    public function computeSlug()
    {
        $this->slugger = new AsciiSlugger();
      
        if (!$this->slug || '-' === $this->slug) {
            $this->slug = (string) $this->slugger->slug($this->getSlugField())->lower();
        }
    }

    #[ORM\PrePersist]
    public function slugPersist()
    {
        $this->computeSlug();
    }

    #[ORM\PreUpdate]
    public function slugUpdate()
    {
        $this->computeSlug();
    }


    public function getSlug(): ?string
    {
        return $this->slug;
    }
}
