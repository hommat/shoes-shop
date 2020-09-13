<?php

namespace App\EntityListener;

use App\Entity\Shoes;
use Symfony\Component\String\Slugger\SluggerInterface;

class ShoesEntityListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Shoes $shoes)
    {
        $shoes->computeSlug($this->slugger);
    }

    public function preUpdate(Shoes $shoes)
    {
        $shoes->computeSlug($this->slugger);
    }
}
