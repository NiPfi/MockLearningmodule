<?php

/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 30.04.2016
 * Time: 13:46
 */
class pageHandler
{
    public function displayCommand($name)
    {
        switch($name)
        {
            case "Page 1":
            case "Page 2":
                return "showChapter1";
            case "Page 3":
            case "Page 4":
                return "showSubchapter1";
            case "Page 5":
                return "showChapter2";

        }
    }

    public function editTemplate($name)
    {
        switch($name)
        {
            case "Page 1":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_edit.html",false,false);
                break;
            case "Page 2":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page2_edit.html",false,false);
                break;
            case "Page 3":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page3_edit.html",false,false);
                break;
            case "Page 4":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page4_edit.html",false,false);
                break;
            case "Page 5":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page5_edit.html",false,false);
                break;
        }

        return $my_tpl->get();
    }

    public function previewTemplate($name)
    {
        switch($name)
        {
            case "Page 1":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_preview.html",false,false);
                break;
            case "Page 2":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page2_preview.html",false,false);
                break;
            case "Page 3":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page3_preview.html",false,false);
                break;
            case "Page 4":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page4_preview.html",false,false);
                break;
            case "Page 5":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page5_preview.html",false,false);
                break;
        }

        return $my_tpl->get();
    }

    public function metadataTemplate($name)
    {
        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_metadata.html",false,false);
        switch($name)
        {
            case "Page 1":
                $my_tpl->setVariable("PAGE_TITLE", "Page 1");
                break;
            case "Page 2":
                $my_tpl->setVariable("PAGE_TITLE", "Page 2");
                break;
            case "Page 3":
                $my_tpl->setVariable("PAGE_TITLE", "Page 3");
                break;
            case "Page 4":
                $my_tpl->setVariable("PAGE_TITLE", "Page 4");
                break;
            case "Page 5":
                $my_tpl->setVariable("PAGE_TITLE", "Page 5");
                break;
        }

        return $my_tpl->get();
    }

    public function historyTemplate($name)
    {

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_history.html",false,false);

        return $my_tpl->get();
    }

    public function clipboardTemplate($name)
    {

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_clipboard.html",false,false);

        return $my_tpl->get();
    }

    public function activationTemplate($name)
    {

        $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_activation.html",false,false);

        return $my_tpl->get();
    }

}