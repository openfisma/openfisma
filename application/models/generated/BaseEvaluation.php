<?php

/**
 * BaseEvaluation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $nickname
 * @property integer $nextId
 * @property integer $precedence
 * @property enum $approvalGroup
 * @property integer $eventId
 * @property integer $privilegeId
 * @property Evaluation $NextEvaluation
 * @property Event $Event
 * @property Privilege $Privilege
 * @property Doctrine_Collection $Finding
 * @property Doctrine_Collection $PreviousEvaluation
 * @property Doctrine_Collection $FindingEvaluations
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseEvaluation extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('evaluation');
        $this->hasColumn('name', 'string', null, array('type' => 'string', 'extra' => array('purify' => 'plaintext')));
        $this->hasColumn('nickname', 'string', null, array('type' => 'string', 'extra' => array('purify' => 'plaintext')));
        $this->hasColumn('nextId', 'integer', null, array('type' => 'integer', 'comment' => 'Relates to itself and points to the next Evaluation record'));
        $this->hasColumn('precedence', 'integer', null, array('type' => 'integer', 'comment' => 'The order in which this evaluation is positioned relative to the others in its group, starting at 0'));
        $this->hasColumn('approvalGroup', 'enum', null, array('type' => 'enum', 'values' => array(0 => 'action', 1 => 'evidence'), 'comment' => 'Which approval group this evaluation belongs to. "Action" is short for course of action and "evidence" refers to evidence artifacts.'));
        $this->hasColumn('eventId', 'integer', null, array('type' => 'integer'));
        $this->hasColumn('privilegeId', 'integer', null, array('type' => 'integer'));
    }

    public function setUp()
    {
        $this->hasOne('Evaluation as NextEvaluation', array('local' => 'nextId',
                                                            'foreign' => 'id'));

        $this->hasOne('Event', array('local' => 'eventId',
                                     'foreign' => 'id'));

        $this->hasOne('Privilege', array('local' => 'privilegeId',
                                         'foreign' => 'id'));

        $this->hasMany('Finding', array('local' => 'id',
                                        'foreign' => 'currentEvaluationId'));

        $this->hasMany('Evaluation as PreviousEvaluation', array('local' => 'id',
                                                                 'foreign' => 'nextId'));

        $this->hasMany('FindingEvaluation as FindingEvaluations', array('local' => 'id',
                                                                        'foreign' => 'evaluationId'));

    $this->addListener(new XssListener(), 'XssListener');
    }
}