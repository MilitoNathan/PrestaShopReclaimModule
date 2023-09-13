<?php 

class ReclaimForm extends ObjectModel
{
    /** @var int Reclaim ID */
    public $id;

    /** @var string name */
    public $name;

    /** @var string surname */
    public $surname;

    /** @var string e-mail */
    public $mail;

    /** @var string Message * */
    public $message;

    /** @var string ext_doc  **/
    public  $ext_doc;

    /** @var string path_doc **/
    public $path_doc;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'reclaim_form',
        'primary' => 'id_reclaim',
        'fields' => [
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isCustomerName', 'required' => true, 'size' => 255],
            'surname' => ['type' => self::TYPE_STRING, 'validate' => 'isCustomerName', 'required' => true, 'size' => 255],
            'mail' => ['type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 255],
            'message' => ['type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true, 'size' => 255],
            'ext_doc' => ['type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => false, 'size' => 255],
            'path_doc' => ['type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => false, 'size' => 255]
        ],
    ];
}