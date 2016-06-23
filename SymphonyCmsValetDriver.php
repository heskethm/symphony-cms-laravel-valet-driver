<?php

class SymphonyCmsValetDriver extends ValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     *
     * @return bool
     */
    public function serves($sitePath, $siteName, $uri)
    {
        return file_exists($sitePath . '/symphony/lib/core/class.symphony.php');
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     *
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        if (is_file($staticFilePath = $sitePath . $uri)) {
            return $staticFilePath;
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     *
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        $uri = rtrim($uri, "/");

        // Images
        if (0 === strpos($uri, '/image')) {
            $_GET['param'] = substr($uri, 7);

            return $sitePath . '/extensions/jit_image_manipulation/lib/image.php';
        }

        // Admin
        if (0 === strpos($uri, '/symphony')) {
            $_GET['mode'] = 'administration';
            $uri = substr($uri, 9);
        }

        // Route to page
        if ( ! empty($uri)) {
            $_GET['symphony-page'] = $uri;
        }

        return $sitePath . '/index.php';
    }
}
