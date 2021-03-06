<?php
/**
 * Copyright 2016 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Amazon\Core\Controller\Adminhtml\Download;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Controller\Adminhtml\System;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Exception\NotFoundException;

/**
 * Class IpnLog
 * @package Amazon\Core\Controller\Adminhtml\Download
 */
class IpnLog extends System
{
    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * IpnLog constructor.
     * @param Context $context
     * @param FileFactory $fileFactory
     */
    public function __construct(
        Context $context,
        FileFactory $fileFactory
    )
    {
        $this->fileFactory = $fileFactory;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        $filePath = $this->getFilePath();

        $fileName = basename((string)$filePath);

        try {
            return $this->fileFactory->create(
                $fileName,
                [
                    'type' => 'filename',
                    'value' => $filePath
                ]
            );
        } catch (\Exception $e) {
            throw new NotFoundException(__($e->getMessage()));
        }
    }

    /**
     * @return string
     */
    private function getFilePath()
    {
        return \Amazon\Core\Logger\Handler\Ipn::FILENAME;
    }
}
