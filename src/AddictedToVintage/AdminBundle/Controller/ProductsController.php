<?php

namespace AddictedToVintage\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AddictedToVintage\AdminBundle\UploadHandler\UploadHandler;
use AddictedToVintage\EcommerceBundle\Entity\ProductImages;
use AddictedToVintage\EcommerceBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends Controller {

    public function indexAction() {
        
        $query_string = $this->getRequest()->getQueryString();
        
        $selected_stock = $this->getRequest()->get('stock');
        $selected_sale = $this->getRequest()->get('is_sale');
        $selected_subcategory = $this->getRequest()->get('subcategory');
        
        $categories = $this->getDoctrine()->getRepository('EcommerceBundle:Category')->findAll();
        
        return $this->render('AdminBundle:Products:index.html.twig', 
                array('query_string' => $query_string,
                    'categories' => $categories,
                    'selected_subcategory' => $selected_subcategory,
                    'selected_sale' => $selected_sale,
                    'selected_stock' => $selected_stock));
    }

    public function uploadAction() {

        

        $upload_handler = new UploadHandler();

        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Content-Disposition: inline; filename="files.json"');
        header('X-Content-Type-Options: nosniff');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $upload_handler->get();
                break;
            case 'POST':
                if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
                    $upload_handler->delete();
                } else {
                    
                    $product = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->find($this->getRequest()->get('id'));
                    
                    $uploaded_files = $upload_handler->post();

                    $em = $this->getDoctrine()->getEntityManager();

                    foreach ($uploaded_files as $uploadfile) {

                        $product_image = new ProductImages();

                        $url = explode('images', $uploadfile->url);
                        $thumbPath = str_replace('/', '/thumbs/', ltrim($url[1], '/'));


                        $product_image->setName($uploadfile->name);
                        $product_image->setPath('/images' . $url[1]);
                        $product_image->setThumbPath('/images/' . $thumbPath);
                        $product_image->setProduct($product);
                        $product_image->setFileSize($uploadfile->size);
                        $product_image->setCreatedAt(new \DateTime());

                        $em->persist($product_image);

                        $em->flush();
                    }

                    $json = json_encode($uploaded_files);

                    $redirect = isset($_REQUEST['redirect']) ?
                            stripslashes($_REQUEST['redirect']) : null;
                    if ($redirect) {
                        header('Location: ' . sprintf($redirect, rawurlencode($json)));
                        return;
                    }
                    if (isset($_SERVER['HTTP_ACCEPT']) &&
                            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
                        header('Content-type: application/json');
                    } else {
                        header('Content-type: text/plain');
                    }
                    echo $json;
                }
                break;
            case 'DELETE':
                $upload_handler->delete();

                $filename = $_REQUEST['file'];

                $product_image = $this->getDoctrine()->getRepository('EcommerceBundle:ProductImages')->findOneBy(array('name' => $filename));

                if ($product_image != null) {

                    $em = $this->getDoctrine()->getEntityManager();

                    $em->remove($product_image);

                    $em->flush();
                } else {
                    echo 'No records found for: ' . $filename;
                }


                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }

        $response = new Response();
        return $response;
    }
    
    public function attributesAction($id, $product_attribute_id) { 
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $product = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->find($id);
        
        if($product_attribute_id == 0) { 
            
            $productAttribute = new \AddictedToVintage\EcommerceBundle\Entity\ProductAttributes();
            
            $attribute_id = $this->getRequest()->get('attribute_id');
            $attribute = $this->getDoctrine()->getRepository('EcommerceBundle:Attribute')->find($attribute_id);
            
            $productAttribute->setAttribute($attribute);
            $productAttribute->setProduct($product);
            
        } else { 
            $productAttribute = $this->getDoctrine()->getRepository('EcommerceBundle:ProductAttributes')->find($product_attribute_id);
        }
        
        $productAttribute->setAttributeValue($this->getRequest()->get('attribute_value'));
        $productAttribute->setIsSelectable(true);
        
        if($product_attribute_id == 0) { 
            $em->persist($productAttribute);
        }
        
        
        $em->flush();       
        
        return $this->redirect($this->generateUrl('admin_products_edit', array('id' => $product->getId())));
    }

    public function editAction($id) {

        $sections = $this->getDoctrine()->getRepository('EcommerceBundle:Section')->findAll();
        $attributes = $this->getDoctrine()->getRepository('EcommerceBundle:Attribute')->findAll();
        
        if ($id == 0) {
            $product = new Product();
        } else {
            $product = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->find($id);
        }

        $product_form = $this->createForm(new \AddictedToVintage\AdminBundle\Form\ProductType($product), $product);

        $product_form->setData($product);

        if ($this->getRequest()->getMethod() == 'POST') {

            $product_form->bindRequest($this->getRequest());

            if ($product_form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                
                $request = Request::createFromGlobals();
                $postData = $request->request->get('product');
                
                $first_image_id = $this->getRequest()->get('first_image');
                
                if($first_image_id !== null) {
                    
                   $product->setFirstImage($first_image_id);
                }
                
                if ($product->getId() == null) {
                    
                    $product->setCreatedAt(new \DateTime());
                    $product->setViews(0);
                    $em->persist($product);
                } else { 
                    $product->setUpdatedAt(new \DateTime());
                }
		
		if($product->getIsNew() == 1) { 
		    $product->setCreatedAt(new \DateTime());
		}
		
		$permalink = $this->slugify($product->getName(), $product->getSku());
                $product->setPermalink($permalink);

                $em->flush();
                
                return $this->redirect($this->generateUrl('admin_products_edit', array('id' => $product->getId())));
            }
        }

        return $this->render('AdminBundle:Products:edit.html.twig', array('product' => $product, 'sections' => $sections,  'attributes' => $attributes, 'products_form' => $product_form->createView()));
    }
    
    public function deleteAction($id) { 
        $em = $this->getDoctrine()->getEntityManager();
        
        $product = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->find($id);
        $product->setDeletedAt(new \DateTime('now'));
        
        $em->flush();
        
        $this->get('session')->setFlash('notice', 'Product ' . $product->getName() . ' is verwijderd!');
        
        return $this->redirect($this->generateUrl('admin_products'));
    }
    
    public function removeattributeAction() { 
	$em = $this->getDoctrine()->getEntityManager();
        
	$id = $this->getRequest()->get('attribute');
	
        $productAttribute = $this->getDoctrine()->getRepository('EcommerceBundle:ProductAttributes')->find($id);
        
	$em->remove($productAttribute);
        $em->flush();
        
        $response = new Response(json_encode('true'));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
	
    }

    public function jsonProductsAction() {

        $stock = $this->getRequest()->get('stock');
        $sale = $this->getRequest()->get('is_sale');
        
        $subcategory = $this->getRequest()->get('subcategory');
        
        if($subcategory != null) {
            $subcategory = $this->getDoctrine()->getRepository('EcommerceBundle:Subcategory')->find($subcategory);
        }
        
        if($stock != null || $subcategory != null || $sale != null) { 
            $products = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->findProductsByAdminFilter($stock, $subcategory, $sale);
        } else { 
            $products = $this->getDoctrine()->getRepository('EcommerceBundle:Product')->findAll();
        }

        $result = array();

        foreach ($products as $product) {

            $firstImage = $product->getFirstImage();
            
            if(!empty($firstImage)) { 
                
                $image = $product->getFirstImage()->getId();
                
            } else { 
            
                $images = $product->getImages();

                if (!empty($images)) {

                    if (!empty($images[0])) {
                        $image = $images[0]->getThumbPath();
                    } else {
                        $image = '';
                    }
                } else {
                    $image = '';
                }
            }

            if($product->getDeletedAt() == null) { 
            
                $result['aaData'][] = array($product->getSKU(), '<a data-content="<img src=\'' . $image . '\'/>" rel="popover" class="popover_link" href="'. $this->generateUrl('admin_products_edit', array('id' => $product->getId())) .'">' . $product->getName() . '</a> ', '&euro;' .number_format($product->getPrice(), 2), $product->getStock(), $product->getShippingType()->getName(), '<span class="hide">' . $product->getCreatedAt()->format("YmdHi") . '</span>'. $product->getCreatedAt()->format("d-m-Y H:i"));
            
            }
        }

        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    
    private function slugify($title, $sku) { 
        
        $permalink = strtolower($title);
        $permalink = str_replace(' ', '-', $permalink);
        $permalink = preg_replace("/[\/_|+ -]+/", '-', $permalink);        
        
        return $permalink . '-' . $sku;
    }
 
}
