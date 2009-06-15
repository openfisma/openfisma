<?php

/**
 * BaseSystem
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property enum $type
 * @property enum $confidentiality
 * @property enum $integrity
 * @property enum $availability
 * @property enum $visibility
 * @property Doctrine_Collection $Assets
 * @property Doctrine_Collection $Organization
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseSystem extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('system');
        $this->hasColumn('type', 'enum', null, array('type' => 'enum', 'values' => array(0 => 'gss', 1 => 'major', 2 => 'minor'), 'comment' => 'General Support System, Major Application, or Minor Application'));
        $this->hasColumn('confidentiality', 'enum', null, array('type' => 'enum', 'values' => array(0 => 'na', 1 => 'low', 2 => 'moderate', 3 => 'high'), 'comment' => 'The FIPS-199 confidentiality impact'));
        $this->hasColumn('integrity', 'enum', null, array('type' => 'enum', 'values' => array(0 => 'low', 1 => 'moderate', 2 => 'high'), 'comment' => 'The FIPS-199 integrity impact'));
        $this->hasColumn('availability', 'enum', null, array('type' => 'enum', 'values' => array(0 => 'low', 1 => 'moderate', 2 => 'high'), 'comment' => 'The FIPS-199 availability impact'));
        $this->hasColumn('visibility', 'enum', null, array('type' => 'enum', 'values' => array(0 => 'visible', 1 => 'hidden')));
    }

    public function setUp()
    {
        $this->hasMany('Asset as Assets', array('local' => 'id',
                                                'foreign' => 'systemId'));

        $this->hasMany('Organization', array('local' => 'id',
                                             'foreign' => 'systemId'));
    }
}