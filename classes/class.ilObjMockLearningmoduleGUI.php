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
	    $this->showTree($cmd);

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
            case "showSubchaptersSubtab":
            case "showChapterSubtab":
            case "showAllPagesSubtab":
            case "showInternalLinksSubtab":
            case "showWeblinkCheckSubtab":
            case "showMediaSubtitlesSubtab":
            case "showImportSubtab":
            case "showExportSubtab":
            case "showQuestions":
            case "showStatisticSubtab":
            case "showBlockedUsersSubtab":
            case "showInfo":
            case "showInfoSubtab":
            case "showInfoHistorySubtab":

                $this->checkPermission("write");
                $this->$cmd();
                break;

            // list all commands that need read permission here
            case "showUserView":
            case "showUserInfoSubtab":
            case "showContentSubtab":
            case "showTableOfContentsSubtab":
            case "showPrintViewSubtab":


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
            return "showChapterSubtab";
    }

    /**
     * Get standard command
     */
    function getStandardCmd()
    {
        global $ilAccess;
        if ($ilAccess->checkAccess("write", "", $this->object->getRefId()))
        {
            return "showChapterSubtab";
        }
        return "showContentSubtab";
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
        $this->setTemplateDescription();
        
        // tab for the "show content" command
        if ($ilAccess->checkAccess("write", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("content", $this->txt("content"),
                $ilCtrl->getLinkTarget($this, "showChapterSubtab"));
        }

        if ($ilAccess->checkAccess("write", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("info", "Info",
                $ilCtrl->getLinkTarget($this, "showInfo"));
        }

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

        // standard permission tab
        $this->addPermissionTab();
    }

    private function setTemplateDescription()
    {
        global $tpl, $ilCtrl;
        $desc = $this->object->getDescription();
        $desc .= "<br> <span style='color: #00aa00'>Status: online</span>";
        $desc .= $this->userViewButton();
        $tpl->setDescription( $desc);
    }


    private function userViewButton()
    {    global $ilCtrl;
        return $button = "<a style='float: right;' href="
        . $ilCtrl->getLinkTarget($this, "showUserView") . "\""
            . " class=\"btn btn-default\" role=\"button\">
            <span class=\"glyphicon glyphicon-pencil\"></span>
            <span id=\"editModetxt\" class=\"\"> Edit Mode</span></a>";
    }

    private function editViewButton()
    {    global $ilCtrl;
        return $button = "<a style='float: right;' href="
            . $ilCtrl->getLinkTarget($this, "showChapterSubtab") . "\""
            . " class=\"btn btn-default\" role=\"button\">
            <span class=\"glyphicon glyphicon-eye-open\"></span>
            <span id=\"usersModetxt\"> Users Mode</span></a>";
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
        $ilTabs->activateSubTab("chapterSubtab");
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

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_content_mediaSubtitles.html",false,false);
        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("mediaSubtitles");
        $tpl->setContent($my_tpl->get());
    }

    function showImportSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_content_import.html",false,false);
        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("import");
        $tpl->setContent($my_tpl->get());
    }

    function showExportSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_content_export.html",false,false);
        $this->generateContentSubtabs();
        $ilTabs->activateSubTab("export");
        $tpl->setContent($my_tpl->get());
    }

    function showSettings()
    {
        global $tpl, $ilTabs;

        $ilTabs->activateTab("settings");

        $tpl->setContent("Settings");

    }

/*
* Questions Tab
*/

    function showQuestions()
    {
        $this->showStatisticSubtab();
    }

    function generateQuestionsSubtabs()
    {
        global $ilTabs, $ilCtrl;
        $ilTabs->activateTab("questions");
        $ilTabs->addSubTab("statisticSubtab","Statistic",  $ilCtrl->getLinkTarget($this, "showStatisticSubtab"));
        $ilTabs->addSubTab("blockedUsersSubtab","Blocked Users",  $ilCtrl->getLinkTarget($this, "showBlockedUsersSubtab"));
    }

    function showStatisticSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_questions_statistics.html",false,false);

        $this->generateQuestionsSubtabs();
        $ilTabs->activateSubtab("statisticSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showBlockedUsersSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_questions_blockedUsers.html",false,false);

        $this->generateQuestionsSubtabs();
        $ilTabs->activateSubtab("blockedUsersSubtab");
        $tpl->setContent($my_tpl->get());
    }

    /*
     * Info Tab
     */

    function showInfo(){
        $this->showInfoSubtab();
    }

    function generateInfoSubtabs()
    {
        global $ilTabs, $ilCtrl;
        $ilTabs->activateTab("info");
        $ilTabs->addSubTab("infoSubtab","Info",  $ilCtrl->getLinkTarget($this, "showInfoSubtab"));
        $ilTabs->addSubTab("infoHistorySubtab","History",  $ilCtrl->getLinkTarget($this, "showInfoHistorySubtab"));
    }

    function showInfoSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_info_info.html",false,false);
        $my_tpl->setVariable("DESCRIPTION", $this->object->getDescription());

        $this->generateInfoSubtabs();
        $ilTabs->activateSubtab("infoSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showInfoHistorySubtab()
    {
        global $tpl, $ilTabs, $ilCtrl;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_info_history.html",false,false);

        $my_tpl->setVariable("PAGE1_LINK", $ilCtrl->getLinkTarget($this, "showPage"));
        $this->generateInfoSubtabs();
        $ilTabs->activateSubtab("infoHistorySubtab");
        $tpl->setContent($my_tpl->get());
    }

/*
 *Settings Tab
 */

    function generateSettingSubtabs()
    {
        global $ilTabs, $ilCtrl;
        $ilTabs->activateTab("settings");
        $ilTabs->addSubTab("settingsSubtab","Settings",  $ilCtrl->getLinkTarget($this, "showSettingsSubtab"));
        $ilTabs->addSubTab("stlyeSubtab","Stlye",  $ilCtrl->getLinkTarget($this, "showStyleSubtab"));
        $ilTabs->addSubTab("menuSubtab","Menu",  $ilCtrl->getLinkTarget($this, "showMenuSubtab"));
        $ilTabs->addSubTab("glossariesSubtab","Glossaries",  $ilCtrl->getLinkTarget($this, "showGlossariesSubtab"));
        $ilTabs->addSubTab("multilinguismSubtab","Multilinguism",  $ilCtrl->getLinkTarget($this, "showMultilinguismSubtab"));
        $ilTabs->addSubTab("metadataSubtab","Metadata",  $ilCtrl->getLinkTarget($this, "showMetadataSubtab"));

    }

    function showSettingsSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_settings_settings.html",false,false);
        $my_tpl->setVariable("DESCRIPTION", $this->object->getDescription());
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("settingsSubtab");

        $tpl->setContent($my_tpl->get());
    }

    function showStyleSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_settings_style.html",false,false);
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("stlyeSubtab");

        $tpl->setContent($my_tpl->get());
    }

    function showMenuSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_settings_menu.html",false,false);
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("menuSubtab");

        $tpl->setContent($my_tpl->get());
    }

    function showGlossariesSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_settings_glossaries.html",false,false);
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("glossariesSubtab");

        $tpl->setContent($my_tpl->get());
    }

    function showMultilinguismSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_settings_multilingualism.html",false,false);
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("multilinguismSubtab");
        $tpl->setContent($my_tpl->get());
    }


    function showMetadataSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_settings_metadata.html",false,false);
        $my_tpl->setVariable("DESCRIPTION", $this->object->getDescription());
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("metadataSubtab");
        $tpl->setContent($my_tpl->get());
    }

    /*Chapter Edit */

    function generateSubchapterSubtabs()
    {
        global $ilTabs, $ilCtrl, $tpl;
        $tpl->setTitleIcon("./templates/default/images/icon_st.svg", "chapter");
        $tpl->setDescription($this->userViewButton());
        $tpl->setTitle("Chapter 1");
        $ilTabs->activateTab("chapter");
        $ilTabs->addSubTab("subchapterSubtab","Subchapter and Pages",  $ilCtrl->getLinkTarget($this, "showSubchaptersSubtab"));
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
            $ilTabs->addTab("backToLearningModule", "<span class=\"glyphicon glyphicon-chevron-left\"::before></span> Learning Module",
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
        global $tpl, $ilTabs, $ilCtrl;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_chapter_subchaptersAndPages.html",false,false);
        $my_tpl->setVariable("PAGE1_LINK", $ilCtrl->getLinkTarget($this, "showPage"));

        $this->generateChapterTabs();
        $this->generateSubchapterSubtabs();
        $ilTabs->activateSubtab("subchapterSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showPreconditionsSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_chapter_preconditions.html",false,false);

        $this->generateChapterTabs();
        $this->generateSubchapterSubtabs();
        $ilTabs->activateSubtab("preconditionsSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showSubchapterMetadataSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_chapter_metadata.html",false,false);

        $this->generateChapterTabs();
        $this->generateSubchapterSubtabs();
        $ilTabs->activateSubtab("subchapterMetadataSubtab");
        $tpl->setContent($my_tpl->get());
    }

    /*
     * Page Edit
     */

    function generatePageSubtabs()
    {
        global $ilTabs, $ilCtrl, $tpl;
        $tpl->setTitleIcon("./templates/default/images/icon_pg.svg", "page");
        $tpl->setDescription($this->userViewButton());
        $tpl->setTitle("Page 1");
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
            $ilTabs->addTab("backToChapter", "<span class=\"glyphicon glyphicon-chevron-left\"::before></span> Chapter",
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
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_edit.html",false,false);

        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("editSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showPreviewSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_preview.html",false,false);

        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("previewSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showPageMetadataSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_metadata.html",false,false);

        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("pageMetadataSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showHistorySubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_history.html",false,false);

        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("historySubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showClipboardSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_clipboard.html",false,false);

        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("ClipboardSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showActivationSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_activation.html",false,false);

        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("activationSubtab");
        $tpl->setContent($my_tpl->get());
    }


    /*
     * Userview
     */

    function generateUserViewSubtabs()
    {
        global $ilTabs, $ilCtrl;
        $ilTabs->addSubTab("contentSubtab","Content",  $ilCtrl->getLinkTarget($this, "showContentSubtab"));
        $ilTabs->addSubTab("tableOfContentsSubtab","Table of Contents",  $ilCtrl->getLinkTarget($this, "showTableOfContentsSubtab"));
        $ilTabs->addSubTab("printViewSubtab","Print View",  $ilCtrl->getLinkTarget($this, "showPrintViewSubtab"));
        $ilTabs->addSubTab("userInfoSubtab","Info",  $ilCtrl->getLinkTarget($this, "showUserInfoSubtab"));
    }

    function showUserView()
    {
        $this->showContentSubtab();
    }

    function hideNonUserInfo()
    {
        global $ilTabs, $tpl;
        $ilTabs->clearTargets();
        $tpl->setDescription($this->object->getDescription() . $this->editViewButton());
    }

    function showContentSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_content.html",false,false);

        $this->hideNonUserInfo();
        $this->generateUserViewSubtabs();
        $ilTabs->activateSubtab("contentSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showTableOfContentsSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_tableOfContents.html",false,false);

        $this->hideNonUserInfo();
        $this->generateUserViewSubtabs();
        $ilTabs->activateSubtab("tableOfContentsSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showPrintViewSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_printView.html",false,false);

        $this->hideNonUserInfo();
        $this->generateUserViewSubtabs();
        $ilTabs->activateSubtab("printViewSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showUserInfoSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_info.html",false,false);

        $this->hideNonUserInfo();
        $this->generateUserViewSubtabs();
        $ilTabs->activateSubtab("userInfoSubtab");
        $tpl->setContent($my_tpl->get());
    }


    function showTree($cmd)
    {
	    // Navigational tree
	    include_once ("class.ilObjMockTree.php");

	    global $tpl, $ilCtrl;
	    $this->ctrl = $ilCtrl;
	    $this->tpl = $tpl;

	    $ilExplorer = new ilObjMockTree($this, $cmd);

	    $tpl->setLeftNavContent($ilExplorer->getHTML());
    }

}