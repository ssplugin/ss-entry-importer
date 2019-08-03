<?php
/**
 * SS Entry Importer plugin for Craft CMS 3.x
 *
 * The plugin will be used for an importing an entries from a CSV file.(Supported field type: Plain Text, Email, Radio Buttons, Dropdown, URL.)
 *
 * @link      http://www.systemseeders.com/
 * @copyright Copyright (c) 2019 SystemSeeders
 */

namespace ssplugin\ssentryimporter\variables;

use ssplugin\ssentryimporter\SsEntryImporter;

use Craft;

/**
 * SS Entry Importer Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.ssEntryImporter }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    SystemSeeders
 * @package   SsEntryImporter
 * @since     1.0.0
 */
class SsEntryImporterVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.ssEntryImporter.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.ssEntryImporter.exampleVariable(twigValue) }}
     *
     * @param null $optional
     * @return string
     */    
}
