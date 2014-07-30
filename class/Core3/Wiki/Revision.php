<?php
namespace Core3\Wiki;

class Revision
{
    private $tblName = 'wikiRevision';
    var $id;
    var $revisionNumber;
    var $text;
    var $timeCreated;
    var $lockedBy;
    var $timeLocked;
    var $editedBy;
    var $timeEdited;
}
