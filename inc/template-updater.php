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

  public function __construct( $file ) {
      $this->file = $file;
      $this->set_theme_properties();
      $this->log_file = __DIR__ . '/update_log.txt'; // Set log file path

      //add_action( 'admin_init', array( $this, 'set_theme_properties' ) );

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
  }

  public function set_theme( $theme ) {
      $this->theme = $theme;
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
      if ( is_null( $this->github_response ) ) { // Do we have a response?
        $args = array();
        $request_uri = sprintf( 'https://api.github.com/repos/%s/%s/releases/latest', $this->username, $this->repository ); // Build URI
          
        $args = array();

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

        /*
        dump_it('Github Response', 'aqua');
        dump_it($response, 'aqua');
        */

        if( is_array( $response ) ) { // If it is an array
            $response = current( $response ); // Get the first item
        }
        $this->log("Github response set for ". $this->theme);
        $this->github_response = $response; // Set it to our property
      }
  }

  public function initialize() {
      $this->log("Initializing GitHub Updater for ". $this->theme);

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
  }

  public function modify_transient( $transient ) {
    
      if( property_exists( $transient, 'checked') ) { // Check if transient has a checked property

        //dump_it($transient->checked, 'yellow');

          if( $checked = $transient->checked ) { // Did Wordpress check for updates?
              $this->get_repository_info(); // Get the repo info
              $this->log("Checking repository info: ". $this->theme);

              if( gettype($this->github_response) === "boolean" ) { return $transient; }

              $github_version = filter_var($this->github_response->tag_name, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
              
              $out_of_date = version_compare( 
                  $github_version, 
                  $checked[ $this->theme ], 
                  'gt' 
              ); // Check if we're out of date

              $this->log("Repo version checked and compared: ". $out_of_date .' | Remote: '.$github_version .' | Local: '. $checked[ $this->theme ]);

              if( $out_of_date ) {

                  $new_files = $this->github_response->zipball_url; // Get the ZIP

                  // Handle Extra Github folder of annoyingness
                  // Download the zip file
                    $temp_zip = download_url($new_files);
                      
                    if (is_wp_error($temp_zip)) {
                        // Handle error
                        $this->log("Temp zip error, unable to be created.");
                        return $transient;
                    }

                    $this->log("Set temp zip.");

                    // Extract the zip file to a temporary directory
                    $temp_dir = wp_tempnam($temp_zip);
                    unzip_file($temp_zip, $temp_dir);

                    $this->log("Set temp directory." . $temp_dir);
                    // Find the inner folder containing the theme files
                    $inner_folders = glob($temp_dir . '/*', GLOB_ONLYDIR);
                    if (!empty($inner_folders)) {
                        $inner_folder = reset($inner_folders);
                        $this->log("New files set: ");
                        // Update the new files path to point to the inner folder
                        $new_files = trailingslashit($inner_folder);
                    }

                    // Clean up temporary files
                    unlink($temp_zip);
                    $this->rrmdir($temp_dir); // Define this function to recursively remove directories

                    $this->log("Extra folder handled.");
                    // END: Handle Extra Github folder of annoyingness
                    
                  $slug = current( explode('/', $this->theme ) ); // Create valid slug

                  $this->log("new slug: ". $slug);

                  $theme = array( // setup our theme info
                      'url' => 'https://beech.agency', //$this->themeObject["ThemeURI"],
                      'slug' => $slug,
                      'package' => $new_files,
                      'new_version' => $this->github_response->tag_name
                  );

                  $transient->response[$this->theme] = $theme; // Return it in response

              }
          }
      }

      return $transient; // Return filtered transient
  }
    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (is_dir($dir . '/' . $object)) {
                        $this->rrmdir($dir . '/' . $object);
                    } else {
                        unlink($dir . '/' . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }

  public function download_package( $args, $url ) {

    //dump_it('Download Package', 'red');
    //dump_it($args, 'red');

    $this->log("downloading package: ". $this->theme);

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

        $this->log("attempt after install: ". $this->theme);
        // Get the parent directory of the destination (the theme directory)
        $destination = $result['destination'];
        $theme_root = get_theme_root();
        $theme_directory = $theme_root . '/' . $this->theme;

        $this->log("desination: ".  $destination);
        $this->log("theme_root: ".  $theme_root);

        // Locate the extracted folder (which includes the branch name suffix)
        $extracted_folder = $wp_filesystem->find_folder($destination);
        $subfolders = array_filter(glob($extracted_folder . '/*'), 'is_dir');

        $this->log("extracted_folder: ".  $extracted_folder);

        // Assuming there's only one subfolder in the extracted directory
        if (!empty($subfolders)) {
            $source = reset($subfolders);
            
            // If there's another level of folder, navigate into it
            $sub_subfolders = array_filter(glob($source . '/*'), 'is_dir');
            if (!empty($sub_subfolders)) {
                $source = reset($sub_subfolders);
            }

            // Move files from extracted folder to the theme directory
            $wp_filesystem->move($source, $theme_directory, true);
        }

        // Remove the empty extracted folder
        $wp_filesystem->delete($destination, true);

        // Update the result destination
        $result['destination'] = $theme_directory;

        return $result;
    }
}


$updater = new BeechAgency_Theme_Updater( __FILE__ );
$updater->set_logging(true);
$updater->set_username( 'BeechAgency' );
$updater->set_repository( 'beechagency2023' );
$updater->set_theme('beechagency2023'); 


$updater->initialize();

//dump_it($updater, 'white');

/*
$updater->authorize( 'abcdefghijk1234567890' ); // Your auth code goes here for private repos
*/

