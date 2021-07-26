<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;

use App\Models\ContentConfigurations;

class ContentConfigurationsController extends Controller{ 

    private $sections = [];

    public function __construct() {
        $this->middleware('guest:admin');
        $this->setSections( );
    }

    private function setSections(){
        $worldMapCountries = \Config::get('constants.world_map_countries');
        $this->sections = [
                'world_map' => [ 
                    'name' => 'World Map Countires',
                    'CONF_WORLD_MAP_COUNTRIES' => [
                        'label' => 'World Map Countries',
                        'type' => 'multiple_select',
                        'options' => $worldMapCountries
                    ]
                ],
                'contact_request_email' => [ 
                    'name' => 'Contact Request Emails',
                    'CONF_CONTACT_REQUEST_SEND_TO_EMAILS' => [
                        'label' => 'Contact Request Emails',
                        'type' => 'text',
                        'placeholder' => 'E.g sam@yopmail.com,joe@yopmail.com'
                    ]
                ],
                'contact' => [ 
                    'name' => 'Contact Section',
                    'CONF_CONTACT_ADDRESS' => [
                        'placeholder' => 'Enter Contact Address',
                        'label' => 'Contact Address',
                        'type' => 'text'
                    ],
                    'CONF_CONTACT_EMAIL' => [
                        'placeholder' => 'Enter Contact Email',
                        'label' => 'Contact Email',
                        'type' => 'email'
                    ],
                    'CONF_CONTACT_PHONE' => [
                        'placeholder' => 'Enter Contact Phone Number',
                        'label' => 'Contact Phone',
                        'type' => 'text'
                    ],
                    'CONF_CONTACT_SKYPE' => [
                        'placeholder' => 'Enter Contact Skype Address',
                        'label' => 'Contact Skype Address',
                        'type' => 'text'
                    ]
                ],
                'social' => [ 
                    'name' => 'Social Section',
                    'CONF_SOCIAL_FACEBOOK' => [
                        'placeholder' => 'Enter Facebook Page Link',
                        'label' => 'Facebook Link',
                        'type' => 'url'
                    ],
                    'CONF_SOCIAL_INSTA' => [
                        'placeholder' => 'Enter Instagram Page Link',
                        'label' => 'Instagram Link',
                        'type' => 'url'
                    ],
                    'CONF_SOCIAL_TWITTER' => [
                        'placeholder' => 'Enter Twitter Page Link',
                        'label' => 'Twitter Link',
                        'type' => 'url'
                    ],
                    'CONF_SOCIAL_YOUTUBE' => [
                        'placeholder' => 'Enter Youtube Page Link',
                        'label' => 'Youtube Link',
                        'type' => 'url'
                    ]
                ],
                'footer' => [ 
                    'name' => 'Footer Section',
                    'CONF_FOOTER_DESC' => [
                        'placeholder' => 'Enter Footer Description',
                        'label' => 'Footer Description',
                        'type' => 'textarea'
                    ],
                    'CONF_FOOTER_CONTACT_HEADING' => [
                        'placeholder' => 'Enter Footer Contact Heading',
                        'label' => 'Footer Contact Heading',
                        'type' => 'text'
                    ],
                    'CONF_FOOTER_COPYRIGHT' => [
                        'placeholder' => 'Enter Copyright Text',
                        'label' => 'Footer Copyright',
                        'type' => 'text'
                    ]
                ]
            ];
    }

    public function edit(  ) {
        
        $title = "Content Configurations";

        $data = ContentConfigurations::getAll();
        
        return view( 
                'admin.cms.content_configurations.edit',
                [ 
                    'title' => $title,
                    "breadcrumbItem" => $title,
                    "breadcrumbTitle" => $title,
                    "breadcrumbLink" => '',
                    "breadcrumbTitle2" => '',
                    'confs' => $data,
                    'sections' => $this->sections
                ]
            );
    }

    public function update( Request $request ) {

        $postedData = $request->all( );
        
        foreach( $this->sections as $fields ){
            foreach( $fields as $fieldName => $data ){
                if( $fieldName == 'name' ) continue;
                $ccObj = ContentConfigurations::find( $fieldName );
                
                $ccObj->cc_value = ( $data['type'] == 'multiple_select' )?
                                        serialize( 
                                                ( 
                                                    ( isset( $postedData[ $fieldName ] ) && 
                                                    $postedData[ $fieldName ] )?
                                                        $postedData[ $fieldName ]:[] 
                                                )
                                            ) : (
                                                isset( $postedData[ $fieldName ] ) ? 
                                                $postedData[ $fieldName ]:''
                                            );
                $ccObj->cc_serialize = $data['type'] == 'multiple_select'?1:0;
                $ccObj->save( );
            }
        }

        return redirect()->back()->with( 'success', 'Configuration updated!' );
    }
    
}