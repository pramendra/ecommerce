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

class ThumbnailCommand extends ContainerAwareCommand {

    private $input;
    private $output;
    private $em;
    private $rootPath = '/home/dev.addictedtovintage.nl/web/images/products';

    protected function configure() {
        $this->setName('addictedtovintage:images')->setDescription('Check files & create thumbs');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $this->input = $input;
        $this->output = $output;
        $this->em = $this->getContainer()->get('doctrine')->getEntityManager();

        $output->writeln('<comment>Scanning product images...</comment> ');

        $products = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->findAll();

        $i = 1;
        $total_products = count($products);

        $files_not_found = array();

        foreach ($products as $product) {

            $output->writeln('<comment>Product: ' . $product->getName() . ' (' . $i . ' van ' . $total_products . ')</comment>');

            $output->writeln('  Found: ' . count($product->getImages()) . ' images');

            foreach ($product->getImages() as $image) {

                $name = str_replace('/images/products/', '', $image->getPath());
                $name = str_replace('images/products/', '', $name);

                $image->setName($name);

                if (!file_exists($this->rootPath . '/' . $image->getName())) {
                    $this->output->writeln('<error>File not found: ' . $image->getName() . '</error>');

                    $files_not_found[] = $image;

                    continue;
                }

                $image->setFileSize(filesize($this->rootPath . '/' . $image->getName()));

                if (file_exists($this->rootPath . '/thumbs/' . $image->getName())) {
                    $this->output->writeln('<info>Thumb "' . $image->getName() . '" already exists</info>');
                    $image->setThumbPath('/images/products/thumbs/' . $image->getName());
                    //$this->em->flush();
                    continue;
                }

                $options = array(
                    'max_width' => 150,
                    'max_height' => 150
                );

                $this->createThumb($image->getName(), $options);

                $image->setThumbPath('/images/products/thumbs/' . $image->getName());

                $this->em->flush();
            }

            $i++;

            $this->em->clear();
        }

        $output->writeln('<error>Errors: ' . count($files_not_found) . ' images </error>');
    }

    private function createThumb($file_name, $options) {

        error_reporting(E_ALL);

        $this->output->write('Creating thumb for ' . $file_name . ' ');

        $source_image = $this->rootPath . '/' . $file_name;
        $new_file_path = $this->rootPath . '/thumbs/' . $file_name;

        $thumb_height = 150;
        $quality = 100;
        $supported_types = array(1, 2, 3, 7);


        if (!@getimagesize($source_image)) {

            $this->output->writeln('<error>Can\'t get imagesize</error>');

            return;
        }

        /*         * * get the image info ** */
        list($width_orig, $height_orig, $image_type) = getimagesize($source_image);



        /** check for supported type ** */
        if (!in_array($image_type, $supported_types)) {
            $this->output->writeln('<error>Unsupported Image Type: ' . $image_type . '</error>');
        } else {
            $path_parts = pathinfo($source_image);
            $filename = $path_parts['filename'];

            /*             * * calculate the aspect ratio ** */
            $aspect_ratio = (float) $width_orig / $height_orig;

            /*             * * calulate the thumbnail width based on the height ** */
            $thumb_width = round($thumb_height * $aspect_ratio);

            /*             * * imagecreatefromstring will automatically detect the file type ** */
            $source = imagecreatefromstring(file_get_contents($source_image));

            /*             * * create the thumbnail canvas ** */
            $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

            /*             * * map the image to the thumbnail ** */
            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width_orig, $height_orig);
            /*             * * destroy the source ** */
            imagedestroy($source);

            /*             * * write thumbnail based on file type ** */
            switch ($image_type) {
                case 1:
                    imagegif($im, $new_file_path);
                    $thumbnail = $filename . '.gif';
                    break;

                case 2:
                    $thumbnail = $filename . '.jpg';
                    imagejpeg($thumb, $new_file_path, $quality);
                    break;

                case 3:
                    imagepng($im, $new_file_path);
                    $thumbnail = $filename . '.png';
                    break;

                case 7:
                    imagewbmp($im, $new_file_path);
                    $thumbnail = $filename . '.bmp';
                    break;
            }
        }


        if (\file_exists($this->rootPath . '/thumbs/' . $file_name)) {
            $this->output->write('<info>OK</info>');
        } else {
            $this->output->write('<error>FALSE </error>');
        }

        $this->output->writeln('');
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