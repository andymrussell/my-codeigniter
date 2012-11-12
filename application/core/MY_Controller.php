<?php
/**
 * A base controller for CodeIgniter with view autoloading, layout support,
 * model loading, asides/partials and per-controller 404
 *
 * @link http://github.com/jamierumbelow/codeigniter-base-controller
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

class MY_Controller extends CI_Controller
{    

    /* --------------------------------------------------------------
     * VARIABLES
     * ------------------------------------------------------------ */

    /**
     * The current request's view. Automatically guessed 
     * from the name of the controller and action
     */
    protected $view = '';
    
    /**
     * An array of variables to be passed through to the 
     * view, layout and any asides
     */
    protected $data = array();
    
    /**
     * The name of the layout to wrap around the view.
     */
    protected $layout;
    
    /**
     * An arbitrary list of asides/partials to be loaded into
     * the layout. The key is the declared name, the value the file
     */
    protected $asides = array();
    
    /**
     * A list of models to be autoloaded
     */
    protected $models = array();

    /**
    * Set if a page should be  SSL
    */
    public $ssl_page = FALSE;

    /**
     * A formatting string for the model autoloading feature.
     * The percent symbol (%) will be replaced with the model name.
     */
    protected $model_string = '%_model';
    
    /* --------------------------------------------------------------
     * GENERIC METHODS
     * ------------------------------------------------------------ */
    
    /**
     * Initialise the controller, tie into the CodeIgniter superobject
     * and try to autoload the models
     */
    public function __construct()
    {
        parent::__construct();

        //If the page is a SSL Page redirect to its place
        if($this->ssl_page == true && $this->config->item('use_ssl') == true)
        {
            force_ssl();
        }
        else
        {
            remove_ssl();
        }
        
        //Load the models
        $this->_load_models();

        //Get any error messages
        $this->_get_messages();

        //Get any validation data / errors to pass back to the form
        $this->_get_validation_errors();

        //Check any session tracking paramaters that should be in here
        $this->_session();
    }

    /* --------------------------------------------------------------
     * VIEW RENDERING
     * ------------------------------------------------------------ */
        
    /**
     * Override CodeIgniter's despatch mechanism and route the request
     * through to the appropriate action. Support custom 404 methods and
     * autoload the view into the layout.
     */
    public function _remap($method)
    {
        if (method_exists($this, $method))
        {
            call_user_func_array(array($this, $method), array_slice($this->uri->rsegments, 2));
        }
        else
        {
            if (method_exists($this, '_404'))
            {
                call_user_func_array(array($this, '_404'), array($method));
            }
            else
            {
                show_404(strtolower(get_class($this)).'/'.$method);
            }
        }
        
        $this->_load_view();
    }

    /**
     * Automatically check for any session messages, 
     * and pass them to the view as $message.
     */
    private function _get_messages()
    {
        $message = $this->session->flashdata('message');

        if(isset($message))
        {
            $this->data['message'] = $message;
        }
    }

    /**
     * Automatically check for any validation errors, 
     * and pass them to the view as $validation.
     */
    private function _get_validation_errors()
    {
        $validation = $this->session->flashdata('validation');
        
        if(isset($validation))
        {
            $this->data['validation'] = $validation;
        }
    }

    /**
     * Start a session and add any tracking paramaters to the session data
     */
    private function _session()
    {
        $tracking = (array) $this->session->userdata('tracking');
        
        $tracking_params = $this->config->item('tracking');

        //If no tracking source is found already then get and save it here!
        if(!isset($tracking['tracked']))
        {
            if(isset($tracking_params) && count($tracking_params))
            {
                $data['tracking']['tracked'] = TRUE;
                foreach($tracking_params as $item){
                    if($this->input->get($item))
                        $data['tracking'][$item] = $this->input->get($item);    
                }
            }

            if(isset($data))
            {
                $this->session->set_userdata($data);
            }
        }
    }
    
    /**
     * Automatically load the view, allowing the developer to override if
     * he or she wishes, otherwise being conventional.
     */
    protected function _load_view()
    {
         $module = FALSE;
        // If $this->view == FALSE, we don't want to load anything
        if ($this->view !== FALSE)
        {
            if(strpos($this->router->directory, 'modules'))
            {
                $module = TRUE;
                $module_dir = $this->router->directory;
                $module_dir = str_replace('controllers/', '', $module_dir);
                $module_dir = str_replace('../', '', $module_dir);
                $view = (!empty($this->view)) ? '/'.$this->view : '/' . $this->router->class . '/' . $this->router->method;
            }
            else
            {
                // If $this->view isn't empty, load it. If it isn't, try and guess based on the controller and action name
                $view = (!empty($this->view)) ? $this->view : $this->router->directory . $this->router->class . '/' . $this->router->method;    
            }

            //Set the view path to the module directory if a module is being used.        
            if($module == TRUE)
            {
                $this->load->_ci_view_path = APPPATH.$module_dir;
            }

            // Load the view into $yield
            $data['yield'] = $this->load->view($view, $this->data, TRUE);

            //Switch the view directory back to default
            if($module == TRUE)
            {
                unset($this->load->_ci_view_path);
            }



            
            // Do we have any asides? Load them.
            if (!empty($this->asides))
            {
                foreach ($this->asides as $name => $file)
                {
                    $data['yield_'.$name] = $this->load->view($file, $this->data, TRUE);
                }
            }
            
            // Load in our existing data with the asides and view
            $data = array_merge($this->data, $data);
            $layout = FALSE;

            // If we didn't specify the layout, try to guess it
            if (!isset($this->layout))
            {
                if (file_exists(APPPATH . 'views/layouts/' . $this->router->class . '.php'))
                {
                    $layout = 'layouts/' . $this->router->class;
                } 
                else
                {
                    $layout = 'layouts/application';
                }
            }

            // If we did, use it
            else if ($this->layout !== FALSE)
            {
                $layout = $this->layout;
            }

            // If $layout is FALSE, we're not interested in loading a layout, so output the view directly
            if ($layout == FALSE)
            {
                $this->output->set_output($data['yield']);
            }

            // Otherwise? Load away :)
            else
            {
                $this->load->view($layout, $data);
            }
        }
    }

    /* --------------------------------------------------------------
     * MODEL LOADING
     * ------------------------------------------------------------ */
    
    /**
     * Load models based on the $this->models array
     */
    private function _load_models()
    {
        foreach ($this->models as $model)
        {
            $this->load->model($this->_model_name($model), $model);
        }
    }
    
    /**
     * Returns the loadable model name based on
     * the model formatting string
     */
    protected function _model_name($model)
    {
        return str_replace('%', $model, $this->model_string);
    }
}