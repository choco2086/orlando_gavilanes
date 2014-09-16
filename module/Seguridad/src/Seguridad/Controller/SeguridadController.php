<?php
namespace Seguridad\Controller;

use Zend\Mvc\Controller\AbstractActionController, Zend\View\Model\ViewModel, Doctrine\ORM\EntityManager, Seguridad\Entity\Usuario;

class SeguridadController extends AbstractActionController
{

    /**
     *
     * @var Doctrine\ORM\EntityManager
     *
     */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'usuarios' => $this->getEntityManager()
                ->getRepository('Seguridad\Entity\Usuario')
                ->findAll()
        ));
    }

    public function addAction()
    {
        if ($request->isPost()) {
            $album = new Usuario();
            
            /*
             * $album->populate($form->getData()); $this->getEntityManager()->persist($album); $this->getEntityManager()->flush(); // Redirect to list of albums return $this->redirect()->toRoute('seguridad'); }
             */
        }
        
        // return array('form' => $form);
    }

    public function editAction()
    {
        /*
         * $id = (int)$this->getEvent()->getRouteMatch()->getParam('id'); if (!$id) { return $this->redirect()->toRoute('album', array('action'=>'add')); } $album = $this->getEntityManager()->find('Album\Entity\Album', $id); $form = new AlbumForm(); $form->setBindOnValidate(false); $form->bind($album); $form->get('submit')->setAttribute('label', 'Edit'); $request = $this->getRequest(); if ($request->isPost()) { $form->setData($request->post()); if ($form->isValid()) { $form->bindValues(); $this->getEntityManager()->flush(); // Redirect to list of albums return $this->redirect()->toRoute('album'); } } return array( 'id' => $id, 'form' => $form, );
         */
    }

    public function deleteAction()
    {
        /*
         * $id = (int)$this->getEvent()->getRouteMatch()->getParam('id'); if (!$id) { return $this->redirect()->toRoute('album'); } $request = $this->getRequest(); if ($request->isPost()) { $del = $request->post()->get('del', 'No'); if ($del == 'Yes') { $id = (int)$request->post()->get('id'); $album = $this->getEntityManager()->find('Album\Entity\Album', $id); if ($album) { $this->getEntityManager()->remove($album); $this->getEntityManager()->flush(); } } // Redirect to list of albums return $this->redirect()->toRoute('default', array( 'controller' => 'album', 'action' => 'index', )); } return array( 'id' => $id, 'album' => $this->getEntityManager()->find('Album\Entity\Album', $id)->getArrayCopy() );
         */
    }
}