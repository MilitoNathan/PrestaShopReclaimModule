<?php

error_reporting(E_ALL); ini_set('display_errors', 1);

if (!defined('_PS_VERSION_')) {
    exit;
}

class Reclamations extends Module {

/** Extensions autorisées pour l'envoi de fichiers */
private $_registration_allowed_extensions = array('pdf','jpg','png');

/* Nom du dossier dans lequel sont envoyés les fichiers */
private $_upload_dir = 'var/modules/reclamations/';    

    public function __construct()
    {
        $this->name = 'reclamations';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'EFIPEEK';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => '8.99.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Reclaim module');
        $this->description = $this->l('The module that permit clients to make reclaims');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module which is really great ?');
        

        if (!Configuration::get('MYMODULE_NAME')) {
            $this->warning = $this->l('No name given');
        }

        require_once __DIR__ . '/classes/ReclaimForm.php';
    }

    public function install()
        {
            // Run sql for creating DB tables
            Db::getInstance()->execute(
                       'create table if not exists ' . _DB_PREFIX_ .'reclaim_form  (
                        `id_reclaim` int NOT NULL AUTO_INCREMENT,
                        `name` varchar(255) NULL,
                        `surname` varchar(255) NULL,
                        `mail` varchar(255) NULL,
                        `message` varchar(255) NULL,
                        `path_doc` varchar(255) NULL,
                        `ext_doc` varchar(255) NULL,
                            PRIMARY KEY (`id_reclaim`),
                            INDEX `id_reclaim_indexe`(`id_reclaim`)
                            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;');
 
                        if (!parent::install() ||
                            !$this->registerHook('displayLeftColumn') ||
                            !$this->registerHook('displayFooter') ||
                            !$this->registerHook('displayHeader') ||
                            !Configuration::updateValue('RECLAMATIONS_PAGENAME', 'Make a reclaim')|| 
                            !$this->registerHook('displayCustomerAccountForm') || 
                            !$this->registerHook('actionCustomerAccountAdd')
                        ) {
                            return false;
                        }
            return parent::install();
        }

    public function uninstall()
    {
        return (
            Db::getInstance()->execute('drop table ' . _DB_PREFIX_ . 'reclaim_form')
            && $this->unregisterHook('displayLeftColumn')
            && $this->unregisterHook('displayFooter')
            && $this->unregisterHook('displayHeader')
            && parent::uninstall()
            && Configuration::deleteByName('RECLAMATIONS_PAGENAME')
            && $this->unregisterHook('displayCustomerAccountForm')
            && $this->unregisterHook('actionCutomerAccountAdd')
        );
    }




    public function getForms()
    {
        $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'reclaim_form'; 
        $forms = Db::getInstance()->executeS($sql);

        return $forms;
    }





    public function getContent()
    {



        $output = '';

        // Récupérer les formulaires depuis la base de données
        $forms = $this->getForms();

    
        // Afficher les formulaires dans votre vue d'administration
        foreach ($forms as $form) {
            $output .= 'ID: ' . $form['ID_reclaim'] . '<br>';
            $output .= 'Nom: ' . $form['name'] . '<br>';
            $output .= 'Prénom: ' . $form['surname'] . '<br>';
            $output .= 'Email: ' . $form['email'] . '<br>';
            $output .= 'Message: ' . $form['message'] . '<br>';
            $output .= '<hr>';
        }
    
        return $output;
    }


    public function hookDisplayFooter($params)
    {
        $this->context->smarty->assign([
            'page_name' => Configuration::get('RECLAMATIONS_PAGENAME'),
            'page_link' => $this->context->link->getModuleLink('reclamations', 'display')
        ]);

        return $this->display(__FILE__, 'reclamations.tpl');
    }

    public function hookDisplayLeftColumn($params)
    {
        $this->context->smarty->assign([
            'page_name' => Configuration::get('RECLAMATIONS_PAGENAME'),
            'page_link' => $this->context->link->getModuleLink('reclamations', 'display')
        ]);

        return $this->display(__FILE__, 'reclamations.tpl');
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->registerStylesheet(
            'reclamations',
            $this->_path.'views/css/reclamations.css',
            ['server' => 'remote', 'position' => 'head', 'priority' => 150]
        );
    }

    public function hookDisplayCustomerAccountForm($params) {

        //Affichage du template du module ( situé dans views/templates/hook )
        return $this->display(__FILE__, 'hookDisplayCustomerAccountForm.tpl');
    }

    public function hookActionCustomerAccountAdd($params)
    {
        //Gestion de l'upload via la classe d'upload prestashop

        
        $uploader = new Uploader('file_input'); //Renseigner ici le nom du fichier envoyés
        $uploader->setAcceptTypes($this->_registration_allowed_extensions)
                ->setCheckFileSize(UploaderCore::DEFAULT_MAX_SIZE)
                ->setSavePath(dirname(__FILE__) . '/' . $this->_upload_dir)
                ->process();

    }

    public $tabs = [
        [
            'name' => 'Reclaim forms', // One name for all langs
            'class_name' => 'AdminDashboard',
            'visible' => true,
            'parent_class_name' => 'AdminCatalog',
        ],
    ];



}