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
            // case "Page 2":

            // case "Page 3":

            // case "Page 4":

            //case "Page 5":
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
            // case "Page 2":

            // case "Page 3":

            // case "Page 4":

            //case "Page 5":
        }

        return $my_tpl->get();
    }

    public function metadataTemplate($name)
    {
        switch($name)
        {
            case "Page 1":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_metadata.html",false,false);
            // case "Page 2":

            // case "Page 3":

            // case "Page 4":

            //case "Page 5":
        }

        return $my_tpl->get();
    }

    public function historyTemplate($name)
    {
        switch($name)
        {
            case "Page 1":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_history.html",false,false);
            // case "Page 2":

            // case "Page 3":

            // case "Page 4":

            //case "Page 5":
        }

        return $my_tpl->get();
    }

    public function clipboardTemplate($name)
    {
        switch($name)
        {
            case "Page 1":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_clipboard.html",false,false);
            // case "Page 2":

            // case "Page 3":

            // case "Page 4":

            //case "Page 5":
        }

        return $my_tpl->get();
    }

    public function activationTemplate($name)
    {
        switch($name)
        {
            case "Page 1":
                $my_tpl = new ilTemplate(__DIR__ ."/../templates/tpl.lm_page_activation.html",false,false);
            // case "Page 2":

            // case "Page 3":

            // case "Page 4":

            //case "Page 5":
        }

        return $my_tpl->get();
    }

}