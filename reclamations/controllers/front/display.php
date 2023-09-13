<?php

include_once(_PS_MODULE_DIR_ . 'reclamations/reclamations.php'); 
include_once(_PS_MODULE_DIR_ . 'reclamations/classes/ReclaimForm.php');

class ReclamationsDisplayModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->setTemplate('module:reclamations/views/templates/front/display.tpl');
    }

    public function setMedia()
    {
        parent::setMedia();
        $this->registerStylesheet(
            'reclamation',
            '/modules/reclamations/views/css/reclamationsFront.css',
            [
                'media' => 'all',
                'priority' => 200,
            ]
        ); 
    }

    public function postProcess()
    {
        // $this->errors[] = $this->trans('Please enter your name');
        // return;
        // $this->success[] = $this->l('Information successfully updated.');
        // exit('ok');
        if (Tools::isSubmit('submitReclaim')) {

            //var_dump($_POST);

            /*
            if(null !== Tools::getValue('document')){
                var_dump($_FILES['document']);
                var_dump(Tools::getValue('document'));
            }
            else{
                var_dump($_FILES['document']);
                return "ahaahallaalala";
            }*/

            $name = Tools::getValue('name');
            $firstname = Tools::getValue('firstname');
            $email = Tools::getValue('email');
            $message = Tools::getValue('message');
            $documentType = $_FILES['document']['type'];
            $id_document = Tools::getValue('id');

            // Manipuler ta BDD directement avec des requêtes
            // Db::getInstance()

            // Insérer mes données via un ObjectModel
            $reclaim = new ReclaimForm();
            $reclaim->name = $name;
            $reclaim->surname = $firstname;
            $reclaim->mail = $email;
            $reclaim->message = $message;
            $reclaim->ext_doc = $documentType; 
            $reclaim->path_doc = _PS_ROOT_DIR_ . '/var/modules/reclaims/'.$name.'_'.$firstname;

            $hasError = false;

            /*

            $id_documents=new ReclaimForm();
            $id_documents->id=$id_document;
            var_dump($id_documents);
              
            */                

            if (empty($email)) {
                $this->errors[] = $this->trans('Please enter your email.');
                $hasError = true;
            }

            if (empty($message)) {
                $this->errors[] = $this->trans('Please enter a message.');
                $hasError = true;
            }
            if($_FILES['document']['type'] >= 200000){
                $this->errors[] = $this->trans('Too heavy file');
                $hasError = true;
            }                

            try {
                $reclaim->save();
                $idReclaimForm = $reclaim->id;
                var_dump($idReclaimForm);

                $filesInfos = pathinfo($_FILES['document']['name']);
                $extension_upload = $filesInfos['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'png', 'pdf');
              
                if (in_array($extension_upload, $extensions_autorisees))
                {
                    move_uploaded_file($_FILES['document']['tmp_name'], _PS_ROOT_DIR_ . 'var/modules/reclaims/reclaim-'.$idReclaimForm.'_'.$name.'_'.$firstname);
                    echo "L'envoi a bien été effectué !";
                }
                else{
                    $this->errors[] = $this->trans('Bad file extension');
                    $hasError = true;
                }

                if ($hasError) {
                    return false;
                }

                $this->success[] = $this->trans('Information successfully updated.');
                } catch (PrestaShopException $e) {
                $this->errors[] = $this->trans('An error as occured during saving');
                //var_dump($reclaim);
            }
        }
    }
}