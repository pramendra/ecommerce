<?php

namespace BiologischeKaas\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use BiologischeKaas\EcommerceBundle\Entity\Paymethod;

class MultiSafepayCommand extends ContainerAwareCommand {

    private $input;
    private $output;
    private $em;
    private $msp;

    protected function configure() {
        $this->setName('addictedtovintage:multisafepay')->setDescription('Check order status');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $this->input = $input;
        $this->output = $output;

        $this->em = $this->getContainer()->get('doctrine')->getEntityManager();


        
        /*
        // checking gateways 
        $this->output->writeln('');
        $this->output->writeln('---------------------------------------------------');
        $this->output->writeln('Fetching gateways');
        $this->output->writeln('---------------------------------------------------');
        $this->output->writeln('');

        foreach ($this->msp->getGateways() as $msp_gateway) {

            $paymethod_lookup = $this->getDoctrine()->getRepository('EcommerceBundle:Paymethod')->findOneBy(array('name' => $msp_gateway['id']));

            if ($paymethod_lookup == null) {

                $paymethod = new Paymethod();

                $paymethod->setName($msp_gateway['id']);
                $paymethod->setDescription($msp_gateway['description']);

                $this->output->writeln('- ' . $msp_gateway['description'] . ' toegevoegd');

                $this->em->persist($paymethod);
                $this->em->flush();
            } else {
                $this->output->writeln('- ' . $msp_gateway['description'] . ' bestaat al');
            }
        }
        */
        
        // checking orders 
        $this->output->writeln('');
        $this->output->writeln('---------------------------------------------------');
        $this->output->writeln('Checking orders');
        $this->output->writeln('---------------------------------------------------');
        $this->output->writeln('');
	
	$paymethod = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->find(14);
        $orders = $this->getDoctrine()->getRepository('EcommerceBundle:Orders')->findBy(array('payed' => 0, 'paymethod' => $paymethod));

        foreach ($orders as $order) {
            
            $this->msp = new \BiologischeKaas\EcommerceBundle\MultiSafePay\MultiSafePay();

            /*
            * Merchant Settings
	if($this->get('kernel')->getEnvironment() == 'dev') { 
            $this->msp->merchant['account_id'] = '90085841';
            $this->msp->merchant['site_id'] = '6337';
            $this->msp->merchant['site_code'] = '953492';
            $this->msp->test = true;
        } else { */ 
            $this->msp->merchant['account_id'] = '10099492';
            $this->msp->merchant['site_id'] = '9314';
            $this->msp->merchant['site_code'] = '314849';            
            $this->msp->test = false;            
        //}

            // set id
            $this->msp->transaction['id'] = $order->getOrderNr();

            // returns the status
            $status = $this->msp->getStatus();
            
            $this->output->writeln('ORDER: ' . $order->getOrderNr());
            
	    switch ($status) {
		case "completed":   // payment complete
		    $order->setPayed(1);
		    $order->setStatus('Betaald');
		    break;
		case "initialized": // waiting
		    $order->setStatus('Wachten op betaling [AMSP]');
		    break;
		case "uncleared":   // waiting (credit cards or direct debit)
		    $order->setStatus('Wachten op betaling (cc of dd)');
		    break;
		case "void":        // canceled
		    $order->setStatus('Betaling geannuleerd');
		    break;
		case "declined":    // declined
		    $order->setStatus('Betaling afgewezen');
		    break;
		case "refunded":    // refunded
		    $order->setStatus('Betaling terug gestort');
		    break;
		case "expired":     // expired
		    $order->setStatus('Betaling verlopen');
		    break;
		default:
		    $order->setStatus('Wachten op betaling');
		    break;
	    }
            
            
            //if ($this->msp->error) { // only show error if we dont need to display the link
            //    $order->setStatus($this->msp->error);
            //}
            
            
            $this->output->writeln('STATUS: ' . $order->getStatus());
            $this->output->writeln('---------------------------------------------------');
            
            $this->em->flush();
            
            unset($status);
            unset($order);
        }
        
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    private function getDoctrine() {
        if (!$this->getContainer()->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not installed in your application.');
        }

        return $this->getContainer()->get('doctrine');
    }

}

