<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Sexo as SexoForm;
use \Admin\Model\Sexo as Sexo;


/**
 * Controlador que gerencia os posts
 * 
 * @category Skel
 * @package Controller
 * @author  Elton Minetto<eminetto@coderockr.com>
 */
class SexosController extends AbstractActionController
{
    /**
     * Mostra os posts cadastrados
     * @return void
     */
    public function indexAction()
    {
         $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $sexos = $em->getRepository('\Admin\Model\Sexo')->findAll(array(), array('desc_sexo'));
        $session = $this->getServiceLocator()->get('session'); //pega variavel de sessao
        //echo $session->offsetGet('teste');	// imprime variavel de sessao
        $session->offsetUnset('teste'); 	//Destroi a variavel de sessao

        return new ViewModel(
            array(
                'sexos'=> $sexos
                )
            );
					
    }

    /**
     * Cria ou edita um post
     * @return void
     */
    public function saveAction()
    {
            $form = new SexoForm();
            $request = $this->getRequest(); //pega os dados do request
            $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); //EntityManager

            if ($request->isPost()){
                $values = $request->getPost();
                 $sexo = new Sexo();
                 $form->setInputFilter($sexo->getInputFilter());
                 $form->setData($values);

                 if($form->isValid()){
                    $values=$form->getData();

                if((int) $values['id'] > 0)
                    $sexo = $em->find('\Admin\Model\Sexo', $values['id']);

                $sexo->setDescSexo($values['desc_sexo']);
                $em->persist($sexo);



                try{
                    $em->flush();
                     $this->flashMessenger()->addSuccessMessage('Sexo armazenado com sucesso');
                }catch (\Exception $e){
                    $this->flashMessenger()->addErrorMessage('Erro ao armazenar sexo');
                }

                return $this->redirect()->toUrl('/admin/sexos');
            }
            }
                            

            $id = $this->params()->fromRoute('id',0);

            if((int) $id > 0){
                $sexo = $em->find('\Admin\Model\Sexo', $id);
                $form->bind($sexo);
            }

            return new ViewModel(
                array('form' => $form)
                );

    }

    /**
     * Exclui um post
     * @return void
     */
    public function deleteAction()
    {
            $id = $this->params()->fromRoute('id', 0);
             $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
             if ($id > 0) {
                   $sexo = $em->find('\Admin\Model\Sexo', $id);
                    $em->remove($sexo);
              try {
                   $em->flush();
                  $this->flashMessenger()->addSuccessMessage('Sexo excluído com sucesso');
             } catch (\Exception $e) {
                  $this->flashMessenger()->addErrorMessage('Erro ao excluir sexo');
                 }
            }
            return $this->redirect()->toUrl('/admin/sexos');
    }

}
