<?php

namespace AddictedToVintage\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use BiologischeKaas\EcommerceBundle\Entity\Product;

class GoogleCommand extends ContainerAwareCommand {

    private $input;
    private $output;
    private $em;
    private $created_files = array();

    protected function configure() {
	$this
		->setName('addictedtovintage:google:products')
		->setDescription('Generate Products for Google ');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

	$this->input = $input;
	$this->output = $output;

	$this->em = $this->getContainer()->get('doctrine')->getEntityManager();

	$products = $this->getContainer()->get('doctrine')->getRepository('EcommerceBundle:Product')->findAll();


	/*
	 * Create general sitemap file
	 */

	$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
	$xml .= '<rss version ="2.0" xmlns:g="http://base.google.com/ns/1.0">';
	$xml .= '<channel>';
	$xml .= '    <title>The name of your data feed.</title>';
	$xml .= '    <description>A description of your content.</description>';
	$xml .= '    <link>http://www.example.com</link>';

	foreach ($products as $product) {
	    $xml .= $this->addOne($product);

	    $this->output->writeln('Adding ' . $product->getName());
	}

	$xml .= '</channel></rss>';

	$this->output->writeln('<comment>Writing file...</comment>');

	$file = __DIR__ . '/../../../../web/google_products.xml';

	file_put_contents($file, $xml);

	$this->output->writeln('<info>google_products.xml created</info>');
    }

    private function addOne(Product $product) {

	if ($product->getDeletedAt() == null && count($product->getImages()) > 1 && $product->getStock() > 0 && count($product->getSubcategories()) > 0) {

	    $subcategories = $product->getSubcategories();
	    $categories = $subcategories[0]->getCategories();

	    if (count($categories) > 0) {

		if ($product->getFirstImage() !== null) {
		    $image = $product->getFirstImage()->getPath();
		} else {
		    $images = $product->getImages();
		    $image = $images[0]->getPath();
		}

		$xml = '<item>';
		$xml .= '<title><![CDATA[' . $product->getName() . ']]></title>';
		$xml .= '<g:brand>Addictedtovintage</g:brand>';
		$xml .= '<g:condition>new</g:condition>';
		$xml .= '<description><![CDATA[' . $product->getDescription() . ']]></description>';
		$xml .= '<g:id>' . $product->getId() . '</g:id>';
		$xml .= '<g:image_link>http://www.addictedtovintage.nl' . $image . '</g:image_link>';
		$xml .= '<link>http://www.addictedtovintage.nl/' . $product->getPermalink() . '</link>';
		$xml .= '<g:price>' . $product->getPrice() . '</g:price>';
		$xml .= '<g:product_type><![CDATA[' . $categories[0]->getName() . ' &gt; ' . $subcategories[0]->getName() . ']]></g:product_type>';
		$xml .= '<g:quantity>' . $product->getStock() . '</g:quantity>';

		$xml .= '<g:shipping>
		   <g:country>NL</g:country>	
		   <g:service>PostNL</g:service>
		   <g:price>5.95</g:price>
		</g:shipping>';
//	
//	$xml .=	'<g:tax>
//		   <g:country>NL</g:country>
//		   <g:rate>8.25</g:rate>
//		   <g:tax_ship>y</g:tax_ship>
//		</g:tax>';

		$xml .= '<g:upc>0001230001232</g:upc>';
		$xml .= '<g:weight>0.1 lb</g:weight>';
		$xml .= '</item>';

		return $xml;
	    }
	}
    }

}