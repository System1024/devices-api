<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Browserversion
 *
 * @ORM\Table(name="browserversion", indexes={@ORM\Index(name="FK_browserversion_1", columns={"browser_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BrowserversionRepository")
 */
class Browserversion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=45, nullable=false)
     */
    private $version;

    /**
     * @var \Browser
     *
     * @ORM\ManyToOne(targetEntity="Browser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="browser_id", referencedColumnName="id")
     * })
     */
    private $browser;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set version
     *
     * @param string $version
     *
     * @return Browserversion
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set browser
     *
     * @param \AppBundle\Entity\Browser $browser
     *
     * @return Browserversion
     */
    public function setBrowser(\AppBundle\Entity\Browser $browser = null)
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * Get browser
     *
     * @return \AppBundle\Entity\Browser
     */
    public function getBrowser()
    {
        return $this->browser;
    }
}
