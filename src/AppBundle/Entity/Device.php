<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Device
 *
 * @ORM\Table(name="device", indexes={@ORM\Index(name="FK_device_1", columns={"devicetype_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DeviceRepository")
 */
class Device
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
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var \Devicetypes
     *
     * @ORM\ManyToOne(targetEntity="Devicetypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="devicetype_id", referencedColumnName="id")
     * })
     */
    private $devicetype;



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
     * Set name
     *
     * @param string $name
     *
     * @return Device
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Device
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set devicetype
     *
     * @param \AppBundle\Entity\Devicetypes $devicetype
     *
     * @return Device
     */
    public function setDevicetype(\AppBundle\Entity\Devicetypes $devicetype = null)
    {
        $this->devicetype = $devicetype;

        return $this;
    }

    /**
     * Get devicetype
     *
     * @return \AppBundle\Entity\Devicetypes
     */
    public function getDevicetype()
    {
        return $this->devicetype;
    }
}
