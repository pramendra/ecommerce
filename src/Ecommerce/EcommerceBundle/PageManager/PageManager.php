<?php

namespace Ecommerce\EcommerceBundle\PageManager;

use Symfony\Component\DependencyInjection\ContainerAware;
use Ecommerce\EcommerceBundle\Entity\Page;

class PageManager extends ContainerAware {

    private $page;

    public function setPermalink($permalink) {
        
        $page = $this->getDoctrine()->getRepository('EcommerceBundle:Page')->findOneByPermalink($permalink);
        
        if($page !== null) { 
            $this->page = $page;
        }
        
        return $this->page;
    }

    public function pageParser(array $data = array()) {

        /**
         * Parse title
         */
        $this->page->setTitle($this->textParser($this->page->getTitle(), $data));
        
        $this->page->setPageTitle($this->textParser($this->page->getPageTitle(), $data));

        /**
         * Parse Meta Description
         */
        $this->page->setDescription($this->textParser($this->page->getDescription(), $data));


        /**
         * Filter <enters> uit meta description 
         */
        $meta_description = $this->page->getDescription();
        $meta_description = str_replace("\n", " ", $meta_description);
        $meta_description = str_replace("\r", "", $meta_description);

        $this->page->setDescription($meta_description);

        /**
         * Parse content
         */
        $page_content = $this->textParser($this->page->getContent(), $data);
        $this->page->setContent($page_content);


        return $this->page;
    }

    private function textParser($text, array $data = array()) {
        foreach ($data as $key => $replacement) {
            $text = $this->stringParse($text, $key, $replacement);
            $text = $this->stringParseUcFirst($text, $key, $replacement);
            $text = $this->stringParseToUpper($text, $key, $replacement);
            $text = $this->stringParseToLower($text, $key, $replacement);
        }

        return $text;
    }

    private function stringParseUcFirst($text, $key, $replacement) {
        return str_replace('[' . $key . '}', ucfirst($replacement), $text);
    }

    private function stringParseToUpper($text, $key, $replacement) {
        return str_replace('[' . $key . ']', strtoupper($replacement), $text);
    }

    private function stringParseToLower($text, $key, $replacement) {
        return str_replace('_' . $key . '_', strtolower($replacement), $text);
    }

    private function stringParse($text, $key, $replacement) {
        return str_replace('{' . $key . '}', $replacement, $text);
    }

    /*     * ******** Shortcuts to the service container etc. ********* */

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    private function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not installed in your application.');
        }

        return $this->container->get('doctrine');
    }

    /**
     * Shortcut to return the request service.
     *
     * @return Request
     */
    private function getRequest() {
        return $this->container->get('request');
    }
}

