<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Usuario as UsuarioForm;
use \Admin\Model\Usuario as Usuario;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

/**
 * Controlador que gerencia as filiações
 *
 * @category Admin
 * @package Controller
 * @author Paulo Cella <paulocella@unochapeco.edu.br>
 */
class FiliacoesController extends AbstractActionController {

    /**
     * Exibe os usuários
     * @return void
     */
    public function indexAction() {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
//        $interesses = $em->getRepository('\Admin\Model\Interesse')->findAll(array(), array('desc_interesse'));
//        $session = $this->getServiceLocator()->get('session');
//        $session->offsetSet('teste', '123');
        
        $query = $em->createQuery('SELECT Filiacao  FROM \Admin\Model\Filiacao Filiacao');

        $paginator = new Paginator(
                new DoctrinePaginator(new ORMPaginator($query))
        );
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'))
                  ->setItemCountPerPage(2);

        return new ViewModel(
                array(
            'filiacao' => $paginator
                )
        );
    }
     

    /**
     * Cria ou edita um usuário
     * @return void
     */
    public function saveAction() {
       $form = new InteresseForm();
        $request = $this->getRequest(); //pega os dados do request
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); //EntityManager

        if ($request->isPost()) {
            $values = $request->getPost();
            $filiacao = new Interesse();
            $form->setInputFilter($filiacao->getInputFilter());
            $form->setData($values);

            if ($form->isValid()) {
                $values = $form->getData();

                if ((int) $values['id'] > 0) {
                    $interesse = $em->find('\Admin\Model\Filiacao', $values['id']);
                }

                $filiacao->setDescPai($values['desc_pai']);
                $filiacao->setDescMae($values['desc_mae']);
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
     * Exclui uma filiacao
     * @return void
     */
    public function deleteAction() {
        $id = $this->params()->fromRoute('id', 0);
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        if ($id > 0) {
            $filiacao = $em->find('\Admin\Model\Filiacao', $id);
            $em->remove($filiacao);
            try {
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Filiacao excluído com sucesso');
            } catch (\Exception $e) {
                $this->flashMessenger()->addErrorMessage('Erro ao excluir Filiacao');
            }
        }
        return $this->redirect()->toUrl('/admin/usuarios');
    }

}
