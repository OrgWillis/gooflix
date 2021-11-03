<?php
if (!defined('ABSPATH')) {
    die;
}
/**
 * @author LFVC
 * @since 1.0
 */


// All Settings
$settings = array(
    'menu_title' => sprintf(__('%s options', 'mega'), THEME),
    'menu_type' => 'theme',
    'menu_slug' => 'mega_theme',
    'ajax_save' => true,
    'show_reset_all' => false,
    'max_width' => '1200',
    'framework_title' => 'Mega Theme <small>by LFVC</small>'
);

// Framework Options
$options = array();

/**
 ************************
 * SETTINGS
 ************************
 */
$options[] = array(
    'title' => __('Settings'),
    'name' => 'settings',
    'icon' => 'fa fa-cog',
    'sections' => array(

        /**
         * Main Settings
         * @since 1.0
         * @version 1.0
         */
        array(
            'title' => __('Main settings', 'mega'),
            'name' => 'settings-main',
            'icon' => 'fa fa-minus',
            'fields' => array(
                array(
                    'type' => 'heading',
                    'content' => __('Options Site', 'mega')
                ),
                array(
                    'id' => 'permits',
                    'type' => 'checkbox',
                    'title' => __('General', 'mega'),
                    'desc' => __('Check whether to activate or deactivate', 'mega'),
                    'options' => array(
                        'rvrp' => __('Remove <code>?ver=</code> parameters', 'mega'),
                        'mhtm' => __('Minify HTML'),
                        'rhjp' => __('Remove HTML, Java Script and CSS Commnets', 'mega')
                    ),
                    'default' => array(
                        'enls',
                        'esst',
                        'demj',
                        'rvrp',
                        'mhtm',
                        'rhjp'
                    )
                ),
                
                array(
                    'type' => 'heading',
                    'content' => __('Pages for Mega Theme', 'mega')
                ),
                
                array(
                    'id' => 'pageapp',
                    'type' => 'select',
                    'title' => __('APP', 'mega'),
                    'desc' => __('Set App page', 'mega'),
                    'options' => 'pages',
                    'attributes' => array(
                        'style' => 'width:200px'
                    )
                ),
                
                array(
                    'id' => 'pageapi',
                    'type' => 'select',
                    'title' => __('API', 'mega'),
                    'desc' => __('Set User API page', 'mega'),
                    'options' => 'pages',
                    'attributes' => array(
                        'style' => 'width:200px'
                    )
                ),
                
                array(
                    'id' => 'pageaembed',
                    'type' => 'select',
                    'title' => __('Embed', 'mega'),
                    'desc' => __('Set User Embed page', 'mega'),
                    'options' => 'pages',
                    'attributes' => array(
                        'style' => 'width:200px'
                    )
                ),
                
                array(
                    'type' => 'heading',
                    'content' => __('Database cache', 'mega')
                ),
                
                array(
                    'id' => 'cachescheduler',
                    'type' => 'select',
                    'title' => __('Scheduler', 'mega'),
                    'desc' => __('Cache cleaning', 'mega'),
                    'after' => '<p>' . __('It is important to clean expired cache at least once a day', 'mega') . '</p>',
                    'attributes' => array(
                        'style' => 'width:200px'
                    ),
                    'options' => array(
                        'daily' => __('Daily', 'mega'),
                        'twicedaily' => __('Twice daily', 'mega'),
                        'hourly' => __('Hourly', 'mega')
                    )
                ),
                
                array(
                    'type' => 'notice',
                    'class' => 'info',
                    'content' => __('Storing cache as long as possible can be a very good idea', 'mega'),
                    'dependency' => array(
                        'cachetime',
                        '<=',
                        43200
                    )
                ),
                
                array(
                    'id' => 'cachetime',
                    'type' => 'number',
                    'title' => __('Cache Timeout', 'mega'),
                    'desc' => __('Set the time in seconds', 'mega'),
                    'default' => '86400',
                    'after' => '<p>' . __('We recommend storing this cache for at least 86400 seconds', 'mega') . '</p>',
                    'attributes' => array(
                        'style' => 'width:100px'
                    )
                )
            )
),

        /**
         * Customize
         * @since 2.1.8
         * @version 1.0
         */
        array(
            'title' => __('Customize', 'mega'),
            'name' => 'layout-custom',
            'icon' => 'fa fa-minus',
            'fields' => array(

                array(
                    'type' => 'heading',
                    'content' => __('Social', 'mega')
                ),
                
                array(
                    'id' => 'social',
                    'type' => 'switcher',
                    'title' => __('Social networks', 'mega'),
                    'label' => __('enable to use your social networks', 'mega'),
                    'default' => false
                ),
                
                array(
                    'id' => 'url_facebook',
                    'type' => 'text',
                    'title' => __('Facebook', 'mega'),
                    'dependency' => array(
                        'social',
                        '!=',
                        false
                    )
                ),
                
                array(
                    'id' => 'url_instagram',
                    'type' => 'text',
                    'title' => __('Instagram', 'mega'),
                    'dependency' => array(
                        'social',
                        '!=',
                        false
                    )
                ),
                
                array(
                    'type' => 'heading',
                    'content' => __('Site Color', 'mega')
                ),
                
                array(
                    'id' => 'maincolor',
                    'type' => 'color_picker',
                    'title' => __('Primary color', 'mega'),
                    'desc' => __('Choose a color', 'mega'),
                    'default' => '#FF4900'
                ),
                
                array(
                    'id' => 'bgcolor',
                    'type' => 'color_picker',
                    'title' => __('Background', 'mega'),
                    'desc' => __('Choose a color', 'mega'),
                    'default' => '#000000'
                ),
                
                array(
                    'type' => 'heading',
                    'content' => __('Customize logos', 'mega')
                ),
                
                array(
                    'id' => 'headlogo',
                    'type' => 'image',
                    'title' => __('Logo', 'mega'),
                    'desc' => __('Upload your logo using the Upload Button', 'mega')
                ),
                
                array(
                    'id' => 'favicon',
                    'type' => 'image',
                    'title' => __('Favicon'),
                    'desc' => __('Upload a 16 x 16 px image that will represent your website\'s favicon', 'mega')
                )
            )
        ),
        
        
        /**
         * Application Module
         * @since 1.0
         * @version 1.0
         */
        array(
            'title' => __('Apllication Module', 'mega'),
            'name' => 'layout-application',
            'icon' => 'fa fa-minus',
            'fields' => array(

                array(
                    'id' => 'maintenance',
                    'type' => 'switcher',
                    'title' => __('Apllication Maintenance', 'mega'),
                    'label' => __('use this option if necessary', 'mega'),
                    'default' => false
                ),
                
                array(
                    'type' => 'notice',
                    'class' => 'danger',
                    'content' => __('Your app is currently under <strong>maintenance</strong>', 'mega'),
                    'dependency' => array(
                        'maintenance',
                        '!=',
                        false
                    )
                ),
                
                array(
                    'id' => 'slider',
                    'type' => 'switcher',
                    'title' => __('Modo App Download', 'mega'),
                    'label' => __('use this option if necessary', 'mega'),
                    'default' => false
                ),
                
                array(
                    'id' => 'down_app',
                    'type' => 'image',
                    'title' => __('Download APP', 'mega'),
                    'desc' => __('Upload your 900x 1140 image using the Upload button', 'mega'),
                    'dependency' => array(
                        'slider',
                        '!=',
                        false
                    )
                ),
                
                array(
                    'id' => 'version_app',
                    'type' => 'text',
                    'title' => __('Version App', 'mega'),
                    'desc' => __('Insert the current version of your application', 'mega'),
                    'attributes' => array(
                        'placeholder' => '1.0',
                        'style' => 'width:200px'
                    )
                ),
                
                array(
                    'id' => 'categoryID',
                    'type' => 'select',
                    'title' => __('Category Default', 'mega'),
                    'desc' => __('Select a category for releases', 'mega'),
                    'options' => 'category',
                    'attributes' => array(
                        'style' => 'width:200px'
                    )
                ),
                
                array(
                    'id' => 'update',
                    'type' => 'switcher',
                    'title' => __('Update App', 'mega'),
                    'label' => __('enable the field to enable APP update', 'mega'),
                    'default' => false
                ),
                
                array(
                    'type' => 'notice',
                    'class' => 'info',
                    'content' => __('Your APP has the active update', 'mega'),
                    'dependency' => array(
                        'update',
                        '!=',
                        false
                    )
                ),
                
                array(
                    'id' => 'update_url',
                    'type' => 'text',
                    'title' => __('Link de Atualização', 'mega'),
                    'dependency' => array(
                        'update',
                        '!=',
                        false
                    )
                )
                
            )
        ),
        
        
        /**
         * Main Settings
         * @since 1.0
         * @version 1.0
         */
        array(
            'title' => __('Links Module', 'mega'),
            'name' => 'settings-links',
            'icon' => 'fa fa-minus',
            'fields' => array(

                array(
                    'id' => 'serve_default',
                    'type' => 'switcher',
                    'title' => __('Serve Default Player', 'mega'),
                    'label' => __('use this option if necessary', 'mega'),
                    'default' => false
                ),
                
                array(
                    'id' => 'link_default',
                    'type' => 'select',
                    'title' => __('Serve Player', 'mega'),
                    'desc' => __('default', 'mega'),
                    'attributes' => array(
                        'style' => 'width:200px'
                    ),
                    'options' => array(
                        'verystream' => __('Very Stream', 'mega'),
                        'openload' => __('Openload', 'mega'),
                        'thevid' => __('Thevid', 'mega'),
                        'dropbox' => __('DropBox', 'mega'),
                        'fembed' => __('Fembed', 'mega')
                    ),
                    'dependency' => array(
                        'serve_default',
                        '!=',
                        false
                    )
                ),
                
                array(
                    'id' => 'serve_remove',
                    'type' => 'switcher',
                    'title' => __('Remove Server Type', 'mega'),
                    'label' => __('use this option if necessary', 'mega'),
                    'default' => false
                ),
                
                array(
                    'id' => 'type_remove',
                    'type' => 'text',
                    'title' => __('Type Remove', 'mega'),
                    'desc' => __('Add comma separated values', 'mega'),
                    'attributes' => array(
                        'placeholder' => 'dropbox'
                    ),
                    'dependency' => array(
                        'serve_remove',
                        '!=',
                        false
                    )
                ),
                
                array(
                    'id' => 'ads_mode',
                    'type' => 'switcher',
                    'title' => __('Mode ADS Google', 'mega'),
                    'label' => __('use this option if necessary', 'mega'),
                    'default' => false
                ),
                
                array(
                    'id' => 'ads_link',
                    'type' => 'text',
                    'title' => __('Link', 'mega'),
                    'desc' => __('Add redirect link', 'mega'),
                    'attributes' => array(
                        'placeholder' => 'https://exemplo.com/'
                    ),
                    'dependency' => array(
                        'ads_mode',
                        '!=',
                        false
                    )
                ),
                
                array(
                    'id' => 'ads_mode_user',
                    'type' => 'switcher',
                    'title' => __('Mode ADS Autor', 'mega'),
                    'label' => __('Enable the option for authors to use their own ads', 'mega'),
                    'default' => false
                ),
                
                array(
                    'type' => 'heading',
                    'content' => __('Custom Links default', 'mega')
                ),
                
                array(
                    'id' => 'linkverystream',
                    'type' => 'text',
                    'title' => __('Very Stream', 'mega'),
                    'desc' => __('Add link', 'mega'),
                    'attributes' => array(
                        'placeholder' => 'https://verystream.com/e/'
                    )
                ),
                
                array(
                    'id' => 'linkopenload',
                    'type' => 'text',
                    'title' => __('Openload', 'mega'),
                    'desc' => __('Add link', 'mega'),
                    'attributes' => array(
                        'placeholder' => 'https://oload.tv/embed/'
                    )
                ),
                
                array(
                    'id' => 'linkthevid',
                    'type' => 'text',
                    'title' => __('Thevid', 'mega'),
                    'desc' => __('Add link', 'mega'),
                    'attributes' => array(
                        'placeholder' => 'https://thevid.tv/e/'
                    )
                ),
                
                array(
                    'id' => 'linkfembed',
                    'type' => 'text',
                    'title' => __('Fembed', 'mega'),
                    'desc' => __('Add link', 'mega'),
                    'attributes' => array(
                        'placeholder' => 'https://www.fembed.com/v/'
                    )
                )
                
            )
)

)
);


/**
 ************************
 * SEO
 ************************
 */
$options[] = array(
    'title' => __('SEO','mega'),
    'name' => 'seo',
    'icon' => 'fa fa-line-chart',
    'fields' => array(
        array(
            'id'    => 'seo',
            'type'  => 'switcher',
            'title' => __('SEO Features','mega'),
            'label' => __('Basic SEO','mega'),
        ),

        array(
            'type'       => 'notice',
            'class'      => 'info',
            'content'    => __('Uncheck this to disable SEO features in the theme, highly recommended if you use any other SEO plugin, that way the themes SEO features won\'t conflict with the plugin','mega'),
            'dependency' => array('seo','==', true)
        ),

        array(
            'id'         => 'seoname',
            'type'       => 'text',
            'title'      => __('Alternative name','mega'),
            'dependency' => array('seo','==', true)
        ),

        array(
            'id'         => 'seokeywords',
            'type'       => 'text',
            'title'      => __('Main keywords','mega'),
            'desc'       => __('add main keywords for site info','mega'),
            'dependency' => array('seo','==', true)
        ),

        array(
            'id'         => 'seodescription',
            'type'       => 'textarea',
            'title'      => __('Meta description','mega'),
            'dependency' => array('seo','==', true)
        ),

        array(
            'id'         => 'seoimage',
            'type'       => 'image',
            'title'      => __('Featured image','mega'),
            'desc'       => __('Upload a 400px by 400px image that will represent your site', 'mega'),
            'dependency' => array('seo','==', true)
        ),

        array(
            'id'      => 'descriptionfb',
            'type'    => 'textarea',
            'title'   => __('Facebook Description'),
            'default' => '{title}',
            'after'   => '<p><strong>Tags:</strong> {title}</p>',
        ),

        array(
            'id'      => 'descriptiontw',
            'type'    => 'textarea',
            'title'   => __('Twitter Description'),
            'default' => '{title}',
            'after'   => '<p><strong>Tags:</strong> {title}</p>',
        ),

        array(
            'type'    => 'heading',
            'content' => __('Site verification','mega'),
            'dependency' => array('seo','==', true)
        ),

        array(
            'id'         => 'seogooglev',
            'type'       => 'text',
            'title'      => __('Google Search Console','mega'),
            'after'       => '<p><a href="https://www.google.com/webmasters/verification/" target="_blank">'.__('Settings here','mega').'</a></p>',
            'dependency' => array('seo','==', true)
        ),

        array(
            'id'         => 'seobingv',
            'type'       => 'text',
            'title'      => __('Bing Webmaster Tools','mega'),
            'after'       => '<p><a href="https://www.bing.com/toolbox/webmaster/" target="_blank">'.__('Settings here','mega').'</a></p>',
            'dependency' => array('seo','==', true)
        ),

        array(
            'id'         => 'seoyandexv',
            'type'       => 'text',
            'title'      => __('Yandex Webmaster Tools','mega'),
            'after'       => '<p><a href="https://yandex.com/support/webmaster/service/rights.xml#how-to" target="_blank">'.__('Settings here','mega').'</a></p>',
            'dependency' => array('seo','==', true)
        )
    )
);

/**
 ************************
 * BACKUP
 ************************
 */
$options[] = array(
    'title' => __('Backup', 'mega'),
    'name' => 'backup',
    'icon' => 'fa fa-database',
    'fields' => array(
        array(
            'type' => 'backup'
        )
    )
);


// Class Codestar Framework
CSFramework::instance($settings, $options);
