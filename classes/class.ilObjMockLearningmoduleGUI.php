<?php

include_once ("./Services/Repository/classes/class.ilObjectPluginGUI.php");


/**
 * User Interface class for repository object.
 * ...
 * @ilCtrl_isCalledBy ilObjMockLearningmoduleGUI: ilRepositoryGUI, ilAdministrationGUI, ilObjPluginDispatchGUI
 * @ilCtrl_Calls ilObjMockLearningmoduleGUI: ilPermissionGUI, ilInfoScreenGUI, ilObjectCopyGUI, ilCommonActionDispatcherGUI
 */
class ilObjMockLearningmoduleGUI extends ilObjectPluginGUI
{
    /**
     * Initialisation
     */
    protected function afterConstructor()
    {
        // anything needed after object has been constructed
        // - example: append my_id GET parameter to each request
        //   $ilCtrl->saveParameter($this, array("my_id"));
    }

    /**
     * Get type.
     */
    final function getType()
    {
        return "xmlm";
    }

    /**
     * Handles all commmands of this class, centralizes permission checks
     */
    function performCommand($cmd)
    {
        switch ($cmd)
        {
            /*
            case "temporary fix":   // list all commands that need write permission here

                //case "...":
                $this->checkPermission("write");
                $this->$cmd();
                break; */

            case "showContent":   // list all commands that need read permission here
                //case "...":
                //case "...":
                $this->checkPermission("read");
                $this->$cmd();
                break;
        }
    }

    /**
     * After object has been created -> jump to this command
     */
    function getAfterCreationCmd()
    {
        return "showContent";
    }

    /**
     * Get standard command
     */
    function getStandardCmd()
    {
        return "showContent";
    }

//
// DISPLAY TABS
//

    /**
     * Set tabs
     */
    function setTabs()
    {
        global $ilTabs, $ilCtrl, $ilAccess;

        // tab for the "show content" command
        if ($ilAccess->checkAccess("read", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("content", $this->txt("content"),
                $ilCtrl->getLinkTarget($this, "showContent"));
        }

        // standard info screen tab
        $this->addInfoTab();


        // standard epermission tab
        $this->addPermissionTab();
    }

//
// Show content
//

    /**
     * Show content
     */
    function showContent()
    {
        global $tpl, $ilTabs;

        $ilTabs->activateTab("content");

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.test.html",false,false);
        $my_tpl->setVariable(BTN_TXT, "Test");
        $my_tpl->setVariable(BTN_LINK, "http://www.google.ch");

        $tpl->setContent($my_tpl->get());
    }

}