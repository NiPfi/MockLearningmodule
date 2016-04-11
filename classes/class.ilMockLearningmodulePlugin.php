<?php

include_once("./Services/Repository/classes/class.ilRepositoryObjectPlugin.php");

/**
 * Example repository object plugin
 */
class ilMockLearningmodulePlugin extends ilRepositoryObjectPlugin
{
    // must correspond to the plugin subdirectory
    function getPluginName()
    {
        return "MockLearningmodule";
    }

    function uninstallCustom()
    {
        // TODO: Implement uninstallCustom() method.
    }
}

?>