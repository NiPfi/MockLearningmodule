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

        }
    }

    public function displayCommand($name) {

        switch($name)
        {
            case "Learning Module":
                return "showChapterSubtab";
        }
    }

    public function subchapterTemplateDir($name)
    {
        switch($name)
        {
            case "Chapter 1":
                return __DIR__ ."/../templates/tpl.lm_chapter_subchaptersAndPages.html";
        }
    }

    public function  preconditionTemplateDir($name)
    {
        switch($name)
        {
            case "Chapter 1":
                return "/../templates/tpl.lm_chapter_preconditions.html";
        }
    }

}