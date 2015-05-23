<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Telefone as TelefoneForm;
use \Admin\Model\Telefone as Telefone;


/**
 * Controlador que gerencia os posts
 * 
 * @category Skel
 * @package Controller
 * @author  Elton Minetto<eminetto@coderockr.com>
 */
class TelefonesController extends AbstractActionController
{
    /**
     * Mostra os posts cadastrados
     * @return void
     */
    public function indexAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $telefones = $em->getRepository('\Admin\Model\Telefone')->findAll(array(), array('desc_telefone'));
        $session = $this->getServiceLocator()->get('session'); //pega variavel de sessao
        //echo $session->offsetGet('teste');	// imprime variavel de sessao
        $session->offsetUnset('teste'); 	//Destroi a variavel de sessao

        return new ViewModel(
            array(
                'telefones'=> $telefones
                )
            );
					
    }

    /**
     * Cria ou edita um post
     * @return void
     */
    public function saveAction()
    {
            $form = new TelefoneForm();
            $request = $this->getRequest(); //pega os dados do request
            $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); //EntityManager

            if ($request->isPost()){
                $values = $request->getPost();
                 $telefone = new Telefone();
                 $form->setInputFilter($telefone->getInputFilter());
                 $form->setData($values);

                 if($form->isValid()){
                    $values=$form->getData();


                if((int) $values['id'] > 0)
                    $telefone = $em->find('\Admin\Model\Telefone', $values['id']);
                   

                $telefone->setDescTelefone($values['desc_telefone']);
                $em->persist($telefone);



                try{
                    $em->flush();
                     $this->flashMessenger()->addSuccessMessage('Telefone armazenado com sucesso');
                }catch (\Exception $e){
                    $this->flashMessenger()->addErrorMessage('Erro ao armazenar telefone');
                }

                return $this->redirect()->toUrl('/admin/telefones');
            }
            }
                            

            $id = $this->params()->fromRoute('id',0);

            if((int) $id > 0){
                $telefone = $em->find('\Admin\Model\Telefone', $id);
                $form->bind($telefone);
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
                   $telefone = $em->find('\Admin\Model\Telefone', $id);
                    $em->remove($telefone);
              try {
                   $em->flush();
                  $this->flashMessenger()->addSuccessMessage('Telefone excluído com sucesso');
             } catch (\Exception $e) {
                  $this->flashMessenger()->addErrorMessage('Erro ao excluir telefone');
                 }
            }
            return $this->redirect()->toUrl('/admin/telefones');
    }

}
