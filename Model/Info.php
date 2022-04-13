<?php
/**
 * MageVision Mass Email Customers Extension
 *
 * @category     MageVision
 * @package      MageVision_MassEmailCustomers
 *
 * @author       MageVision Team
 * @copyright    Copyright (c) 2022 MageVision (http://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
declare(strict_types=1);

namespace MageVision\MassEmailCustomers\Model;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\Serialize\Serializer\Json;

class Info
{
    const MODULE_NAME = 'Mass Email Customers';

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var Json
     */
    protected $serializer;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @param DriverInterface $driver
     * @param Json $serializer
     * @param Reader $reader
     */
    public function __construct(
        DriverInterface $driver,
        Json $serializer,
        Reader $reader
    ) {
        $this->driver = $driver;
        $this->serializer = $serializer;
        $this->reader = $reader;
    }

    /**
     * Returns extension version
     *
     * @throws FileSystemException
     *
     * @return null|string
     */
    public function getExtensionVersion(): ?string
    {
        $file = $this->reader->getModuleDir('', 'MageVision_MassEmailCustomers') . '/composer.json';

        if ($this->driver->isExists($file)) {
            $content = $this->driver->fileGetContents($file);

            if ($content) {
                $jsonContent = $this->serializer->unserialize($content);

                if (!empty($jsonContent['version'])) {
                    return $jsonContent['version'];
                }
            }
        }

        return null;
    }

    /**
     * Returns extension name
     *
     * @return string
     */
    public function getExtensionName(): string
    {
        return self::MODULE_NAME;
    }
}
