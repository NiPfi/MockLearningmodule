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


}