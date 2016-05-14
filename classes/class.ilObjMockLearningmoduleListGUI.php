<?php

include_once "./Services/Repository/classes/class.ilObjectPluginListGUI.php";

class ilObjMockLearningmoduleListGUI extends ilObjectPluginListGUI
{
    /**
     * Init type
     */
    function initType()
    {
        $this->setType("xmlm");
    }

    /**
     * Get name of gui class handling the commands
     */
    function getGuiClass()
    {
        return "ilObjMockLearningmoduleGUI";
    }

    /**
     * Get commands
     */
    function initCommands()
    {
        return array
        (
            array(
                "permission" => "read",
                "cmd" => "showUserViewPage1",
                "default" => true),
            array(
                "permission" => "write",
                "cmd" => "showChapterSubtab",
                "txt" => $this->txt("edit"),
                "default" => false),
        );
    }

    /**
     * Get item properties
     *
     * @return        array                array of property arrays:
     *                                "alert" (boolean) => display as an alert property (usually in red)
     *                                "property" (string) => property name
     *                                "value" (string) => property value
     */
    function getProperties()
    {
        global $lng, $ilUser;

        $props = array();

        $this->plugin->includeClass("class.ilObjMockLearningmoduleAccess.php");
        if (!ilObjMockLearningmoduleAccess::checkOnline($this->obj_id))
        {
            $props[] = array("alert" => true, "property" => $this->txt("status"),
                "value" => $this->txt("offline"));
        }

        return $props;
    }
}