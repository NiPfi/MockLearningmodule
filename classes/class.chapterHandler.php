<?php

/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 29.04.2016
 * Time: 13:24
 */
class chapterHandler
{

    public function parentName($name)
    {
        switch($name)
        {
            case "Chapter 1":
            case "Chapter 2":
                return "Learning Module";

            case "Subchapter 1.1":
                return "Overlying Chapter";

        }
    }

    public function displayCommand($name) {

        switch($name)
        {
            case "Chapter 1":
            case "Chapter 2":
                return "showChapterSubtab";
            case "Subchapter 1.1":
                return "showChapter1";
        }
    }

    public function subchapterTemplate($name)
    {
        global $ilCtrl;
        switch($name)
        {
            case "Chapter 1":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_chapter_subchaptersAndPages.html",false,false);
                $my_tpl->setVariable("PAGE1_LINK", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showPage1"));
                $my_tpl->setVariable("PAGE2_LINK", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showPage2"));
                $my_tpl->setVariable("SUBCHAP1_LINK", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showSubchapter1"));
                break;
            case "Chapter 2":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_chapter2_subchaptersAndPages.html",false,false);
                $my_tpl->setVariable("PAGE5_LINK", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showPage5"));
                break;
            case "Subchapter 1.1":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_subchapter_subchaptersAndPages.html",false,false);
                $my_tpl->setVariable("PAGE3_LINK", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showPage3"));
                $my_tpl->setVariable("PAGE4_LINK", $ilCtrl->getLinkTargetByClass("ilObjMockLearningmoduleGUI", "showPage4"));
                break;
        }

        return $my_tpl->get();
    }

    public function  preconditionTemplate($name)
    {
        switch($name)
        {
            case "Chapter 1":
            case "Chapter 2":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_chapter_preconditions.html",false,false);
                break;
            case "Subchapter 1.1":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_subchapter_preconditions.html",false,false);
                break;
        }

        return $my_tpl->get();
    }

    public  function metadataTemplate($name)
    {
        switch($name)
        {
            case "Chapter 1":
                $mytpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_chapter_metadata.html",false,false);
                break;
            case "Chapter 2":
                $mytpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_chapter2_metadata.html",false,false);
                break;
            case "Subchapter 1.1":
                $mytpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_subchapter_metadata.html",false,false);
                break;
        }

        return $mytpl->get();
    }


}