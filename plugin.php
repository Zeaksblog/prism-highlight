<?php

class pluginPrism extends Plugin {

    public function init()
    {
        $this->dbFields = array(
            'prismTheme' => 'prism-light', // Default theme
        );

        // Add more themes as needed
        $additionalThemes = array(
            'prism-default' => 'Default theme',
            'prism-funky' => 'Funky Theme',
            'prism-coy' => 'Coy Theme',
            'prism-tomorrow-night' => 'Tommorrow Night Theme',
			'prism-material-dark' => 'Material Dark Theme',
            // Add more themes here
        );

        // Merge additional themes with dbFields
        $this->dbFields = array_merge($this->dbFields, $additionalThemes);
    }

    public function form()
    {
        global $L;

        $selectedTheme = $this->getValue('prismTheme');

        $html  = '<div class="mb-3">';
        $html .= '<label class="form-label" for="prismTheme">' . $L->get('Select Prism Theme') . '</label>';
        $html .= '<select class="form-select" id="prismTheme" name="prismTheme">';

        // Retrieve all themes from dbFields
        $themes = array(
            'prism-default' => 'Default Theme',
            'prism-funky' => 'Funky Theme',
            'prism-coy' => 'Coy Theme',
            'prism-tomorrow-night' => 'Tomorrow Night Theme',
			'prism-material-dark' => 'Material Dark Theme',
            // Add more themes as needed
        );

        foreach ($themes as $themeValue => $themeLabel) {
            $isSelected = ($selectedTheme === $themeValue) ? 'selected' : '';
            $html .= '<option value="' . $themeValue . '" ' . $isSelected . '>' . $themeLabel . '</option>';
        }

        $html .= '</select>';
        $html .= '<div class="form-text">' . $L->get('Select the Prism syntax highlighting theme.') . '</div>';
        $html .= '</div>';

        return $html;
    }

    public function siteHead()
    {
        $selectedTheme = $this->getValue('prismTheme');

        // Determine the CSS file to load based on the selected theme
        $themeCssPath = HTML_PATH_PLUGINS . 'prism/css/' . $selectedTheme . '.css';

        // Return the HTML link tag for the theme CSS
        return '<link rel="stylesheet" href="' . $themeCssPath . '">';
    }

    public function siteBodyEnd()
    {
        // Include Prism JavaScript in the site's body end
        return PHP_EOL . '<script src="' . HTML_PATH_PLUGINS . 'prism/js/prism.js"></script>' . PHP_EOL;
    }

    public function beforeSiteLoad()
    {
        // Handle form submissions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Save selected theme
            $selectedTheme = isset($_POST['prismTheme']) ? $_POST['prismTheme'] : 'prism-default'; // Default to light theme if not set
            $this->setValue('prismTheme', $selectedTheme);
        }
    }

}

?>
