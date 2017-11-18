<?php

namespace Controllers;

/**
 * This is Description of Controller class
 *
 */
class Controller
{
    /**
     * Create new Controller instance.
     *
     * @return Controller
     *
     */
    public function __construct ()
    {
        return $this;
    }


    /**
     * Description:
     *
     * @param string $modelName The name of the Model class
     *
     * @return object Model
     *
     */
    protected function model($modelName)
    {
        $model = 'Models\\' . $modelName;

        return new $model;
    }

    /**
     * Description:
     *
     * @param string $viewName The name of the view. This is rel-path to the file in views folder.
     * @param array $data The data that passed in view file.
     *
     * @return void
     *
     */
    protected function view($viewName, $data = [])
    {
        $viewFilePath = './app/Views/' . strtolower($viewName) . '.php';

        if (file_exists($viewFilePath)) {
            require_once($viewFilePath);
        }
    }

}