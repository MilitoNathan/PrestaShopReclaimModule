<?php

require_once _PS_MODULE_DIR_ . 'reclamations/classes/ReclaimForm.php';

class AdminReclaimFormController extends ModuleAdminController
{
    
    public function __construct()
    {
        $this->table = 'reclaim_form'; // Nom de la table en base de données
        $this->className = 'ReclaimForm'; // Nom de la classe du modèle
        $this->identifier = 'id_reclaim'; // Nom de la clé primaire de la table
        // $this->lang = false;
        
        // $this->list_no_link = true;
        $this->bootstrap = true;

        parent::__construct();


        
        $this->_defaultOrderWay = 'ASC';




        $this->fields_list = [
            'id_reclaim' => ['title' => 'Reclaim ID','class' => 'fixed-width-xs'],
            'surname' => ['title' => 'Surname'],
            'name' => ['title' => 'Name'], // filter_key mandatory because "name" is ambiguous for SQL
            'mail' => ['title' => 'Email'], // filter_key mandatory because JOIN
            'message' => ['title' => 'Message','type'=>'textArea'],
            'ext_doc' => ['title' => 'Format du document'],
            'path_doc' => ['title' => 'Chemin de stockage du document'],
            /*'document' => ['title' => 'Document', 'type'=>'file'],*/
          ];




        /*
        $this->fields_list = array(
            'id_reclaim' => array(
                'title' => $this->trans('ID'),
                'align' => 'center',
                'width' => 30,
            ),
            'name' => array(
                'title' => $this->trans('Name'),
            ),
            'surname' => array(
                'title' => $this->trans('Surname'),
            ),
            'email' => array(
                'title' => $this->trans('Email'),
            ),
            'message' => array(
                'title' => $this->trans('Message'),
            ),
        );
 
*/


        $this->addRowAction('details');
        $this->addRowAction('delete');
        $this->addRowAction('edit');
        $categories = Category::getCategories($this->context->language->id, $active = true, $order = false);


        $this->fields_form = [
            'legend' => [
                'title' => 'ReclaimForm',
            ],
            'input' => [
                [
                    'name' => 'name',
                    'type' => 'text',
                    'label' => 'Nom',
                    'required' => true,
                ],
                [
                    'name' => 'surname',
                    'type' => 'tags',
                    'label' => 'Prénom',
                    'required' => true,
                ],
                [
                    'name' => 'message',
                    'type' => 'textarea',
                    'label' => 'Message',
                    'required' => true,
                ],
                [
                    'name' => 'mail',
                    'type' => 'text',
                    'label' => 'Adresse mail',
                    'required' => true,
                ],
                [
                    'name' => 'ext_doc',
                    'type' => 'text',
                    'label' => 'Extension du document',
                    'required' => false,
                    'editable' => false,
                    'prefix' => 'Ne pas modifier',
                ],
                [
                    'name' => 'path_doc',
                    'type' => 'text',
                    'label' => 'Chemin de stockage du document',
                    'required' => false,
                    'editable' => false,
                    'prefix' => 'Ne pas modifier',
                ],
                
            ],
            'submit' => [
              'title' => $this->trans('Save', [], 'Admin.Actions'),
            ]
            ];

 
  
      }
      
}
