<?php

/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 29.04.2016
 * Time: 13:24
 */
class parentObjectHandler
{

    public function parentName($name)
    {
        switch($name)
        {
            case "Chapter 1":
                return "Learning Module";

            case "Subchapter 1.1":
                return "parent chapter";

        }
    }

    public function displayCommand($name) {

        switch($name)
        {
            case "Chapter 1":
                return "showChapterSubtab";
            case "Subchapter 1.1":
                return "showChapter1";
        }
    }

    public function subchapterTemplate($name)
    {
        switch($name)
        {
            case "Chapter 1":
                return __DIR__ ."/../templates/tpl.lm_chapter_subchaptersAndPages.html";
            case "Subchapter 1.1":
                return __DIR__ ."/../templates/tpl.lm_subchapter_subchaptersAndPages.html";
        }
    }

    public function  preconditionTemplate($name)
    {
        switch($name)
        {
            case "Chapter 1":
                return __DIR__ ."/../templates/tpl.lm_chapter_preconditions.html";
            case "Subchapter 1.1":
                return __DIR__ ."/../templates/tpl.lm_subchapter_preconditions.html";
        }
    }

    public  function metadataTemplate($name)
    {
        switch($name)
        {
            case "Chapter 1":
                return __DIR__ ."/../templates/tpl.lm_chapter_metadata.html";
            case "Subchapter 1.1":
                return __DIR__ ."/../templates/tpl.lm_subchapter_metadata.html";
        }
    }


}