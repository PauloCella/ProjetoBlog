<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Interesse as InteresseForm;
use \Admin\Model\Interesse as Interesse;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

/**
 * Controlador que gerencia os posts
 * 
 * @category Skel
 * @package Controller
 * @author  Elton Minetto<eminetto@coderockr.com>
 */
class InteressesController extends AbstractActionController {

    /**
     * Mostra os posts cadastrados
     * @return void
     */
    public function indexAction() {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $interesses = $em->getRepository('\Admin\Model\Interesse')->findAll(array(), array('desc_interesse'));
        $session = $this->getServiceLocator()->get('session');
        $session->offsetSet('teste', '123');
        
        $query = $em->createQuery('SELECT Interesse FROM \Admin\Model\Interesse Interesse');

        $paginator = new Paginator(
                new DoctrinePaginator(new ORMPaginator($query))
        );
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'))
                  ->setItemCountPerPage(3);

        return new ViewModel(
                array(
            'interesses' => $paginator
                )
        );
    }

    /**
     * Cria ou edita um post
     * @return void
     */
    public function saveAction() {
        $form = new InteresseForm();
        $request = $this->getRequest(); //pega os dados do request
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); //EntityManager

        if ($request->isPost()) {
            $values = $request->getPost();
            $interesse = new Interesse();
            $form->setInputFilter($interesse->getInputFilter());
            $form->setData($values);

            if ($form->isValid()) {
                $values = $form->getData();

                if ((int) $values['id'] > 0) {
                    $interesse = $em->find('\Admin\Model\Interesse', $values['id']);
                }

                $interesse->setDescInteresse($values['desc_interesse']);
                $em->persist($interesse);

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Interesse armazenado com sucesso');
                } catch (\Exception $e) {
                    $this->flashMessenger()->addErrorMessage('Erro ao armazenar interesse');
                }

                return $this->redirect()->toUrl('/admin/interesses');
            }
        }

        $id = $this->params()->fromRoute('id', 0);

        if ((int) $id > 0) {
            $interesse = $em->find('\Admin\Model\Interesse', $id);
            //var_dump($interesse); exit;
            $form->bind($interesse); //preencher form;
        }

        return new ViewModel(
                array('form' => $form)
        );
    }

    /**
     * Exclui um post
     * @return void
     */
    public function deleteAction() {
        $id = $this->params()->fromRoute('id', 0);
        $em = $this->getServiceLocator()->
                get('Doctrine\ORM\EntityManager');
        if ($id > 0) {
            $interesse = $em->find
                    ('\Admin\Model\Interesse', $id);
            $em->remove($interesse);
            try {
                $em->flush();
                $this->flashMessenger()->
               addSuccessMessage('Interesse excluido com sucesso!');
            } catch (\Exception $e) {
                $this->flashMessenger()->
                        addErrorMessage('Esse interesse não pode ser excluido pois já há usuário viculado!');
            }
        }
        return $this->redirect()->toUrl
                ('/admin/interesses');
    }

}
