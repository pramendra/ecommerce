<?php

namespace Ecommerce\SGBundle\Twig\Extension;

use Ecommerce\SGBundle\Paginator\Paginator;

class PaginateTwigExtension extends \Twig_Extension {

    function __construct() { }

    public function getFilters() {
        return array(
            'paginate' => new \Twig_Filter_Method($this, 'paginate'),
        );
    }

    public function paginate(Paginator $paginator) {
       
        if($paginator->getNumPages() > 1) { 
            
            $next_page = ($paginator->getCurrentPage() + 1);
            $prev_page = ($paginator->getCurrentPage() - 1);
            
            echo '<div class="row-fluid">';
            echo '  <div class="span12">';
            echo '      <div class="checkout-well">';
            
            if($paginator->getCurrentPage() != 0) { 
                
                if($prev_page == 0) { 
                    echo '<a class="btn pull-left" href="'.$paginator->getBaseUrl().'"><i class="icon-arrow-left"></i> Vorige ' . $paginator->getLimit() . '</a>';                          
                } else { 
                    echo '<a class="btn pull-left" href="'.$paginator->getBaseUrl().'?page='.$prev_page.'"><i class="icon-arrow-left"></i> Vorige ' . $paginator->getLimit() . '</a>';    
                }
            }
            
            if($paginator->getCurrentPage() != ($paginator->getNumPages() - 1)) { 
                echo '<a class="btn pull-right" href="'.$paginator->getBaseUrl().'?page='.$next_page.'">Volgende ' . $paginator->getLimit() . ' <i class="icon-arrow-right"></i></a>';    
            }
            
            echo '<div class="clearfix"></div>';
            
            echo '      </div>';    
            echo '  </div>';    
            echo '</div>';    
       }
        /*
         * 
        <ul>    

            {% if paginator.numpages > 0 %}
                {% if paginator.currentpage == 0 %}
                    <a class="btn pull-right"><i class="icon-arrow-right"></i> Volgende</a>
                {% endif %}
                    
                {% if paginator.currentpage > 0 %}
                    <a class="btn pull-left"><i class="icon-arrow-left"></i> Vorige</a>
                {% endif %}
            
            {% endif %}

        </ul>
        
        {% spaceless %}
        <div class="pagination pagination-small">
            <ul>
                                
                {% set i = 2 %}
                
                {% if paginator.currentpage != 1 %}
                    <li> <a class="previous" href="">Vorige</a>
                {% endif %}
                            
                {% set i = 1 %}
                    
                {% if paginator.numpages > 0 %}
                    {% if i==paginator.currentpage %}
                        {% if i != 1 %}
                        <li class="active"><a href="{{ path('_subcategory', { 'section' : section.permalink, 'category' : category.permalink, 'subcategory' : subcategory.permalink, 'page': i })}}">{% if i == paginator.numpages %}{{ paginator.numpages }}{% else %}{{i}}{% endif %}</a></li>
                        {% endif %}
                    {% else %}
                        {% if i != 1 %}
                        <li><a href="{{  path('_subcategory', { 'section' : section.permalink, 'category' : category.permalink, 'subcategory' : subcategory.permalink, 'page': i }) }}">{% if i == 1 %}1{% elseif i == paginator.numpages %}{{ paginator.numpages }}{% else %}{{i}}{% endif %}</a></li>
                        {% endif %}
                    {% endif %}
                {% endif %}
                            
                            
                {% for i in i..paginator.numpages %}
                        {% if paginator.range.0 > 2 and i == paginator.range.0 %}
                            <li class="disabled"><a href="javascript:void(0)">...</a></li>
                        {% endif %}

                        {% if i < paginator.numpages and (i in paginator.range) %}
                            {% if i==paginator.currentpage %}
                                <li class="active"><a href="{{  path('_subcategory', { 'section' : section.permalink, 'category' : category.permalink, 'subcategory' : subcategory.permalink, 'page': i })}}">{% if i == 1 %}1{% elseif i == paginator.numpages %}{{ paginator.numpages }}{% else %}{{i}}{% endif %}</a></li>
                            {% else %}
                                <li><a href="{{  path('_subcategory', { 'section' : section.permalink, 'category' : category.permalink, 'subcategory' : subcategory.permalink, 'page': i }) }}">{% if i == 1 %}1{% elseif i == paginator.numpages %}{{ paginator.numpages }}{% else %}{{i}}{% endif %}</a></li>
                            {% endif %}
                        {% endif %}

                        {% if paginator.range[paginator.midrange -1] < paginator.numpages -1 and i == paginator.range[paginator.midrange-1] %}
                            <li class="disabled"><a href="javascript:void(0)">...</a></li>
                        {% endif %}
                            
                {% endfor %}
                            
                {% if paginator.numpages > 1 %}
                    <li><a{% if paginator.numpages==paginator.currentpage %} class="active"{% endif %} href="{{  path('_subcategory', { 'section' : section.permalink, 'subcategory' : subcategory.permalink, 'category' : category.permalink, 'page': paginator.numpages }) }}">{{ paginator.numpages }}</a></li>
                {% endif %}
                                
                {% if paginator.currentpage != paginator.numpages %}
                    <li> <a class="next" href="{{  path('_subcategory', { 'section' : section.permalink, 'category' : category.permalink, 'subcategory' : subcategory.permalink, 'page': paginator.currentpage+1 }) }}">Volgende</a>
                {% endif %}
            </ul>
        </div>
        {% endspaceless %}

         */

        return '';
    }

    public function getName() {
        return 'paginate_twig_extension';
    }

}