<?php

/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 05.05.2016
 * Time: 17:11
 */
class userviewHandler
{

    public function pageTemplate($name)
    {
        global $ilCtrl;

        switch($name)
        {
            case "Page1":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_content.html",false,false);
                $my_tpl->setVariable("NEXT_PAGE", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showUserViewPage2"));
                break;
            case "Page2":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_content_page2.html",false,false);
                $my_tpl->setVariable("PREV_PAGE", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showUserViewPage1"));
                $my_tpl->setVariable("NEXT_PAGE", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showUserViewPage3"));
                break;
            case "Page3":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_content_page3.html",false,false);
                $my_tpl->setVariable("PREV_PAGE", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showUserViewPage2"));
                $my_tpl->setVariable("NEXT_PAGE", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showUserViewPage4"));
                break;
            case "Page4":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_content_page4.html",false,false);
                $my_tpl->setVariable("PREV_PAGE", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showUserViewPage3"));
                $my_tpl->setVariable("NEXT_PAGE", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showUserViewPage5"));
                break;
            case "Page5":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_presentationview_content_page5.html",false,false);
                $my_tpl->setVariable("PREV_PAGE", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showUserViewPage4"));
                break;
        }

        return $my_tpl->get();
    }


    public function adminViewLink($cmd)
    {
        switch($cmd)
        {
            case "showUserView":
            case "showUserInfoTab":
            case "showContentTab":
            case "showTableOfContentsTab":
            case "showPrintViewTab":
                if($_SESSION["userview"] == "Page1")
                    return "showPage1";
                if($_SESSION["userview"] == "Page2")
                    return "showPage2";
                if($_SESSION["userview"] == "Page3")
                    return "showPage3";
                if($_SESSION["userview"] == "Page4")
                    return "showPage4";
                if($_SESSION["userview"] == "Page5")
                    return "showPage5";

            case "showUserViewPage1":
                return "showPage1";
            case "showUserViewPage2":
                return "showPage2";
            case "showUserViewPage3":
                return "showPage3";
            case "showUserViewPage4":
                return "showPage4";
            case "showUserViewPage5":
                return "showPage5";
        }
    }

    public function userViewLink($cmd)
    {
        switch($cmd)
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
                return "showUserViewPage1";

            case "showChapterMetadataSubtab":
            case "showChapterPreconditionsSubtab":
            case "showChapterSubchaptersSubtab":
                if($_SESSION["page"] == "Page 1")
                    return "showUserViewPage1";
                if($_SESSION["page"] == "Page 2")
                    return "showUserViewPage2";
                if($_SESSION["page"] == "Page 3")
                    return "showUserViewPage3";


            case "showChapter1":
                return "showUserViewPage1";
            case "showChapter2":
                return "showUserViewPage5";
            case "showSubchapter1":
                return "showUserViewPage3";

            case "showEditSubtab":
            case "showPreviewSubtab":
            case "showPageMetadataSubtab":
            case "showHistorySubtab":
            case "showClipboardSubtab":
            case "showActivationSubtab":
                if($_SESSION["page"] == "Page 1")
                    return "showUserViewPage1";
                if($_SESSION["page"] == "Page 2")
                    return "showUserViewPage2";
                if($_SESSION["page"] == "Page 3")
                    return "showUserViewPage3";
                if($_SESSION["page"] == "Page 4")
                    return "showUserViewPage4";
                if($_SESSION["page"] == "Page 5")
                    return "showUserViewPage5";

            case "showPage1":
                return "showUserViewPage1";
            case "showPage2":
                return "showUserViewPage2";
            case "showPage3":
                return "showUserViewPage3";
            case "showPage4":
                return "showUserViewPage4";
            case "showPage5":
                return "showUserViewPage5";
        }
    }
}