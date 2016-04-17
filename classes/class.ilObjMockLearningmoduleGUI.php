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
            case "showChapter":
            case "showSubchapterMetadataSubtab":
            case "showPreconditionsSubtab":
            case "showSubchapterSubtab":
            case "showPage":
            case "showEditSubtab":
            case "showPreviewSubtab":
            case "showPageMetadataSubtab":
            case "showHistorySubtab":
            case "showClipboardSubtab":
            case "showActivationSubtab":



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
        $ilTabs->addSubTab("chapterSubtab","Chapter",  $ilCtrl->getLinkTarget($this, "showChapterSubtab"));
        $ilTabs->addSubTab("allPages","All Pages",  $ilCtrl->getLinkTarget($this, "showAllPagesSubtab"));
        $ilTabs->addSubTab("internalLinks","Internal Links",  $ilCtrl->getLinkTarget($this, "showInternalLinksSubtab"));
        $ilTabs->addSubTab("weblinkCheck","Weblink Check",  $ilCtrl->getLinkTarget($this, "showWeblinkCheckSubtab"));
        $ilTabs->addSubTab("mediaSubtitles","Media Subtitles",  $ilCtrl->getLinkTarget($this, "showMediaSubtitlesSubtab"));
        $ilTabs->addSubTab("import","Import",  $ilCtrl->getLinkTarget($this, "showImportSubtab"));
        $ilTabs->addSubTab("export","Export",  $ilCtrl->getLinkTarget($this, "showExportSubtab"));

    }



    function showChapterSubtab()
    {
        global $tpl, $ilTabs, $ilCtrl;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_content_chapters.html",false,false);
        $my_tpl->setVariable("CHAP1_LINK",$ilCtrl->getLinkTarget($this, "showChapter"));
        $my_tpl->setVariable("PAGE1_LINK", $ilCtrl->getLinkTarget($this, "showPage"));
        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("chapter");
        $tpl->setContent($my_tpl->get());
    }

    function showAllPagesSubtab()
    {
        global $tpl, $ilTabs, $ilCtrl;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_content_allPages.html",false,false);
        $my_tpl->setVariable("PAGE1_CHAP1_LINK", $ilCtrl->getLinkTarget($this, "showPage"));
        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("allPages");
        $tpl->setContent($my_tpl->get());
    }

    function showInternalLinksSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_content_internalLinks.html",false,false);
        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("internalLinks");
        $tpl->setContent($my_tpl->get());
    }

    function showWeblinkCheckSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_content_weblinkCheck.html",false,false);
        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("weblinkCheck");
        $tpl->setContent($my_tpl->get());
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

    /*Chapter Edit */

    function generateSubchapterSubtabs()
    {
        global $ilTabs, $ilCtrl;
        $ilTabs->activateTab("chapter");
        $ilTabs->addSubTab("subchapterSubtab","Subchaper and Pages",  $ilCtrl->getLinkTarget($this, "showSubChapterSubtab"));
        $ilTabs->addSubTab("preconditionsSubtab","Preconditions",  $ilCtrl->getLinkTarget($this, "showPreconditionsSubtab"));
        $ilTabs->addSubTab("subchapterMetadataSubtab","Metadata",  $ilCtrl->getLinkTarget($this, "showSubchapterMetadataSubtab"));
    }

    function showChapter()
    {
        $this->showSubchaptersSubtab(); //Standard tab for chapter
    }

    function generateChapterTabs()
    {
        global $tpl, $ilTabs, $ilCtrl, $ilAccess;
        $ilTabs->clearTargets();

        if ($ilAccess->checkAccess("read", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("backToLearningModule", "<- Learning Module",
                $ilCtrl->getLinkTarget($this, "showChapterSubtab"));
        }

        if ($ilAccess->checkAccess("read", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("chapter", "Chapter",
                $ilCtrl->getLinkTarget($this, "showSubchaptersSubtab"));
        }

    }

    function showSubchaptersSubtab()
    {
        global $tpl, $ilTabs;
        $this->generateChapterTabs();
        $this->generateSubchapterSubtabs();
        $ilTabs->activateSubtab("subchapterSubtab");
        $tpl->setContent("Subchaper and Pages Subtab");
    }

    function showPreconditionsSubtab()
    {
        global $tpl, $ilTabs;
        $this->generateChapterTabs();
        $this->generateSubchapterSubtabs();
        $ilTabs->activateSubtab("preconditionsSubtab");
        $tpl->setContent("Preconditions");
    }

    function showSubchapterMetadataSubtab()
    {
        global $tpl, $ilTabs;
        $this->generateChapterTabs();
        $this->generateSubchapterSubtabs();
        $ilTabs->activateSubtab("subchapterMetadataSubtab");
        $tpl->setContent("Metadata");
    }

    /*
     * Page Edit
     */

    function generatePageSubtabs()
    {
        global $ilTabs, $ilCtrl;
        $ilTabs->activateTab("page");
        $ilTabs->addSubTab("editSubtab","Edit",  $ilCtrl->getLinkTarget($this, "showEditSubtab"));
        $ilTabs->addSubTab("previewSubtab","Preview",  $ilCtrl->getLinkTarget($this, "showPreviewSubtab"));
        $ilTabs->addSubTab("pageMetadataSubtab","Metadata",  $ilCtrl->getLinkTarget($this, "showPageMetadataSubtab"));
        $ilTabs->addSubTab("historySubtab","History",  $ilCtrl->getLinkTarget($this, "showHistorySubtab"));
        $ilTabs->addSubTab("ClipboardSubtab","Clipboard",  $ilCtrl->getLinkTarget($this, "showClipboardSubtab"));
        $ilTabs->addSubTab("activationSubtab","Activation",  $ilCtrl->getLinkTarget($this, "showActivationSubtab"));
    }

    function showPage()
    {
        $this->showEditSubtab(); //Standard tab for page
    }

    function generatePageTabs()
    {
        global $tpl, $ilTabs, $ilCtrl, $ilAccess;
        $ilTabs->clearTargets();

        if ($ilAccess->checkAccess("read", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("backToChapter", "<- Chapter",
                $ilCtrl->getLinkTarget($this, "showChapter"));
        }

        if ($ilAccess->checkAccess("read", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("page", "Page",
                $ilCtrl->getLinkTarget($this, "showEditSubtab"));
        }

    }

    function showEditSubtab()
    {
        global $tpl, $ilTabs;
        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("editSubtab");
        $tpl->setContent("Edit");
    }

    function showPreviewSubtab()
    {
        global $tpl, $ilTabs;
        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("previewSubtab");
        $tpl->setContent("preview");
    }

    function showPageMetadataSubtab()
    {
        global $tpl, $ilTabs;
        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("pageMetadataSubtab");
        $tpl->setContent("Metadata");
    }

    function showHistorySubtab()
    {
        global $tpl, $ilTabs;
        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("historySubtab");
        $tpl->setContent("History");
    }

    function showClipboardSubtab()
    {
        global $tpl, $ilTabs;
        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("clipboardSubtab");
        $tpl->setContent("Clipboard");
    }

    function showActivationSubtab()
    {
        global $tpl, $ilTabs;
        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("activationSubtab");
        $tpl->setContent("Activation");
    }



}