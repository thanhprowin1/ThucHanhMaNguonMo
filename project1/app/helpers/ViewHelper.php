<?php

class ViewHelper {
    /**
     * Render a view with the main layout
     * 
     * @param string $view Path to the view file
     * @param array $data Data to pass to the view
     * @param string $pageTitle Title of the page
     * @return void
     */
    public static function render($view, $data = [], $pageTitle = null) {
        // Extract data to make variables available in the view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        include $view;
        
        // Get the content of the view
        $content = ob_get_clean();
        
        // Include the layout with the view content
        include 'app/views/layouts/main.php';
    }
}
