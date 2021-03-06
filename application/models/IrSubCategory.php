<?php

/**
 * IrSubCategory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 */
class IrSubCategory extends BaseIrSubCategory
{

    public function preDelete($event)
    {
        
        if (count($this->Incident) > 0) {
            throw new Fisma_Zend_Exception_User(
                'This sub-category can not be deleted because it is already associated with one or more incidents'
            );
        }

    }

}