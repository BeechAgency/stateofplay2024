<?php
/**
 * beechnut functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package beechnut
 */


function dump_it($what, $color) {
  echo "<pre style='background-color: $color;'>";
  var_dump($what);
  echo '</pre>';
}

class BeechAgency_Theme_Updater {
    private $file;    
    private $theme;    
    private $themeObject;
    private $version;    
    private $active;    
    private $username;    
    private $repository;    
    private $authorize_token;
    private $github_response;
    private $package_url;
    private $request_uri;
    private $logging = false;
    private $log_file;


    public function __construct( $file ) {
        $this->file = $file;
        $this->set_theme_properties();


        $upload_dir = wp_upload_dir();
        $wp_content_dir = dirname($upload_dir['basedir']);
        $this->log_file = $wp_content_dir . '/update_log.txt'; // Set log file path

        return $this;
    }

    // Provides logging
    private function log($message) {
        if ( !$this->logging ) return;

        $timestamp = date("Y-m-d H:i:s");
        file_put_contents($this->log_file, "[$timestamp] $message" . PHP_EOL, FILE_APPEND);
        //error_log( print_r("GitUpdater: [$timestamp] $message"));
    }

    public function set_logging( $status = false ) {
        $this->logging =  $status;
    }

    public function set_theme_properties() {
        $this->version  = wp_get_theme($this->theme)->get('Version');
        $this->themeObject = wp_get_theme($this->theme);
        $this->active	= $this->theme === get_stylesheet() ? true : false;
        $this->theme_dir = get_theme_root();
        $this->theme_name = get_option('stylesheet');
        $this->theme_template = get_stylesheet_directory(); // Folder name of the current theme
        $this->theme_uri = get_stylesheet_directory_uri(); // URL of the current theme folder
    }

    public function set_theme( $theme ) {
        $this->theme = $theme;
        $this->theme_slug = $theme;
    }
    public function set_username( $username ) {
        $this->username = $username;
    }
    public function set_repository( $repository ) {
        $this->repository = $repository;
    }
    public function authorize( $token ) {
        $this->authorize_token = $token;
    }

    private function get_repository_info() {
        if ( !is_null( $this->github_response ) ) {
            return; // We already have a response so bail.
        }

        $args = array();
        $request_uri = sprintf( 'https://api.github.com/repos/%s/%s/releases/latest', $this->username, $this->repository ); // Build URI

        $this->request_uri = $request_uri;

        $args = array();
        $this->log("Request URL: ". $request_uri);

        if( $this->authorize_token ) { // Is there an access token?
            $args['headers']['Authorization'] = "token {$this->authorize_token}"; // Set the headers
        }

        $response = json_decode(
            file_get_contents(
            'https://api.github.com/repos/'.$this->username.'/'.$this->repository.'/releases/latest', false,
            stream_context_create([
                'http' => ['header' => "User-Agent: ".$this->username."\r\n"],
                'ssl' => ["verify_peer"=>false, "verify_peer_name"=>false]
            ])
        ));

        $this->log("GitHub response: " . json_encode($response));

        if( is_array( $response ) ) { // If it is an array
            $response = current( $response ); // Get the first item
        }

        $this->log("Github response set for ". $this->theme);

        $this->github_response = $response; // Set it to our property

        return;
    }

    public function initialize() {
        $this->log("Initializing GitHub Updater for ". $this->theme);

        $details = array();

        $details['theme_name'] = $this->theme;
        $details['theme_dir'] = $this->theme_dir;
        $details['theme_slug'] = $this->theme_slug;
        $details['active'] = $this->active;
        $details['theme_template'] = $this->theme_template;
        $details['theme_uri'] = $this->theme_uri;
        $details['version'] = $this->version;

        $this->log("Details are: ". json_encode($details));

        add_filter( 'pre_set_site_transient_update_themes', array( $this, 'modify_transient' ), 10, 1 );
        //add_filter( 'plugins_api', array( $this, 'plugin_popup' ), 10, 3);
        add_filter( 'upgrader_post_install', array( $this, 'after_install' ), 10, 3 );

        // Add Authorization Token to download_package
        add_filter( 'upgrader_pre_download',
            function() {
                add_filter( 'http_request_args', [ $this, 'download_package' ], 15, 2 );
                return false; // upgrader_pre_download filter default return value.
            }
        );

        add_filter('upgrader_process_complete',[ $this, 'install_complete' ], 10, 2);
    }

    public function modify_transient( $transient ) {
        $this->log("Modifying transient for theme: " . $this->theme);

        if( !property_exists( $transient, 'checked') ) {
            return $transient;
        }
        if( !$transient->checked ) {
            return $transient; // Did Wordpress check for updates?
        }

        $checked = $transient->checked;
        
        $this->get_repository_info(); // Get the repo info
        $this->log("Checking repository info: ". $this->theme);

        if( gettype($this->github_response) === "boolean" ) { 
            return $transient; 
        }

        $github_version = filter_var($this->github_response->tag_name, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        $out_of_date = version_compare( 
            $github_version, 
            $checked[ $this->theme ], 
            'gt' 
        ); // Check if we're out of date

        $this->log("Repo version checked and compared: ". $out_of_date .' | Remote: '.$github_version .' | Local: '. $checked[ $this->theme ]);

        // If she not out of date get outta here.
        if( !$out_of_date )  {
            return $transient; 
        }

        $this->log("Theme out of date");

        $new_files = $this->github_response->zipball_url; // Get the ZIP

        /* Optional: Get the assets instead of the zip. Not required here.
        if( isset($this->github_response->assets) && count($this->github_response->assets) > 0 ) {
            $new_files = $this->github_response->assets[0]->browser_download_url;
        }
        */

        $slug = current( explode('/', $this->theme ) ); // Create valid slug
        $this->package_url = $new_files;

        $this->log("Download url: ".$new_files);
        $this->log("new slug: ". $slug);


        $theme = array( // setup our theme info
            'url' => 'https://github.com/'.$this->username.'/'.$this->repository, //$this->themeObject["ThemeURI"],
            'slug' => $this->theme_slug,
            'package' => $new_files,
            'new_version' => $this->github_response->tag_name
        );


        $this->log("Setting transient response with theme info: " . json_encode($theme));

        $transient->response[$this->theme] = $theme; // Return it in response

        $this->log("Modified transient for ". $this->theme." | " . json_encode($transient) );

        return $transient; // Return filtered transient
    }

    public function download_package( $args, $url ) {
        // This function is just for adding auth prior to downloading the package.

        if(strpos($url, $this->username.'/'.$this->repository) === false) {
            return $args;
        }

        $this->log("Attempting to download package from URL: $url");
        $this->log("Download Package Args (before modification): " . json_encode($args));

        if ( null !== $args['filename'] ) {
            if( $this->authorize_token ) { 
                $args = array_merge( $args, array( "headers" => array( "Authorization" => "token {$this->authorize_token}" ) ) );
            }
        }

        remove_filter( 'http_request_args', [ $this, 'download_package' ] );

        return $args;
    }


    public function after_install( $response, $hook_extra, $result ) {
        global $wp_filesystem; // Get global FS object

        $this->log("AFTER INSTALL PROCESS STARTED");

        // Extracted directory name (usually same as the repo name)
        $extracted_folder = $result['destination'];
        $this->log("Extracted folder: " . $extracted_folder);

        // Expected install directory
        $install_directory = $wp_filesystem->wp_content_dir() . 'themes/' . $this->theme_slug;
        $this->log("Install directory: " . $install_directory);

        // Rename the extracted folder to the theme slug
        if ( $wp_filesystem->move( $extracted_folder, $install_directory, true ) ) {
            $this->log("Folder renamed from " . basename($extracted_folder) . " to " . $this->theme_slug);
        } else {
            $this->log("Error renaming folder from " . basename($extracted_folder) . " to " . $this->theme_slug);
            return $response; // Abort if renaming fails
        }

        // Rescan themes
        wp_clean_themes_cache();
        $themes = wp_get_themes();
        $theme_names = array_keys($themes);
        $this->log("Themes after rescan: " . json_encode($theme_names));

        // Log current options
        $stylesheet = get_option('stylesheet');
        $template = get_option('template');
        $this->log("Current stylesheet and template options: " . json_encode($stylesheet) . ", " . json_encode($template));
        $this->log("Theme slug: " . $this->theme_slug);

        // Force the theme switch
        $temp_theme = null;
        foreach ($theme_names as $theme_name) {
            $this->log("Temp theme name: " . $theme_name. " | " .$this->theme_slug);
            if ( $theme_name !== $this->theme_slug && $theme_name !== $stylesheet ) {
                $temp_theme = $theme_name;
                break; // Exit the loop once we find the first non-current theme
            }
        }

        $this->log("Looking for temp theme to change to: " . $temp_theme);

        if($temp_theme) {
            switch_theme($temp_theme);
        }
        $this->log("Switched to temp theme: " . $temp_theme);


        switch_theme($this->theme_slug);
        $this->log("Theme switched back to: " . $this->theme_slug);

        // Ensure the active theme option is updated if necessary
        update_option('stylesheet', $this->theme_slug);
        update_option('template', $this->theme_slug);
        //update_option('current_theme', $this->theme_slug);

        // Double-check if the theme options have been updated correctly
        $stylesheet_updated = get_option('stylesheet');
        $template_updated = get_option('template');
        $this->log("Updated stylesheet and template options: " . json_encode($stylesheet_updated) . ", " . json_encode($template_updated));

        
        $this->log("Pause on the cache...");
        // Clear cache at the very end to avoid interruptions
        //clean_theme_cache();
        wp_clean_themes_cache(true);

        $this->log("AFTER INSTALL PROCESS COMPLETED");


        return $response;
    }

    public function install_complete( $upgrader, $hook_extra ) {
        // Check if the upgrade action was for a theme
        if (isset($hook_extra['action']) && $hook_extra['action'] === 'update' && 
            isset($hook_extra['type']) && $hook_extra['type'] === 'theme') {

            // Get the theme slug from the hook_extra array
            if (isset($hook_extra['theme'])) {
                $theme_slug = $hook_extra['theme'];

                $this->log("install_complete! Theme slug: ". $theme_slug);

                $theme_contains_username = strpos($theme_slug, $this->username) !== false;

                $this->log("install_complete! Theme containers username: ". $theme_contains_username);

                // Check if the theme exists
                if ( !wp_get_theme($theme_slug)->exists() && $theme_contains_username ) {
                    $this->log("install_complete! Theme does not exist and contains username: ". $theme_slug);

                    // Update the options
                    update_option('stylesheet', $this->theme_slug);
                    update_option('template', $this->theme_slug);

                    // Log the update (optional)
                    $this->log("install_complete! Updated theme options to: " . $this->theme_slug);
                }
            }
        }
    }
}


$updater = new BeechAgency_Theme_Updater( __FILE__ );
$updater->set_logging(true);
$updater->set_username( 'BeechAgency' );
$updater->set_repository( 'stateofplay2024' );
$updater->set_theme('stateofplay2024'); 

/**
 * Call the updater and initialize it.
 */
$updater->initialize();
