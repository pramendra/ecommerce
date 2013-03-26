<?php

namespace AddictedToVintage\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AddictedToVintage\EcommerceBundle\Entity\Product;
use AddictedToVintage\EcommerceBundle\Entity\ProductImages;
use AddictedToVintage\AdminBundle\UploadHandler\UploadHandler;

class AttributesCommand extends ContainerAwareCommand {

    private $input;
    private $output;
    private $em;

    protected function configure() {
        $this->setName('addictedtovintage:attributes')->setDescription('seporate attributes');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $this->input = $input;
        $this->output = $output;
        $this->em = $this->getContainer()->get('doctrine')->getEntityManager();

        $output->writeln('<comment>Fetching products...</comment> ');

        $products = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->findAll();
        
        $i = 1;        
        $total_products = count($products);
        
        foreach($products as $product) { 
            
            $output->writeln('<comment>Product: ' . $product->getName() . ' (' . $i .' van '.$total_products.')</comment>');
            
            $output->writeln('  Found: ' . count($product->getAttributes()) . ' attributes');
            
            foreach($product->getAttributes() as $product_attribute) { 
                
                if($product_attribute->getAttribute()->getId() != 2) { // Conditie
                    
                    $value = $product_attribute->getAttributeValue();
                    
                    if(strpos($value, '/')) { 
                        
                        $fetched_product = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->find($product->getId());
                        $attribute = $this->getDoctrine()->getRepository('EcommerceBundle:Attribute')->find($product_attribute->getAttribute()->getId());
                        
                        $value = str_replace(' ', '', $value);
                        
                        $values = explode('/', $value); 
                        
                        if(!empty($values[0])) { 
                            
                            $pattr = new \AddictedToVintage\EcommerceBundle\Entity\ProductAttributes();
                            $pattr->setAttribute($attribute);
                            $pattr->setAttributeValue($values[0]);
                            $pattr->setIsSelectable(true);
                            $pattr->setProduct($fetched_product);
                            
                            $this->em->persist($pattr);
                            $this->em->flush();
                        }
                        
                        if(!empty($values[1])) { 
                            
                            $pattr = new \AddictedToVintage\EcommerceBundle\Entity\ProductAttributes();
                            $pattr->setAttribute($attribute);
                            $pattr->setAttributeValue($values[1]);
                            $pattr->setIsSelectable(true);
                            $pattr->setProduct($fetched_product);
                            
                            $this->em->persist($pattr);
                            $this->em->flush();
                        }
                        
                        if(!empty($values[2])) { 
                            
                            $pattr = new \AddictedToVintage\EcommerceBundle\Entity\ProductAttributes();
                            $pattr->setAttribute($attribute);
                            $pattr->setAttributeValue($values[2]);
                            $pattr->setIsSelectable(true);
                            $pattr->setProduct($fetched_product);
                            
                            $this->em->persist($pattr);
                            $this->em->flush();
                        }
                        
                        if(!empty($values[3])) { 
                            
                            $pattr = new \AddictedToVintage\EcommerceBundle\Entity\ProductAttributes();
                            $pattr->setAttribute($attribute);
                            $pattr->setAttributeValue($values[3]);
                            $pattr->setIsSelectable(true);
                            $pattr->setProduct($fetched_product);
                            
                            $this->em->persist($pattr);
                            $this->em->flush();
                        }
                        
                        $output->writeln('  -: ' . $product_attribute->getAttributeValue() . ' ');
                        
                        
                        $product_attribute->setAttributeValue('DELETE');
                        
                        $this->em->flush();
                        $this->em->clear();
                    }
                }
                
                unset($fetched_product);
                unset($product_attribute);
                unset($attribute);
                
                $this->em->clear();
            }
            
            $i++;
            
        }
        
    }
    
    private function seporateAttributes($attr_name) {
              
        
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