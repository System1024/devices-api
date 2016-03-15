<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeviceBrowser
 *
 * @ORM\Table(name="device_browser", indexes={@ORM\Index(name="FK_device_browser_1", columns={"device_id"}), @ORM\Index(name="FK_device_browser_2", columns={"browserversion_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DeviceBrowserRepository")
 */
class DeviceBrowser
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
     * @var \Device
     *
     * @ORM\ManyToOne(targetEntity="Device")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="device_id", referencedColumnName="id")
     * })
     */
    private $device;

    /**
     * @var \Browserversion
     *
     * @ORM\ManyToOne(targetEntity="Browserversion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="browserversion_id", referencedColumnName="id")
     * })
     */
    private $browserversion;



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
     * Set device
     *
     * @param \AppBundle\Entity\Device $device
     *
     * @return DeviceBrowser
     */
    public function setDevice(\AppBundle\Entity\Device $device = null)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Get device
     *
     * @return \AppBundle\Entity\Device
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Set browserversion
     *
     * @param \AppBundle\Entity\Browserversion $browserversion
     *
     * @return DeviceBrowser
     */
    public function setBrowserversion(\AppBundle\Entity\Browserversion $browserversion = null)
    {
        $this->browserversion = $browserversion;

        return $this;
    }

    /**
     * Get browserversion
     *
     * @return \AppBundle\Entity\Browserversion
     */
    public function getBrowserversion()
    {
        return $this->browserversion;
    }
}
