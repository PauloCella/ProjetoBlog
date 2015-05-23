<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Post as PostForm;
use \Admin\Entity\Post as Post;

/**
 * Controlador que gerencia os posts
 *
 * @category Admin
 * @package Controller
 * @author  Ana Paula Binda <anapaulasif@unochapeco.edu.br>
 */
class PostsController extends AbstractActionController
{

    /**
     * Exibe os posts
     * @return void
     */
    public function indexAction()
    {
        
        return new ViewModel(
          
        );
    }

    /**
     * Cria ou edita um post
     * @return void
     */
    public function saveAction()
    {
                return new ViewModel(
                    );
    }

     

    /**
     * Exclui um post
     * @return void
     */
    public function deleteAction()
    {
       
    }

}
