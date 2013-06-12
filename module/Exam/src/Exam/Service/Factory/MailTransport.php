<?php
namespace Exam\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mail\Transport\File as FileTransport;
use Zend\Mail\Transport\FileOptions;

class MailTransport implements FactoryInterface
{
    /* (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $transport = new FileTransport();
        $options   = new FileOptions(array(
                'path'              => 'data/mail/',
                'callback'  => function (FileTransport $transport) {
                    return 'Message_' . microtime(true) . '_' . mt_rand() . '.txt';
                },
        ));
        $transport->setOptions($options);

        return $transport;
    }
}
