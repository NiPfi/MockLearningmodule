<?php
include_once ("./Services/Repository/classes/class.ilObjectPluginGUI.php");
include_once("parentObjectHandler.php");

/**
 * User Interface class for repository object.
 * ...
 * @ilCtrl_isCalledBy ilObjMockLearningmoduleGUI: ilRepositoryGUI, ilAdministrationGUI, ilObjPluginDispatchGUI
 * @ilCtrl_Calls ilObjMockLearningmoduleGUI: ilPermissionGUI, ilInfoScreenGUI, ilObjectCopyGUI, ilCommonActionDispatcherGUI
 */
class ilObjMockLearningmoduleGUI extends ilObjectPluginGUI
{

    private $chapterName;
    /**
     * Initialisation
     */
    protected function afterConstructor()
    {
        $parentObjHandler = new parentObjectHandler();
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
            case "showChapter1":
            case "showChapterMetadataSubtab":
            case "showChapterPreconditionsSubtab":
            case "showChapterSubchaptersSubtab":
            case "showSubchapter":
            case "showSubchapterMetadataSubtab":
            case "showSubchapterPreconditionsSubtab":
            case "showSubchapterSubchaptersSubtab":
            case "showPage":
            case "showEditSubtab":
            case "showPreviewSubtab":
            case "showPageMetadataSubtab":
            case "showHistorySubtab":
            case "showClipboardSubtab":
            case "showActivationSubtab":
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
            case "showUserInfoTab":
            case "showContentTab":
            case "showTableOfContentsTab":
            case "showPrintViewTab":


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
        $desc .= "<br> <span style='color: #6ea03c'>Status: online</span>";
        $desc .= $this->userViewButton();
        $tpl->setDescription( $desc);
    }


    private function userViewButton()
    {    global $ilCtrl;
        return $button = "<a style='float: right;' href="
        . $ilCtrl->getLinkTarget($this, "showUserView") . "\""
            . " class=\"btn btn-default\" role=\"button\">
            <span class=\"glyphicon glyphicon-eye-open\"></span>
            <span id=\"editModetxt\" class=\"\"> User Mode</span></a>";
    }

    private function editViewButton()
    {    global $ilCtrl;
        return $button = "<a style='float: right;' href="
            . $ilCtrl->getLinkTarget($this, "showChapterSubtab") . "\""
            . " class=\"btn btn-default\" role=\"button\">
            <span class=\"glyphicon glyphicon-pencil\"></span>
            <span id=\"usersModetxt\"> Admin Mode</span></a>";
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
        $my_tpl->setVariable("CHAP1_LINK",$ilCtrl->getLinkTarget($this, "showChapter1"));
        $my_tpl->setVariable("PAGE1_LINK", $ilCtrl->getLinkTarget($this, "showPage"));
        $my_tpl->setVariable("SUBCHAP1_LINK", $ilCtrl->getLinkTarget($this, "showSubchapter"));

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



    function generateChapterSubtabs()
    {
        global $ilTabs, $ilCtrl, $tpl;
        $tpl->setTitleIcon("./templates/default/images/icon_st.svg", "chapter");
        $tpl->setDescription($this->userViewButton());
        $tpl->setTitle($this->chapterName);
        $ilTabs->activateTab("chapter");
        $ilTabs->addSubTab("chapterSubchaptersSubtab","Subchapter and Pages",  $ilCtrl->getLinkTarget($this, "showChapterSubchaptersSubtab"));
        $ilTabs->addSubTab("chapterPreconditionsSubtab","Preconditions",  $ilCtrl->getLinkTarget($this, "showChapterPreconditionsSubtab"));
        $ilTabs->addSubTab("chapterMetadataSubtab","Metadata",  $ilCtrl->getLinkTarget($this, "showChapterMetadataSubtab"));
    }

    function showChapter()
    {
        $this->showChapterSubchaptersSubtab(); //Standard tab for chapter
    }

    function showChapter1() {
        $this->chapterName = "Chapter 1";
        $this->showChapterSubchaptersSubtab();
    }

    function generateChapterTabs()
    {
        global $tpl, $ilTabs, $ilCtrl, $ilAccess;
        $ilTabs->clearTargets();
        $parentObjHandler = new parentObjectHandler();
        $backObj = $parentObjHandler->parentName($this->chapterName);
        $backCmd = $parentObjHandler->displayCommand($backObj);

        if ($ilAccess->checkAccess("read", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("back", "<span class=\"glyphicon glyphicon-chevron-left\"::before></span> $backObj",
                $ilCtrl->getLinkTarget($this, $backCmd));
        }

        if ($ilAccess->checkAccess("read", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("chapter", "Chapter",
                $ilCtrl->getLinkTarget($this, "showChapterSubchaptersSubtab"));
        }

    }

    function showChapterSubchaptersSubtab()
    {
        global $tpl, $ilTabs, $ilCtrl;
        $parentObjHandler = new parentObjectHandler();
        $my_tpl = new ilTemplate($parentObjHandler->subchapterTemplateDir($this->chapterName),false,false);
        $my_tpl->setVariable("PAGE1_LINK", $ilCtrl->getLinkTarget($this, "showPage"));
        $my_tpl->setVariable("SUBCHAP1_LINK", $ilCtrl->getLinkTarget($this, "showSubchapter"));

        $this->generateChapterTabs();
        $this->generateChapterSubtabs();
        $ilTabs->activateSubtab("chapterSubchaptersSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showChapterPreconditionsSubtab()
    {
        global $tpl, $ilTabs;
        $parentObjHandler = new parentObjectHandler();
        $my_tpl = new ilTemplate($parentObjHandler->preconditionTemplateDir($this->chapterName),false,false);

        $this->generateChapterTabs();
        $this->generateChapterSubtabs();
        $ilTabs->activateSubtab("chapterPreconditionsSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showChapterMetadataSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_chapter_metadata.html",false,false);

        $this->generateChapterTabs();
        $this->generateChapterSubtabs();
        $ilTabs->activateSubtab("chapterMetadataSubtab");
        $tpl->setContent($my_tpl->get());
    }

    /*
     * Subchapter Edit
     */

    function generateSubchapterSubtabs()
    {
        global $ilTabs, $ilCtrl, $tpl;
        $tpl->setTitleIcon("./templates/default/images/icon_st.svg", "chapter");
        $tpl->setDescription($this->userViewButton());
        $tpl->setTitle("Subchapter 1");
        $ilTabs->activateTab("subchapter");
        $ilTabs->addSubTab("subchapterSubtab","Subchapter and Pages",  $ilCtrl->getLinkTarget($this, "showSubchapterSubchaptersSubtab"));
        $ilTabs->addSubTab("subchapterPreconditionsSubtab","Preconditions",  $ilCtrl->getLinkTarget($this, "showSubchapterPreconditionsSubtab"));
        $ilTabs->addSubTab("subchapterMetadataSubtab","Metadata",  $ilCtrl->getLinkTarget($this, "showSubchapterMetadataSubtab"));
    }

    function showSubchapter()
    {
        $this->showSubchapterSubchaptersSubtab(); //Standard tab for chapter
    }

    function generateSubchapterTabs()
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
            $ilTabs->addTab("subchapter", "Subchapter",
                $ilCtrl->getLinkTarget($this, "showSubchapterSubchaptersSubtab"));
        }

    }

    function showSubchapterSubchaptersSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_subchapter_subchaptersAndPages.html",false,false);

        $this->generateSubchapterTabs();
        $this->generateSubchapterSubtabs();
        $ilTabs->activateSubtab("subchapterSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showSubchapterPreconditionsSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_subchapter_preconditions.html",false,false);

        $this->generateSubchapterTabs();
        $this->generateSubchapterSubtabs();
        $ilTabs->activateSubtab("subchapterPreconditionsSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showSubchapterMetadataSubtab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_subchapter_metadata.html",false,false);

        $this->generateSubchapterTabs();
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

    function generateUserViewTabs()
    {
        global $ilTabs, $ilCtrl;
        $ilTabs->addTab("contentTab","Content",  $ilCtrl->getLinkTarget($this, "showContentTab"));
        $ilTabs->addTab("tableOfContentsTab","Table of Contents",  $ilCtrl->getLinkTarget($this, "showTableOfContentsTab"));
        $ilTabs->addTab("printViewTab","Print View",  $ilCtrl->getLinkTarget($this, "showPrintViewTab"));
        $ilTabs->addTab("userInfoTab","Info",  $ilCtrl->getLinkTarget($this, "showUserInfoTab"));
    }

    function showUserView()
    {
        $this->showContentTab();
    }

    function hideNonUserInfo()
    {
        global $ilTabs, $tpl;
        $ilTabs->clearTargets();
        $tpl->setDescription($this->object->getDescription() . $this->editViewButton());
    }

    function showContentTab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_content.html",false,false);

        $this->hideNonUserInfo();
        $this->generateUserViewTabs();
        $ilTabs->activateTab("contentTab");
        $tpl->setContent($my_tpl->get());
    }

    function showTableOfContentsTab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_tableOfContents.html",false,false);

        $this->hideNonUserInfo();
        $this->generateUserViewTabs();
        $ilTabs->activateTab("tableOfContentsTab");
        $tpl->setContent($my_tpl->get());
    }

    function showPrintViewTab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_printView.html",false,false);

        $this->hideNonUserInfo();
        $this->generateUserViewTabs();
        $ilTabs->activateTab("printViewSubtab");
        $tpl->setContent($my_tpl->get());
    }

    function showUserInfoTab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_info.html",false,false);

        $this->hideNonUserInfo();
        $this->generateUserViewTabs();
        $ilTabs->activateTab("userInfoSubtab");
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