<?php

namespace AddictedToVintage\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SitemapCommand extends ContainerAwareCommand {

	private $input;
	private $output;
	private $em;
	
	private $created_files = array();

	protected function configure() {
		$this
				->setName('addictedtovintage:google:sitemap')
				->setDescription('Generate Sitemap for Google ');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {

		$this->input = $input;
		$this->output = $output;

		$this->em = $this->getContainer()->get('doctrine')->getEntityManager();
        
        $this->generateProducts();
        $this->generateCategories();
        
		/* 
		 * Create general sitemap file
		 */
		
		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		
		$xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

		foreach($this->created_files as $file) { 
				
			$this->output->writeln($file . ' aangemaakt');
			$xml .= '	<sitemap>';
			$xml .= '		<loc>http://www.addictedtovintage.nl/'.$file.'</loc>';
			$xml .= '	</sitemap>';
		} 

		$xml .= '</sitemapindex>';
		
		$this->output->writeln('<comment>Writing file...</comment>');

		$file = __DIR__ . '/../../../../web/google_sitemap.xml';

		file_put_contents($file, $xml);
		
		$this->output->writeln('<info>google_sitemap.xml created</info>');
	}

	private function generateProducts() {

		// Sibben brands 

		$this->output->writeln('<comment>Adding Products</comment>');

		$products = $this->getContainer()->get('doctrine')->getRepository('EcommerceBundle:Product')->findAll();

			$xml = '<?xml version="1.0" encoding="UTF-8"?>';
			$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

			foreach($products as $product) {
				
				if($product->getActive() == 1 && $product->getStock() > 0 && $product->getDeletedAt() == null) { 
                    
                    $permalink = $this->getProductPermalink($product);

                    if($permalink != null) { 
                    
                        $xml .= '<url>';
                        $xml .= '	<loc><![CDATA[http://www.addictedtovintage.nl/' . $permalink . ']]></loc>';
                        $xml .= '	<changefreq>daily</changefreq>';
                        $xml .= '</url>';

                        $this->output->writeln('Added: <info>' . $product->getName() . '</info>');

                    }

				}
			}

			$xml .= '</urlset>';

			$this->output->writeln('<comment>Writing file...</comment>');

			$file = __DIR__ . '/../../../../web/product_sitemap.xml';

			file_put_contents($file, $xml);

			$this->created_files[] = 'product_sitemap.xml';

			$this->output->writeln('<comment>Created file: product_sitemap.xml</comment>');
		
	}
    

	private function generateCategories() {

		$this->output->writeln('<comment>Adding Sections</comment>');

		$sections = $this->getContainer()->get('doctrine')->getRepository('EcommerceBundle:Section')->findAll();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach($sections as $section) {

            $xml .= '<url>';
            $xml .= '	<loc><![CDATA[http://www.addictedtovintage.nl/' . $section->getPermalink() . ']]></loc>';
            $xml .= '	<changefreq>daily</changefreq>';
            $xml .= '</url>';

            $this->output->writeln('Added: <info>' . $section->getName() . '</info>');
        }

        $xml .= '</urlset>';

        $this->output->writeln('<comment>Writing file...</comment>');

        $file = __DIR__ . '/../../../../web/sections_sitemap.xml';

        file_put_contents($file, $xml);

        $this->created_files[] = 'sections_sitemap.xml';

        $this->output->writeln('<comment>Created file: sections_sitemap.xml</comment>');

		$this->output->writeln('<comment>Adding Categories</comment>');

		$categories = $this->getContainer()->get('doctrine')->getRepository('EcommerceBundle:Category')->findAll();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach($categories as $category) {
            
            if($category->getActive() == 1) { 
                
                $sections = $category->getSections();
                $section = $sections[0];
                
                if($section != null) { 

                    $xml .= '<url>';
                    $xml .= '	<loc><![CDATA[http://www.addictedtovintage.nl/' . $section->getPermalink() . '/' . $category->getPermalink() . ']]></loc>';
                    $xml .= '	<changefreq>daily</changefreq>';
                    $xml .= '</url>';

                    $this->output->writeln('Added: <info>' . $category->getName() . '</info>');
                
                }

            }
        }

        $xml .= '</urlset>';

        $this->output->writeln('<comment>Writing file...</comment>');

        $file = __DIR__ . '/../../../../web/categories_sitemap.xml';

        file_put_contents($file, $xml);

        $this->created_files[] = 'categories_sitemap.xml';

        $this->output->writeln('<comment>Created file: categories_sitemap.xml</comment>');

		$this->output->writeln('<comment>Adding Subcategories</comment>');

		$subcategories = $this->getContainer()->get('doctrine')->getRepository('EcommerceBundle:Subcategory')->findAll();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach($subcategories as $subcategory) {
            
            if($subcategory->getActive() == 1) { 
                
                $categories = $subcategory->getCategories();
                
                $category = $categories[0];
                
                if($category != null) { 
                
                    $sections = $category->getSections();
                    $section = $sections[0];
                    
                    if($section != null) { 

                        $xml .= '<url>';
                        $xml .= '	<loc><![CDATA[http://www.addictedtovintage.nl/' . $section->getPermalink() . '/' . $category->getPermalink() . '/' . $subcategory->getPermalink() . ']]></loc>';
                        $xml .= '	<changefreq>daily</changefreq>';
                        $xml .= '</url>';

                        $this->output->writeln('Added: <info>' . $subcategory->getName() . '</info>');

                    }
                
                }

            }
        }

        $xml .= '</urlset>';

        $this->output->writeln('<comment>Writing file...</comment>');

        $file = __DIR__ . '/../../../../web/subcategories_sitemap.xml';

        file_put_contents($file, $xml);

        $this->created_files[] = 'subcategories_sitemap.xml';

        $this->output->writeln('<comment>Created file: subcategories_sitemap.xml</comment>');
		
	}
    
    private function getProductPermalink($product) { 
        
        $subcategories = $product->getSubcategories();

        if(!empty($subcategories[0])) { 
            $subcategory = $subcategories[0];
        } else { 
            return null;
        }

        $categories = $subcategory->getCategories();

        if(!empty($categories[0])) { 
            $category = $categories[0];
        } else { 
            return null;
        }

        $sections = $category->getSections();

        if(!empty($sections[0])) { 
            $section = $sections[0];
        } else { 
            return null;
        }
        
        return $section->getPermalink() . '/' . $category->getPermalink() . '/' . $subcategory->getPermalink() . '/' . $product->getPermalink();

    }
}

/*
 * 
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
  <url> 
     <loc>http://www.example.com/foo.html</loc> 
    <image:image>
       <image:loc>http://example.com/image.jpg</image:loc> 
    </image:image>
    <video:video>     
      <video:content_loc>http://www.example.com/video123.flv</video:content_loc>
      <video:player_loc allow_embed="yes" autoplay="ap=1">http://www.example.com/videoplayer.swf?video=123</video:player_loc>
      <video:thumbnail_loc>http://www.example.com/thumbs/123.jpg</video:thumbnail_loc>
      <video:title>Steaks grillen in de zomer</video:title>  
      <video:description>Elke keer perfecte steaks</video:description>
    </video:video>
  </url>
</urlset>
 */
