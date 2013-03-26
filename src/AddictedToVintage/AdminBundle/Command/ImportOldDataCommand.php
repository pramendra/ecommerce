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
use AddictedToVintage\EcommerceBundle\Entity\ProductCategory;
use AddictedToVintage\EcommerceBundle\Entity\ProductAttributes;

class ImportOldDataCommand extends ContainerAwareCommand {

    private $input;
    private $output;
    private $em;

    protected function configure() {
        $this->setName('addictedtovintage:import')->setDescription('Import old database');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $this->input = $input;
        $this->output = $output;
        $this->em = $this->getContainer()->get('doctrine')->getEntityManager();

        $output->writeln('<comment>Fetching old products... </comment> ');
        
        mysql_connect('localhost', 'root', 'blmx3mpzat29');
        mysql_select_db('vintage-shop');
        
        
        $sql = "SELECT * FROM `product_group`";
        $res = mysql_query($sql) or die(mysql_error());
        
        $i = 1;
        $count = mysql_num_rows($res);
        
        while($r = mysql_fetch_object($res)) { 
                        
            $subcategory = $this->getSubcategoryByGroupId($r->group);
            
            $product = $this->getProduct($r->product);
            
                if($subcategory != null)  {

                    $output->writeln('<info>Product '. $r->product .': ' . $product->getName() . ' (rij ' . $i. ' van '.$count.')</info>');

                    $output->writeln('Adding subcategory: ' . $subcategory->getName() . '');

                    $productCategory = new ProductCategory();

                    $productCategory->setProduct($product);
                    $productCategory->setSubcategory($subcategory);

                    $this->em->persist($productCategory);
                    $this->em->flush();

                }
            
            $i++;
        }
        
    }
    
    private function getProduct($id) { 
        
        $sql = "SELECT * FROM `product` WHERE `id` = '".$id."' LIMIT 1";
        $res = mysql_query($sql) or die(mysql_error());
        
        $old_product = mysql_fetch_object($res);
        
        $product = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->findOneBy(array('name' => $old_product->product_name));
        
        if($product == null) { 
            
            $this->output->writeln('<info>Nieuw product: ' . $old_product->product_name . '</info>');
            
            $product = new Product();
            
            $product->setName($old_product->product_name);
            $product->setDescription($old_product->product_description);
            $product->setSKU($old_product->product_sku);
            $product->setKeywords($old_product->product_keywords);
            $product->setPrice($old_product->product_sale_price);
            $product->setSalePrice($old_product->product_price);
            $product->setCreatedAt(new \DateTime($old_product->product_added));
            $product->setPermalink($old_product->product_permalink);
            $product->setStock($old_product->product_stock);
            $product->setViews($old_product->product_views);
            $product->setIsNew($old_product->product_new);
            $product->setIsSale($old_product->product_sale);
            $product->setActive($old_product->product_active);
            $product->setWeight($old_product->product_weight);

            $product->setUpdatedAt(new \DateTime());
            
            $this->em->persist($product);
            $this->em->flush();
            
            
            /* 
             * IMAGES
             */
            
            $image_sql = "SELECT * FROM product_images WHERE image_product = '".$old_product->id."'";
            $image_result = mysql_query($image_sql) or die(mysql_error());
            
            while($image = mysql_fetch_object($image_result)) { 
                
                $this->output->writeln('    Adding image: ' . $image->image_path . '');
                
                $ProductImages = new ProductImages();
                $ProductImages->setCreatedAt(new \DateTime());
                $ProductImages->setPath(ltrim($image->image_path, '.'));
                $ProductImages->setProduct($product);
                $ProductImages->setThumbPath('');
                $ProductImages->setFileSize(0);
                $ProductImages->setName($product->getName());
                
                $this->em->persist($ProductImages);
                $this->em->flush();
                
            }
            
            /* 
             * Attributes
             */
            
            $attr_sql = "SELECT * FROM product_attributes WHERE product = '".$old_product->id."'";
            $attr_result = mysql_query($attr_sql) or die(mysql_error());
            
            while($old_attribute = mysql_fetch_object($attr_result)) { 
                
                $this->output->writeln('    Adding attribute ' . $this->getAtrributeValue($old_attribute->attribute). ' : ' . $old_attribute->attribute_value);
                
                $attribute = $this->getDoctrine()->getRepository('EcommerceBundle:Attribute')->find($old_attribute->attribute);
                
                $ProductAttributes = new ProductAttributes();
                $ProductAttributes->setAttribute($attribute);
                $ProductAttributes->setAttributeValue($old_attribute->attribute_value);
                $ProductAttributes->setProduct($product);
                $ProductAttributes->setIsSelectable(false);
                
                $this->em->persist($ProductAttributes);
                $this->em->flush();
                
            }
        
            return $product;
            
        } else { 
            
            //$this->output->writeln('<info>Skipped product: ' . $old_product->product_name . '</info>');
            
            return $product;
            
        }
            
        
    }
    
    private function getGroup($id) { 
        
        $sql = "SELECT * FROM `group` WHERE `id` = '".$id."' LIMIT 1";
        $res = mysql_query($sql) or die(mysql_error());
        
        return mysql_fetch_object($res);
    }

    
    private function getSubcategoryByGroupId($group_id) { 
        $mapping = array(
            
                '1' => '0',
                '2' => '0',
                '3' => '0',
                '4' => '0',
                '5' => '0',
                '6' => '0',
                '7' => '0',
                '7' => '10',
                '8' => '11',
                '9' => '11',
                '10' => '11',
                '11' => '8',
                '12' => '9',
                '13' => '13',
                '14' => '7',
                '15' => '26',
                '16' => '5',
                '17' => '0',
                '18' => '20',
                '19' => '16',
                '20' => '17',
                '21' => '0',
                '22' => '18',
                '23' => '22',
                '24' => '19',
                '25' => '15',
                '26' => '14',
                '27' => '21',
                '28' => '0',
                '29' => '0',
                '30' => '0',
                '31' => '3',
                '32' => '2',
                '32' => '2',
                '33' => '12',
                '34' => '0',
                '35' => '0'
            );
        
        if($mapping[$group_id] == 0) { 
            return null;
        } else { 
            return $this->getDoctrine()->getRepository('EcommerceBundle:Subcategory')->find($mapping[$group_id]);
        }
        
    }
    
    private function getAtrributeValue($index) { 
        
        $values = array(
        '1' => 	'Materiaal',
	'2' => 	'Conditie',
	'3' => 	'Formaat',
	'4' => 	'Keur',
	'5' => 	'Schoenmaat',
	'6' => 	'Lengte'
        );
                
        return $values[$index];
        
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