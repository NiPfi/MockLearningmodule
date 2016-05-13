<?php
include_once ("./Services/Repository/classes/class.ilObjectPluginGUI.php");
include_once("class.chapterHandler.php");
include_once("class.pageHandler.php");
include_once("class.userviewHandler.php");

/**
 * User Interface class for repository object.
 * ...
 * @ilCtrl_isCalledBy ilObjMockLearningmoduleGUI: ilRepositoryGUI, ilAdministrationGUI, ilObjPluginDispatchGUI
 * @ilCtrl_Calls ilObjMockLearningmoduleGUI: ilPermissionGUI, ilInfoScreenGUI, ilObjectCopyGUI, ilCommonActionDispatcherGUI
 */
class ilObjMockLearningmoduleGUI extends ilObjectPluginGUI
{

    public $chapterName;
    /**
     * Initialisation
     */
    protected function afterConstructor()
    {}
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
            case "showObjectPermissionSettingsSubtab": // list all commands that need write permission here
            case "showPermissionsOfUserSubtab":
            case "showOwnerSubtab":
            case "showSettingsSubtab":
            case "showQuestions":
            case "showStyleSubtab":
            case "showMenuSubtab":
            case "showGlossariesSubtab":
            case "showMultilinguismSubtab":
            case "showMetadataSubtab":
            case "showChapterMetadataSubtab":
            case "showChapterPreconditionsSubtab":
            case "showChapterSubchaptersSubtab":
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
            case "showStatisticSubtab":
            case "showBlockedUsersSubtab":
            case "showInfo":
            case "showInfoSubtab":
            case "showInfoHistorySubtab":
            case "showChapter1":
            case "showChapter2":
            case "showSubchapter1":
            case "showPage1":
            case "showPage2":
            case "showPage3":
            case "showPage4":
            case "showPage5":

                $this->checkPermission("write");
                $this->$cmd();
                break;

            // list all commands that need read permission here
            case "showUserView":
            case "showUserInfoTab":
            case "showContentTab":
            case "showTableOfContentsTab":
            case "showPrintViewTab":
            case "showUserViewPage1":
            case "showUserViewPage2":
            case "showUserViewPage3":
            case "showUserViewPage4":
            case "showUserViewPage5":

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
        return "showUserViewPage1";
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

        if ($ilAccess->checkAccess("write", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("permissions", "Permissions",
                $ilCtrl->getLinkTarget($this, showObjectPermissionSettingsSubtab));
        }
    }

    private function setTemplateDescription()
    {
        global $tpl, $ilCtrl;
        $desc = $this->object->getDescription();
        $desc .= "<br> <a id='statusDesc' style='color: #fa8228' onclick='changeOnlineStatusModal();'>Status: Offline</a>";
        $desc .= $this->userViewButton();
        $tpl->setDescription( $desc);
    }


    private function userViewButton()
    {    global $ilCtrl;
        $userviewHander = new userviewHandler();
        return $button = "<a style='margin-right: 5px; height: 26px;' id='switchMode' href="
        . $ilCtrl->getLinkTarget($this, $userviewHander->userViewLink($this->ctrl->getCmd())) . "\""
            . " class=\"btn btn-default\" role=\"button\">
            <span class=\"glyphicon glyphicon-eye-open\"></span>
            <span id=\"editModetxt\" class=\"\"> User Mode</span></a>";
    }

    private function editViewButton()
    {    global $ilCtrl;
        $userviewHander = new userviewHandler();
        return $button = "<a style='margin-right: 5px; height: 26px;' id='switchMode' href="
            . $ilCtrl->getLinkTarget($this, $userviewHander->adminViewLink($this->ctrl->getCmd())) . "\""
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
        $this->addHeaderAction();

    }

    function showChapterSubtab()
    {
        global $tpl, $ilTabs, $ilCtrl;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_content_chapters.html",false,false);
        $my_tpl->setVariable("CHAP1_LINK",$ilCtrl->getLinkTarget($this, "showChapter1"));
        $my_tpl->setVariable("CHAP2_LINK",$ilCtrl->getLinkTarget($this, "showChapter2"));
        $my_tpl->setVariable("PAGE1_LINK", $ilCtrl->getLinkTarget($this, "showPage1"));
        $my_tpl->setVariable("PAGE2_LINK", $ilCtrl->getLinkTarget($this, "showPage2"));
        $my_tpl->setVariable("PAGE3_LINK", $ilCtrl->getLinkTarget($this, "showPage3"));
        $my_tpl->setVariable("PAGE4_LINK", $ilCtrl->getLinkTarget($this, "showPage4"));
        $my_tpl->setVariable("PAGE5_LINK", $ilCtrl->getLinkTarget($this, "showPage5"));

        $my_tpl->setVariable("SUBCHAP1_LINK", $ilCtrl->getLinkTarget($this, "showSubchapter1"));

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
        $this->addHeaderAction();
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
        $this->addHeaderAction();
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

        $my_tpl->setVariable("PAGE1_LINK", $ilCtrl->getLinkTarget($this, "showPage1"));
        $my_tpl->setVariable("PAGE2_LINK", $ilCtrl->getLinkTarget($this, "showPage2"));
        $my_tpl->setVariable("CHP1_LINK", $ilCtrl->getLinkTarget($this, "showChapter1"));
        $my_tpl->setVariable("CHP2_LINK", $ilCtrl->getLinkTarget($this, "showChapter2"));
        $my_tpl->setVariable("SUBCHP_LINK", $ilCtrl->getLinkTarget($this, "showSubchapter1"));
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
        $this->addHeaderAction();
    }

    function showSettingsSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_settings_settings.html",false,false);
        $my_tpl->setVariable("DESCRIPTION", $this->object->getDescription());
        $my_tpl->setVariable("TITLE", $this->object->getTitle());
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
        $my_tpl->setVariable("TITLE", $this->object->getTitle());
        $this->generateSettingSubtabs();
        $ilTabs->activateSubtab("metadataSubtab");
        $tpl->setContent($my_tpl->get());
    }

    /*
     *  Permissions
     */

    function generatePermissionsSubtabs()
    {
        global $ilTabs, $ilCtrl;
        $ilTabs->activateTab("permissions");
        $ilTabs->addSubTab("objectPermissionSettingsSubtab","Object Permission Settings",  $ilCtrl->getLinkTarget($this, "showObjectPermissionSettingsSubtab"));
        $ilTabs->addSubTab("permissionsOfUserSubtab","Permissions of User",  $ilCtrl->getLinkTarget($this, "showPermissionsOfUserSubtab"));
        $ilTabs->addSubTab("ownerSubtab","Owner",  $ilCtrl->getLinkTarget($this, "showOwnerSubtab"));
        $this->addHeaderAction();
    }

    function showObjectPermissionSettingsSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_permissions_objectPermissionSettings.html",false,false);
        $my_tpl->setVariable("DESCRIPTION", $this->object->getDescription());
        $this->generatePermissionsSubtabs();
        $ilTabs->activateSubtab("objectPermissionSettingsSubtab");

        $tpl->setContent($my_tpl->get());
    }

    function showPermissionsOfUserSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_permissions_permissionsOfUser.html",false,false);
        $my_tpl->setVariable("DESCRIPTION", $this->object->getDescription());
        $this->generatePermissionsSubtabs();
        $ilTabs->activateSubtab("permissionsOfUserSubtab");

        $tpl->setContent($my_tpl->get());
    }

    function showOwnerSubtab()
    {
        global $tpl, $ilTabs;

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_permissions_owner.html",false,false);
        $my_tpl->setVariable("DESCRIPTION", $this->object->getDescription());
        $this->generatePermissionsSubtabs();
        $ilTabs->activateSubtab("ownerSubtab");

        $tpl->setContent($my_tpl->get());
    }


    /*Chapter Edit */

    function showChapter1() {
        $_SESSION["chapter"] = "Chapter 1";
        $this->showChapterSubchaptersSubtab();
    }

    function showChapter2() {
        $_SESSION["chapter"] = "Chapter 2";
        $this->showChapterSubchaptersSubtab();
    }

    function  showSubchapter1() {
        $_SESSION["chapter"] = "Subchapter 1.1";
        $this->showChapterSubchaptersSubtab();
    }



    function generateChapterSubtabs()
    {
        global $ilTabs, $ilCtrl, $tpl;
        $tpl->setTitleIcon("./templates/default/images/icon_st.svg", "chapter");
        $tpl->setDescription($this->userViewButton());
        $chapter = $_SESSION["chapter"];
        $tpl->setTitle($chapter);
        $ilTabs->activateTab("chapter");
        $ilTabs->addSubTab("chapterSubchaptersSubtab","Subchapter and Pages",  $ilCtrl->getLinkTarget($this, "showChapterSubchaptersSubtab"));
        $ilTabs->addSubTab("chapterPreconditionsSubtab","Preconditions",  $ilCtrl->getLinkTarget($this, "showChapterPreconditionsSubtab"));
        $ilTabs->addSubTab("chapterMetadataSubtab","Metadata",  $ilCtrl->getLinkTarget($this, "showChapterMetadataSubtab"));
    }

    function showChapter()
    {
        $this->showChapterSubchaptersSubtab(); //Standard tab for chapter
    }


    function generateChapterTabs()
    {
        global $tpl, $ilTabs, $ilCtrl, $ilAccess;
        $ilTabs->clearTargets();
        $chapter =  $_SESSION["chapter"];
        $chapterHandler = new chapterHandler();
        $backObj = $chapterHandler->parentName($chapter);
        $backCmd = $chapterHandler->displayCommand($chapter);

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
        global $tpl, $ilTabs;
        $this->generateChapterTabs();
        $this->generateChapterSubtabs();
        $parentObjHandler = new chapterHandler();
        $ilTabs->activateSubtab("chapterSubchaptersSubtab");
        $tpl->setContent($parentObjHandler->subchapterTemplate($_SESSION["chapter"]));
    }

    function showChapterPreconditionsSubtab()
    {
        global $tpl, $ilTabs;
        $this->generateChapterTabs();
        $this->generateChapterSubtabs();
        $ilTabs->activateSubtab("chapterPreconditionsSubtab");
        $parentObjHandler = new chapterHandler();
        $tpl->setContent($parentObjHandler->preconditionTemplate($_SESSION["chapter"]));
    }

    function showChapterMetadataSubtab()
    {
        global $tpl, $ilTabs;
        $this->generateChapterTabs();
        $this->generateChapterSubtabs();
        $ilTabs->activateSubtab("chapterMetadataSubtab");
        $parentObjHandler = new chapterHandler();
        $tpl->setContent($parentObjHandler->metadataTemplate($_SESSION["chapter"]));
    }

    /*
     * Page Edit
     */

    function showPage1()
    {
        $_SESSION["page"] = "Page 1";
        $this->showEditSubtab(); //Standard tab for page
    }

    function showPage2()
    {
        $_SESSION["page"] = "Page 2";
        $this->showEditSubtab(); //Standard tab for page
    }

    function showPage3()
    {
        $_SESSION["page"] = "Page 3";
        $this->showEditSubtab(); //Standard tab for page
    }

    function showPage4()
    {
        $_SESSION["page"] = "Page 4";
        $this->showEditSubtab(); //Standard tab for page
    }

    function showPage5()
    {
        $_SESSION["page"] = "Page 5";
        $this->showEditSubtab(); //Standard tab for page
    }

    function generatePageSubtabs()
    {
        global $ilTabs, $ilCtrl, $tpl;
        $tpl->setTitleIcon("./templates/default/images/icon_pg.svg", "page");
        $tpl->setDescription($this->userViewButton());
        $tpl->setTitle($_SESSION["page"]);
        $ilTabs->activateTab("page");
        $ilTabs->addSubTab("editSubtab","Edit",  $ilCtrl->getLinkTarget($this, "showEditSubtab"));
        $ilTabs->addSubTab("previewSubtab","Preview",  $ilCtrl->getLinkTarget($this, "showPreviewSubtab"));
        $ilTabs->addSubTab("pageMetadataSubtab","Metadata",  $ilCtrl->getLinkTarget($this, "showPageMetadataSubtab"));
        $ilTabs->addSubTab("historySubtab","History",  $ilCtrl->getLinkTarget($this, "showHistorySubtab"));
        $ilTabs->addSubTab("ClipboardSubtab","Clipboard",  $ilCtrl->getLinkTarget($this, "showClipboardSubtab"));
        $ilTabs->addSubTab("activationSubtab","Activation",  $ilCtrl->getLinkTarget($this, "showActivationSubtab"));
    }


    function generatePageTabs()
    {
        global $tpl, $ilTabs, $ilCtrl, $ilAccess;
        $ilTabs->clearTargets();
        $pageHandler = new pageHandler();

        if ($ilAccess->checkAccess("read", "", $this->object->getRefId()))
        {
            $ilTabs->addTab("backToChapter", "<span class=\"glyphicon glyphicon-chevron-left\"::before></span> Chapter",
                $ilCtrl->getLinkTarget($this, $pageHandler->displayCommand($_SESSION["page"])));
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
        $pageHandler = new pageHandler();
        $tpl->setContent($pageHandler->editTemplate($_SESSION["page"]));
    }

    function showPreviewSubtab()
    {
        global $tpl, $ilTabs;
        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("previewSubtab");
        $pageHandler = new pageHandler();
        $tpl->setContent($pageHandler->previewTemplate($_SESSION["page"]));
    }

    function showPageMetadataSubtab()
    {
        global $tpl, $ilTabs;
        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("pageMetadataSubtab");
        $pageHandler = new pageHandler();
        $tpl->setContent($pageHandler->metadataTemplate($_SESSION["page"]));
    }

    function showHistorySubtab()
    {
        global $tpl, $ilTabs;
        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("historySubtab");
        $pageHandler = new pageHandler();
        $tpl->setContent($pageHandler->historyTemplate($_SESSION["page"]));
    }

    function showClipboardSubtab()
    {
        global $tpl, $ilTabs;
        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("ClipboardSubtab");
        $pageHandler = new pageHandler();
        $tpl->setContent($pageHandler->clipboardTemplate($_SESSION["page"]));
    }

    function showActivationSubtab()
    {
        global $tpl, $ilTabs;
        $this->generatePageTabs();
        $this->generatePageSubtabs();
        $ilTabs->activateSubtab("activationSubtab");
        $pageHandler = new pageHandler();
        $tpl->setContent($pageHandler->activationTemplate($_SESSION["page"]));
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
        $this->addHeaderAction();
    }

    function showUserView()
    {
        $this->showUserViewPage1();
    }

    function  showUserViewPage1() {
        $_SESSION["userview"] = "Page1";
        $this->showContentTab();
    }

    function  showUserViewPage2() {
        $_SESSION["userview"] = "Page2";
        $this->showContentTab();
    }

    function  showUserViewPage3() {
        $_SESSION["userview"] = "Page3";
        $this->showContentTab();
    }

    function  showUserViewPage4() {
        $_SESSION["userview"] = "Page4";
        $this->showContentTab();
    }

    function  showUserViewPage5() {
        $_SESSION["userview"] = "Page5";
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
        $userviewHander = new userviewHandler();
        $this->hideNonUserInfo();
        $this->generateUserViewTabs();
        $ilTabs->activateTab("contentTab");
        $tpl->setContent($userviewHander->pageTemplate($_SESSION["userview"]));
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
        $ilTabs->activateTab("printViewTab");
        $tpl->setContent($my_tpl->get());
    }

    function showUserInfoTab()
    {
        global $tpl, $ilTabs;
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_info.html",false,false);
        $my_tpl->setVariable("DESC", $this->object->getDescription());
        $this->hideNonUserInfo();
        $this->generateUserViewTabs();
        $ilTabs->activateTab("userInfoTab");
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
	    $tpl->addInlineCss("@media (max-width: 767px) {
	        #editModetxt{display: none;}
	    }");
    }

}