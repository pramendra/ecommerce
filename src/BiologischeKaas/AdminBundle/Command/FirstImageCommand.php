<?php

namespace BiologischeKaas\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use BiologischeKaas\EcommerceBundle\Entity\Product;
use BiologischeKaas\EcommerceBundle\Entity\ProductImages;
use BiologischeKaas\AdminBundle\UploadHandler\UploadHandler;
use BiologischeKaas\EcommerceBundle\Entity\ProductCategory;
use BiologischeKaas\EcommerceBundle\Entity\ProductAttributes;

class FirstImageCommand extends ContainerAwareCommand {

    private $input;
    private $output;
    private $em;

    protected function configure() {
        $this->setName('addictedtovintage:firstimage')->setDescription('Import old database');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $this->input = $input;
        $this->output = $output;
        $this->em = $this->getContainer()->get('doctrine')->getEntityManager();

        $output->writeln('<comment>Fetching products... </comment> ');
       
        $products = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->findAll();
        
        foreach($products as $product) { 
            
            if($product->getFirstImage() == null) {
            
                $images = $product->getImages();
                
                $product->setFirstImage($images[0]);
                
                $output->writeln('<info>Adding firstimage for ' . $product->getName(). '... </info> ');
                
                $this->em->flush();
            } else { 
                $output->writeln('<info>Skipped ' . $product->getName(). '... </info> ');
            }
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