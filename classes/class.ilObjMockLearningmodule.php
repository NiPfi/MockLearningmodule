<?php

include_once ("./Services/Repository/classes/class.ilObjectPlugin.php");

class ilObjMockLearningmodule extends ilObjectPlugin
{

    function __construct($a_ref_id = 0)
    {
        parent::__construct($a_ref_id);
    }

    final function initType()
    {
        $this->setType("xmlm");
    }
}
