<?php
class SawSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {   /*
        // This page will be under "Settings"
        add_options_page(
            'Send a Wow!', 
            'Send a Wow!', 
            'manage_options', 
            'saw-setting-admin', 
            array( $this, 'create_admin_page' )
        );*/
        // This page will be under an own menu
        add_menu_page(
            'Send a Wow!', 
            'Send a Wow!', 
            'manage_options', 
            'saw-setting-admin',
            array( $this, 'create_admin_page' )
        ); 
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'saw_options_general' );
        
        //default vaulues
        
        $update = false;
        //override if not set or empty
        //fullpageonly
        if(!(isset( $this->options['fullpageonly'] )) || $this->options['fullpageonly'] == "") {
            $this->options['fullpageonly'] = "1";
            $update = true;
        }
        //button
        if(!(isset( $this->options['button_text'] )) || $this->options['button_text'] == "") {
            $this->options['button_text'] = "Send a Wow!";
            $update = true;
        }
        //address
        if(!(isset( $this->options['address'] )) || $this->options['address'] == "") {
            $this->options['address'] = "DMugKUwP2JwSqtC8GBr5HDzdqyC2fkvXqx";
            $update = true;
        }
        //amount
        if(!(isset( $this->options['amount'] )) || $this->options['amount'] == "") {
            $this->options['amount'] = "10";
            $update = true;
        }
        //coinsign
        if(!(isset( $this->options['coinsign'] )) || $this->options['coinsign'] == "") {
            $this->options['coinsign'] = "&ETH;";
            $update = true;
        }
        //network
        if(!(isset( $this->options['network'] )) || $this->options['network'] == "") {
            $this->options['network'] = "dogecoin";
            $update = true;
        }
        //info text
        if(!(isset( $this->options['info'] ))) {
            $this->options['info'] = "If you like this article you can donate me some doge for it. 
                Dogecoin is a digital currency which makes it easy to spend...";
            $update = true;
        }
        //readmore text
        if(!(isset( $this->options['readmore'] ))) {
            $this->options['readmore'] = "read more";
            $update = true;
        }
        //readmore url
        if(!(isset( $this->options['readmoreurl'] ))) {
            $this->options['readmoreurl'] = "http://dogecoin.com/";
            $update = true;
        }
        //addresslabel
        if(!(isset( $this->options['addresslabel'] )) || $this->options['addresslabel'] == "") {
            $this->options['addresslabel'] = "Address:";
            $update = true;
        }
        //amountlabel
        if(!(isset( $this->options['amountlabel'] )) || $this->options['amountlabel'] == "") {
            $this->options['amountlabel'] = "Amount:";
            $update = true;
        }
        //devdonation
        if(!(isset( $this->options['devdonation'] )) || $this->options['devdonation'] == "") {
            $this->options['devdonation'] = "7.5";
            $update = true;
        }
        
        if($update)
            update_option('saw_options_general', $this->options);
        
        
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Send a Wow! Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'saw_option_group' );   
                do_settings_sections( 'saw-setting-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'saw_option_group', // Option group
            'saw_options_general', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        
        add_settings_section(
            'setting_section_id', // ID
            'General Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'saw-setting-admin' // Page
        );
        add_settings_section(
            'saw-setting-admin-pluginbehaviour', // ID
            'Plugin Behaviour', // Title
            array( $this, 'print_section_info_pluginbehaviour' ), // Callback
            'saw-setting-admin' // Page
        );
        //fullpageonly
        add_settings_field(
            'fullpageonly', // ID
            'Show on Full Page Only', // Title 
            array( $this, 'fullpageonly_callback' ), // Callback
            'saw-setting-admin', // Page
            'saw-setting-admin-pluginbehaviour' // Section
        ); 
        
        //button text
        add_settings_field(
            'button_text', // ID
            'Text for Button', // Title 
            array( $this, 'button_text_callback' ), // Callback
            'saw-setting-admin', // Page
            'setting_section_id' // Section

        );      
        //address
        add_settings_field(
            'address', 
            'Your Coin Address<span style="color:red;">&nbsp;!</span>', 
            array( $this, 'address_callback' ), 
            'saw-setting-admin', 
            'setting_section_id'
        );
        //amount
        add_settings_field(
            'amount', 
            'Default Amount', 
            array( $this, 'amount_callback' ), 
            'saw-setting-admin', 
            'setting_section_id'
        );
        //coinsign
        add_settings_field(
            'coinsign', 
            'Coin Symbol', 
            array( $this, 'coinsign_callback' ), 
            'saw-setting-admin', 
            'setting_section_id'
        );
        //network
        add_settings_field(
            'network', 
            'Coin Network', 
            array( $this, 'network_callback' ), 
            'saw-setting-admin', 
            'setting_section_id'
        );
        //info
        add_settings_field(
            'info', 
            'Info text', 
            array( $this, 'info_callback' ), 
            'saw-setting-admin', 
            'setting_section_id'
        );
        //read more
        add_settings_field(
            'readmore', 
            'Read more text', 
            array( $this, 'readmore_callback' ), 
            'saw-setting-admin', 
            'setting_section_id'
        );
        //read more url
        add_settings_field(
            'readmoreurl', 
            'Read more url', 
            array( $this, 'readmoreurl_callback' ), 
            'saw-setting-admin', 
            'setting_section_id'
        );
        //addresslabel
        add_settings_field(
            'addresslabel', 
            'Label for Address', 
            array( $this, 'addresslabel_callback' ), 
            'saw-setting-admin', 
            'setting_section_id'
        );
        //amountlabel
        add_settings_field(
            'amountlabel', 
            'Label for Amount', 
            array( $this, 'amountlabel_callback' ), 
            'saw-setting-admin', 
            'setting_section_id'
        );
        //devdonation
        add_settings_field(
            'devdonation', 
            'Donation to Developers(in %)', 
            array( $this, 'devdonation_callback' ), 
            'saw-setting-admin', 
            'setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['fullpageonly'] ) )
            $new_input['fullpageonly'] = sanitize_text_field( $input['fullpageonly'] );
        
        if( isset( $input['button_text'] ) )
            $new_input['button_text'] = sanitize_text_field( $input['button_text'] );

        if( isset( $input['address'] ) )
            $new_input['address'] = sanitize_text_field( $input['address'] );

        if( isset( $input['amount'] ) )
            $input['amount'] = str_replace(",", ".", $input['amount']);
            $new_input['amount'] = floatval( $input['amount'] );

        if( isset( $input['coinsign'] ) )
            $new_input['coinsign'] = sanitize_text_field( $input['coinsign'] );
            
        if( isset( $input['network'] ) )
            $new_input['network'] = sanitize_text_field( $input['network'] );
            
        if( isset( $input['info'] ) )
            $new_input['info'] = sanitize_text_field( $input['info'] );
            
        if( isset( $input['readmore'] ) )
            $new_input['readmore'] = sanitize_text_field( $input['readmore'] );
            
        if( isset( $input['readmoreurl'] ) )
            $new_input['readmoreurl'] = sanitize_text_field( $input['readmoreurl'] );

        if( isset( $input['addresslabel'] ) )
            $new_input['addresslabel'] = sanitize_text_field( $input['addresslabel'] );            

        if( isset( $input['amountlabel'] ) )
            $new_input['amountlabel'] = sanitize_text_field( $input['amountlabel'] );
        
        if( isset( $input['devdonation'] ) )
            $input['devdonation'] = str_replace(",", ".", $input['devdonation']);
            $new_input['devdonation'] = floatval( $input['devdonation'] );
            
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info_pluginbehaviour()
    {
        print '<p>This section is for Wordpress related behaviour.</p>';
    }
    public function print_section_info()
    {
        print '<p>Visit www.send-a-wow.org for a full configuration reference. This plugin is preconfigured for dogecoin (What else? ;-) ). 
               Just <strong>put your own Dogecoin address</strong> into the address field. 
               If you want use Bitcoin(/Litecoin/...) change the coin network to bitcoin 
               instead of dogecoin.(This is needed to create a correct qr code.)</p>
               <img style="width: 30em;" src="'.plugins_url( 'sendawow-explain-en.jpg' , __FILE__ ).'" alt="Change your coin address"/>';
    }

    /** 
     * Get the settings option array and print one of its values
     */
     //fullpageonly
    public function fullpageonly_callback()
    {
        //get option first (yes/no)
        $selectedyes='';
        $selectedno='';
        $fullpageonly = esc_attr( $this->options['fullpageonly']);
        if($fullpageonly) { //yes
            $selectedyes=' selected="selected"';
        } else {
            $selectedno=' selected="selected"';
        }
        //build the selectbox
        printf(
            '
            <select size="1" class="regular-text" type="text" id="fullpageonly" name="saw_options_general[fullpageonly]" value="%s" />
                <option'.$selectedyes.' value="1">Yes</option>
                <option'.$selectedno.' value="0">No</option>
            </select>
            ',
            esc_attr( $this->options['fullpageonly'])
        );
        print '<p class="description">If set to yes the button will only be shown on full blog pages, not at the topic sentence on the frontpage, etc.!</p>';
    }
    
    // button_text callback
    public function button_text_callback()
    {
        printf(
            '<input class="regular-text" type="text" id="button_text" name="saw_options_general[button_text]" value="%s" />',
            esc_attr( $this->options['button_text'])
        );
    }

    // address callback
    public function address_callback() {
        printf(
            '<input class="regular-text" type="text" id="address" name="saw_options_general[address]" value="%s" />',
            esc_attr( $this->options['address'])
        );
        print '<p class="description">Put YOUR Address here!</p>';
    }
    // amount callback
    public function amount_callback() {
        printf(
            '<input class="small-text" type="text" id="amount" name="saw_options_general[amount]" value="%s" />',
            esc_attr( $this->options['amount'])
        );
    }
    // coinsign callback
    public function coinsign_callback() {
        printf(
            '<input class="regular-text" type="text" id="coinsign" name="saw_options_general[coinsign]" value="%s" />',
            esc_attr( $this->options['coinsign'])
        );
    }
    // network callback
    public function network_callback() {
        printf(
            '<input class="regular-text" type="text" id="network" name="saw_options_general[network]" value="%s" />',
            esc_attr( $this->options['network'])
        );
    }
    // info callback
    public function info_callback() {
        printf(
            '<textarea class="large-text" id="info" name="saw_options_general[info]">%s</textarea>',
            esc_attr( $this->options['info'])
        );
    }
    // readmore callback
    public function readmore_callback() {
        printf(
            '<input class="regular-text" type="text" id="readmore" name="saw_options_general[readmore]" value="%s" />',
            esc_attr( $this->options['readmore'])
        );
    }
    // readmore url callback
    public function readmoreurl_callback() {
        printf(
            '<input class="regular-text" type="text" id="readmoreurl" name="saw_options_general[readmoreurl]" value="%s" />',
            esc_attr( $this->options['readmoreurl'])
        );
        echo '<p class="description">You can set your own page here. We suggest to write a blog-entry where you describe all the stuff to donate for you.</p>';
    }
    // addresslabel callback
    public function addresslabel_callback() {
        printf(
            '<input class="regular-text" type="text" id="addresslabel" name="saw_options_general[addresslabel]" value="%s" />',
            esc_attr( $this->options['addresslabel'])
        );
    }
    // amountlabel callback
    public function amountlabel_callback() {
        printf(
            '<input class="regular-text" type="text" id="amountlabel" name="saw_options_general[amountlabel]" value="%s" />',
            esc_attr( $this->options['amountlabel'])
        );
    }
    // devdonation callback
    public function devdonation_callback() {
        printf(
            '<input class="small-text" type="text" id="devdonation" name="saw_options_general[devdonation]" value="%s" />',
            esc_attr( $this->options['devdonation'])
        );
        echo '<p class="description">If you fill out this field there is a x% chance, that the address of the developer team is shown instead of yours. If you do not set it to 0 you help to keep this plugin free of cost and ads.</p>';
    }
}

if( is_admin() )
    $saw_settings_page = new SawSettingsPage();