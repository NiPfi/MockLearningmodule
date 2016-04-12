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

    function doCreate()
    {
        global $ilDB;

        $ilDB->manipulate("INSERT INTO rep_robj_xmlm_data ".
            "(id, is_online) VALUES (".
            $ilDB->quote($this->getId(), "integer").",".
            $ilDB->quote(0, "integer").
            ")");
    }

    /**
     * Read data from db
     */
    function doRead()
    {
        global $ilDB;

        $set = $ilDB->query("SELECT * FROM rep_robj_xmlm_data ".
            " WHERE id = ".$ilDB->quote($this->getId(), "integer")
        );
        while ($rec = $ilDB->fetchAssoc($set))
        {
            $this->setOnline($rec["is_online"]);
        }
    }

    /**
     * Update data
     */
    function doUpdate()
    {
        global $ilDB;

        $ilDB->manipulate($up = "UPDATE rep_robj_xmlm_data SET ".
            " is_online = ".$ilDB->quote($this->getOnline(), "integer").",".
            " WHERE id = ".$ilDB->quote($this->getId(), "integer")
        );
    }

    /**
     * Delete data from db
     */
    function doDelete()
    {
        global $ilDB;

        $ilDB->manipulate("DELETE FROM rep_robj_xmlm_data WHERE ".
            " id = ".$ilDB->quote($this->getId(), "integer")
        );

    }

    /**
     * Do Cloning
     */
    function doClone($a_target_id,$a_copy_id,$new_obj)
    {
        global $ilDB;

        $new_obj->setOnline($this->getOnline());
        $new_obj->update();
    }

    /**
     * Set online
     *
     * @param	boolean		online
     */
    function setOnline($a_val)
    {
        $this->online = $a_val;
    }

    /**
     * Get online
     *
     * @return	boolean		online
     */
    function getOnline()
    {
        return $this->online;
    }



}
