<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;

use App\Models\Pages;
use App\Models\PageContent;

class PagesController extends Controller{ 

    private $sectionVisible = [];

    public function __construct() {
        $this->middleware('guest:admin');
        $this->setSectionVisible( );
    }

    private function setSectionVisible(){
        $this->sectionVisible = [
                'HOME' => [ 
                        'SECTION_2' => ['title'],
                        'SECTION_5' => ['title'],
                        'SECTION_10' => ['title','image']
                    ],
                'ABOUT_US' => [ 
                    'SECTION_2' => ['title', 'desc']
                ],
                'HOW_IT_WORKS' => [ 
                    'SECTION_2' => ['title']
                ],
                'CONTACT_US' => [ 
                    'SECTION_2' => ['title'],
                    'SECTION_3' => ['title','desc']
                ]
            ];
    }
    
    public function index( ){
        $title = "Pages";
        return view('admin.cms.pages.index', [ 'title' => $title, "breadcrumbItem" => "Pages" , "breadcrumbTitle"=>"Pages", "breadcrumbLink" =>"", "breadcrumbTitle2"=> ""]);
    }

    public function list( Request $request) { 

        $requestedData  = $request->all();

        $draw           = ( isset( $requestedData[ 'draw' ] ) && $requestedData[ 'draw' ] > 0 )?$requestedData[ 'draw' ]:1;
        $start          = ( isset( $requestedData[ 'start' ] ) && $requestedData[ 'start' ] > 0 )?$requestedData[ 'start' ]:0;
        $perPage        = ( isset( $requestedData[ 'length' ] ) && $requestedData[ 'length' ] > 0 )?$requestedData[ 'length' ]:10;
        $search         = ( isset( $requestedData[ 'search' ] ) && isset( $requestedData[ 'search' ][ 'value' ] ) )?$requestedData[ 'search' ][ 'value' ]:'';
        
        $orderColumn    = ( isset( $requestedData[ 'order' ] ) && isset( $requestedData[ 'order' ][ 0 ] ) && isset( $requestedData[ 'order' ][ 0 ][ 'column' ] ) )?$requestedData[ 'order' ][ 0 ][ 'column' ]:0;
        $orderDir        = ( isset( $requestedData[ 'order' ] ) && isset( $requestedData[ 'order' ][ 0 ] ) && isset( $requestedData[ 'order' ][ 0 ][ 'dir' ] ) )?$requestedData[ 'order' ][ 0 ][ 'dir' ]:'ASC';

        $pagesTblName        = with( new Pages )->getTable( ); 
        $orderByColumns = [ 0 => $pagesTblName . '.page_title', 1 => $pagesTblName . '.page_title' ];

        $pageObj = Pages::orderBy( $orderByColumns[ $orderColumn ], $orderDir );

        $totalItems = $pageObj->count( );

        if( $search ) { 
            $pageObj->where( $pagesTblName . '.page_title', 'like', "%{$search}%" );
        }

        $recordsFiltered = $pageObj->count( );

        $pages = $pageObj->offset( $start )->limit( $perPage )->get( );

        $data = [ "draw" => $draw, "recordsTotal" => $totalItems, "recordsFiltered" => $recordsFiltered, "data" => [] ];
        if( $pages->count( ) > 0 ) { 
            foreach( $pages as $page ) { 

                $data[ 'data' ][] = [ 
                                    ++$start,
                                    $page->page_title,
                                    '<a href="' . route('admin.edit_page', [ 'key'=> base64_encode( $page->page_key ) ] ) . '" class="add" title=""><i class="fa fa-edit"></i></a>'
                                ];
            }
        }

        return response( )->json($data);
    }

    public function edit( $pageKey ) {
        if( !$pageKey ) { 
            return redirect( )->route( 'admin.pages' )->with('errors', 'Invalid Request');
        }
        $decodedPageKey = base64_decode( $pageKey );

        $page = Pages::with( [ 'pageContent' => function( $q ){
            $q->orderBy( 'pc_order', 'ASC' );
        } ] )->find( $decodedPageKey );

        if( !$page ) { 
            return redirect( )->route( 'admin.pages' )->with('errors', 'Selected page not found');
        }
        
        $title = "Edit Page: " . $page->page_title;
        
        return view( 
                'admin.cms.pages.edit',
                [ 
                    'title' => $title,
                    "breadcrumbItem" => "Pages",
                    "breadcrumbTitle" => "Pages",
                    "breadcrumbLink" => 'admin.pages',
                    "breadcrumbTitle2" => $title,
                    'page' => $page,
                    'sectionVisible' => isset( $this->sectionVisible[ $decodedPageKey ] )?$this->sectionVisible[ $decodedPageKey ]:[]
                ]
            );
    }

    public function update( $pageKey, Request $request ) {

        if( !$pageKey ) { 
            return redirect( )->route( 'admin.pages' )->with('custom_errors', 'Invalid Request');
        }

        $decodedPageKey = base64_decode( $pageKey );

        $page = Pages::with( [ 'pageContent' => function( $q ){
            $q->orderBy( 'pc_section_id', 'ASC' );
        } ] )->find( $decodedPageKey );

        if( !$page ) { 
            return redirect( )->route( 'admin.pages' )->with('custom_errors', 'Invalid Request');
        }
        
        $validator = $request->validate([
            'title' => 'required|max:150',
            'meta_title' => 'max:150',
            'content.*.title' => 'max:100',
            'content.*.image' => 'sometimes|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'content.*.title.max' => 'The title may not be greater than :max characters.',
            'content.*.image.mimes' => 'The image field must be a file of type: jpeg, png, jpg, gif, svg',
            'content.*.image.max' => 'The max image size should not be greater then 2M',
        ]);
        
        if( !$page ) { 
            return redirect( )->route( 'admin.pages' )->with('custom_errors', 'Selected page not found');
        }

        $page->page_title = strip_tags( $request->title );
        $page->page_meta_title = strip_tags( $request->meta_title );
        $page->page_meta_desc = strip_tags( $request->meta_desc );
        $page->page_meta_keywords = strip_tags( $request->meta_keywords );
        $isUpdated = $page->save();
        if( !$isUpdated ) { 
            return redirect( )->back( )->with('custom_errors', 'Something went wrong to update page, please try again later.');
        }

        $contentNeedToUpdate = $request->get( 'content' );

        foreach( $page->pageContent as $pageContent ){

            $sectionId = $pageContent->pc_section_id;
            $imageField = isset( $request->content[ $sectionId ][ 'image' ] )?$request->content[ $sectionId ][ 'image' ]:false;
            $fileName = $pageContent->pc_image;

            if( $imageField ) { 
                $uploadPath = public_path('upload/pages/');
                $imageName = time( ).'-' . $imageField->getClientOriginalName( );
                $uploadedFile = $imageField->move( $uploadPath, $imageName );
                if( $uploadedFile ) { 
                    if( $fileName ){
                        $filename = $uploadPath.$fileName;
                        \File::delete($filename);
                    }

                    $fileName = $uploadedFile->getFilename( );
                }
            }

            $isUpdate = PageContent::where('pc_page_key', $decodedPageKey )
                                    ->where('pc_section_id', $sectionId )
                                    ->update([
                                        'pc_title' => isset( $contentNeedToUpdate[ $sectionId ][ 'title' ] )?strip_tags( $contentNeedToUpdate[ $sectionId ][ 'title' ] ):'',
                                        'pc_description' => isset( $contentNeedToUpdate[ $sectionId ][ 'desc' ] )?strip_tags( $contentNeedToUpdate[ $sectionId ][ 'desc' ] ):'',
                                        'pc_image' => $fileName
                                    ]);
        }

        return redirect()->back()->with( 'success', 'Page has been updated!' );
    }
    
}