<?php

/**
 * BaseUpload
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property timestamp $createdTs
 * @property string $fileName
 * @property integer $userId
 * @property User $User
 * @property Doctrine_Collection $Findings
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseUpload extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('upload');
        $this->hasColumn('createdTs', 'timestamp', null, array('type' => 'timestamp'));
        $this->hasColumn('fileName', 'string', 255, array('type' => 'string', 'extra' => array('purify' => 'plaintext'), 'comment' => 'Name of the uploaded file', 'length' => '255'));
        $this->hasColumn('userId', 'integer', null, array('type' => 'integer', 'comment' => 'Foreign key to the user who uploaded this file'));
    }

    public function setUp()
    {
        $this->hasOne('User', array('local' => 'userId',
                                    'foreign' => 'id'));

        $this->hasMany('Finding as Findings', array('local' => 'id',
                                                    'foreign' => 'uploadId'));

        $timestampable0 = new Doctrine_Template_Timestampable(array('created' => array('name' => 'createdTs', 'type' => 'timestamp')));
        $this->actAs($timestampable0);

    $this->addListener(new XssListener(), 'XssListener');
    }
}