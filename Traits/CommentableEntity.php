<?php

namespace Dywee\CoreBundle\Traits;

use Doctrine\ORM\Mapping as ORM;


trait CommentableEntity
{
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $comment;

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return CommentableEntity
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }


}
