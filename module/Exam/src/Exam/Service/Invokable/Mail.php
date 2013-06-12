<?php
namespace Exam\Service\Invokable;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class Mail implements ServiceLocatorAwareInterface
{
    /**
     *
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $services;

    /**
     * Sends award certificate
     *
     * @param \User\Model\Entity\User $user
     * @param array $exam
     * @param \ZendPdf\Document $pdf
     */
    public function sendCertificate($user, $exam, $pdf)
    {
        $translator = $this->services->get('translator');
        $mail = new Message();
        $mail->addTo($user->getEmail(), $user->getName());

$text = 'You are genius!
You answered all the questions correctly.
Therefore we are sending you as a gratitude this free award certificate.

';
        // we create a new mime message
        $mimeMessage = new MimeMessage();
        // create the original body as part
        $textPart = new MimePart($text);
        $textPart->type = "text/plain";
        // add the pdf document as a second part
        $pdfPart = new MimePart($pdf->render());
        $pdfPart->type = 'application/pdf';
        $mimeMessage->setParts(array($textPart, $pdfPart));

        $mail->setBody($mimeMessage);

        $mail->setFrom('slavey@zend.com', 'Slavey Karadzhov');
        $mail->setSubject($translator->translate('Congratulations: Here is your award certificate'));

        $transport = $this->services->get('mail-transport');
        $transport->send($mail);
    }

    /* (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
    */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->services = $serviceLocator;
    }

    /* (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
    */
    public function getServiceLocator()
    {
        return $this->services;
    }
}
