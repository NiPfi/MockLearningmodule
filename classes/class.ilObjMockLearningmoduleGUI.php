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

            case "showSettingsSubtab":   // list all commands that need write permission here
            case "showQuestions":
            case "showSettingsSubtab":
            case "showStyleSubtab":
            case "showMenuSubtab":
            case "showGlossariesSubtab":
            case "showMultilinguismSubtab":
            case "showMetadataSubtab":

                $this->checkPermission("write");
                $this->$cmd();
                break;

            // list all commands that need read permission here
            case "showChapterSubtab":
            case "showAllPagesSubtab":
            case "showInternalLinksSubtab":
            case "showWeblinkCheckSubtab":
            case "showMediaSubtitlesSubtab":
            case "showImportSubtab":
            case "showExportSubtab":
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
        return "showChapterSubtab";
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
                $ilCtrl->getLinkTarget($this, "showChapterSubtab"));
        }

        // standard info screen tab
        $this->addInfoTab();

        if ($ilAccess->checkAccess("write", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("settings", $this->txt("settings"),
                $ilCtrl->getLinkTarget($this, "showSettingsSubtab"));
        }

        if ($ilAccess->checkAccess("write", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("questions", $this->txt("questions"),
                $ilCtrl->getLinkTarget($this, showQuestions));
        }

        // standard epermission tab
        $this->addPermissionTab();


    }

//
// Show content
//

    /**
     * Show content
     */
    function generateContentSubtabs()
    {
        global $ilTabs, $ilCtrl;
        $ilTabs->activateTab("content");
        $ilTabs->addSubTab("chapter","Chapter",  $ilCtrl->getLinkTarget($this, "showChapterSubtab"));
        $ilTabs->addSubTab("allPages","All Pages",  $ilCtrl->getLinkTarget($this, "showAllPagesSubtab"));
        $ilTabs->addSubTab("internalLinks","Internal Links",  $ilCtrl->getLinkTarget($this, "showInternalLinksSubtab"));
        $ilTabs->addSubTab("weblinkCheck","Weblink Check",  $ilCtrl->getLinkTarget($this, "showWeblinkCheckSubtab"));
        $ilTabs->addSubTab("mediaSubtitles","Media Subtitles",  $ilCtrl->getLinkTarget($this, "showMediaSubtitlesSubtab"));
        $ilTabs->addSubTab("import","Import",  $ilCtrl->getLinkTarget($this, "showImportSubtab"));
        $ilTabs->addSubTab("export","Export",  $ilCtrl->getLinkTarget($this, "showExportSubtab"));

    }


    function showChapterSubtab()
    {
        global $tpl, $ilTabs;

        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("chapter");
        $tpl->setContent("ChapterSubtab");
    }

    function showAllPagesSubtab()
    {
        global $tpl, $ilTabs;

        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("allPages");
        $tpl->setContent("allPages");
    }

    function showInternalLinksSubtab()
    {
        global $tpl, $ilTabs;

        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("internalLinks");
        $tpl->setContent("Internal Links");
    }

    function showWeblinkCheckSubtab()
    {
        global $tpl, $ilTabs;

        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("weblinkCheck");
        $tpl->setContent("Weblink Check");
    }

    function showMediaSubtitlesSubtab()
    {
        global $tpl, $ilTabs;

        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("mediaSubtitles");
        $tpl->setContent("Media Subtitles");
    }

    function showImportSubtab()
    {
        global $tpl, $ilTabs;

        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("import");
        $tpl->setContent("Import");
    }

    function showExportSubtab()
    {
        global $tpl, $ilTabs;

        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("export");
        $tpl->setContent("Export");
    }

    function showSettings()
    {
        global $tpl, $ilTabs;

        $ilTabs->activateTab("settings");

        $tpl->setContent("Settings");


    }

    function showQuestions()
    {
        global $tpl, $ilTabs;

        $ilTabs->activateTab("questions");

        $tpl->setContent("Questions");
    }
/*
 *Settings Tab
 */

    function generateSettingSubtabs()
    {
        global $ilTabs, $ilCtrl;
        $ilTabs->activateTab("settings");
        $ilTabs->addSubTab("settingsSubtab","Settings",  $ilCtrl->getLinkTarget($this, "showShowSubtab"));
        $ilTabs->addSubTab("stlyeSubtab","Stlye",  $ilCtrl->getLinkTarget($this, "showStyleSubtab"));
        $ilTabs->addSubTab("menuSubtab","Menu",  $ilCtrl->getLinkTarget($this, "showMenuSubtab"));
        $ilTabs->addSubTab("glossariesSubtab","Glossaries",  $ilCtrl->getLinkTarget($this, "showGlossariesSubtab"));
        $ilTabs->addSubTab("multilinguismSubtab","Multilinguism",  $ilCtrl->getLinkTarget($this, "showMultilinguismSubtab"));
        $ilTabs->addSubTab("metadataSubtab","Metadata",  $ilCtrl->getLinkTarget($this, "showMetadataSubtab"));

    }

    function showSettingsSubtab()
    {
        global $tpl, $ilTabs;
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("settingsSubtab");

        $tpl->setContent("Settings");
    }

    function showStyleSubtab()
    {
        global $tpl, $ilTabs;
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("styletingsSubtab");

        $tpl->setContent("Style");
    }

    function showMenuSubtab()
    {
        global $tpl, $ilTabs;
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("menuSubtab");

        $tpl->setContent("Menu");
    }

    function showGlossariesSubtab()
    {
        global $tpl, $ilTabs;
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("glossariesSubtab");
        $tpl->setContent("Glossaries");
    }

    function showMultilinguismSubtab()
    {
        global $tpl, $ilTabs;
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("multilinguismSubtab");
        $tpl->setContent("Multilinguism");
    }


    function showMetadataSubtab()
    {
        global $tpl, $ilTabs;
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("metadataSubtab");
        $tpl->setContent("Metadata");
    }
}