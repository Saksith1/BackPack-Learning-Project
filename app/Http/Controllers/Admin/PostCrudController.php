<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostRequest;
use App\Models\CategoryPost;
use App\Models\Post;
use App\Models\Trainer;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


/**
 * Class PostCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PostCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {update as traitUpdate;}
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Post::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/post');
        CRUD::setEntityNameStrings('post', 'posts');

       

        //my view
        // $this->crud->setShowView('test');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //filter trainer
        $this->crud->addFilter([
                'name' => 'trainer_id',
                'label' => 'Trainers',
                'type' => 'Select2',
            ],
                function(){
                return Post::rightJoin('trainers', 'trainers.id', '=', 'posts.trainer_id')
                                    ->select('trainers.*')->get()->pluck('name', 'id')->toArray();
                },
                function($value) {
                    $this->crud->addClause('where', 'trainer_id', $value);
            },
        );
        //filter user
        $this->crud->addFilter([
            'name' => 'user_id',
            'label' => 'Users',
            'type' => 'Select2',
        ],
            function(){
            return Post::rightJoin('users', 'users.id', '=', 'posts.user_id')
                                ->select('users.*')->get()->pluck('name', 'id')->toArray();
            },
            function($value) {
                $this->crud->addClause('where', 'user_id', $value);
        },
        );
        // date filter
        $this->crud->addFilter([
            'type'  => 'date',
            'name'  => 'created_at',
            'label' => 'Date'
        ],
        false,
        function ($value) { // if the filter is active, apply these constraints
            $this->crud->addClause('where', 'created_at', $value);
        });
    
        //filter category
        $this->crud->addFilter([
                'name' => 'category_id',
                'label' => 'Category',
                'type' => 'Select2',
            ],

                function(){
                return CategoryPost::rightJoin('categories','categories.id','=','category_posts.category_id')
                            ->select('categories.*')->get()->pluck('title', 'id')->toArray();
                },
                function($value) {
                    $this->crud->addClause('where', 'title', $value);
            },
        );
        
        //list view
        CRUD::addColumn([
            'label'=>'ID',
            'name'=>'id',
        ]);
        CRUD::addColumn([
            'label'=>'User',
            'name'=>'user_id',
            'type'=>'relationship'
        ]);
        CRUD::addColumn([
            'label'=>'Trainer',
            'name'=>'trainer_id',
            'type'=>'relationship'
        ]);
        CRUD::addColumn([
            'label'=>'Title',
            'name'=>'title',
        ]);
        CRUD::addColumn([
            'label'=>'Body',
            'name'=>'body',
        ]);
        CRUD::addColumn([
            'name' => 'image',
            'type' => 'customimage',
            'prefix'    => 'images/',
            'label' => 'Thumbnail',
        ]);
        CRUD::addColumn([
            'label'=>'Created By',
            'name'=>'created_by',
        ]);
        CRUD::addColumn([
            'label'=>'Updated By',
            'name'=>'updated_by',
        ]);
        CRUD::addColumn([
            'label'=>'Created',
            'name'=>'created_at',
        ]);
        CRUD::addColumn([
            'label'=>'Updated',
            'name'=>'Updated_at',
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
  
    
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PostRequest::class);

        CRUD::field('title');
        
        //api
        // CRUD::addField([
        //     'label'       => "Trainer", // Table column heading
        //     'type'        => "select2_from_ajax",
        //     'name'        => 'trainer_id', // the column that contains the ID of that connected entity
        //     'entity'      => 'trainers', // the method that defines the relationship in your Model
        //     'attribute'   => "name", // foreign key attribute that is shown to user
        //     'data_source' => url("api/trainer"), // url to controller search function (with /{id} should return model)
        //     'placeholder'             => "Select a Trainer", // placeholder for the select
        //     'minimum_input_length' => 1,
        // ]);
        CRUD::addField([
            'label'       => "Trainer", // Table column heading
            'type'        => "relationship",
            'name'        => 'trainer', // the column that contains the ID of that connected entity
            // 'entity'      => 'trainers', // the method that defines the relationship in your Model
            // // 'attribute'   => "name", // foreign key attribute that is shown to user
            // 'data_source' => url("api/trainer"), // url to controller search function (with /{id} should return model)
            'placeholder'             => "Select a Trainer", // placeholder for the select
            'minimum_input_length' => 1,
            'ajax' => true,
            'inline_create' => [ // specify the entity in singular
                'entity' => 'trainer', // the entity in singular
                // OPTIONALS
                'force_select' => true, // should the inline-created entry be immediately selected?
                // 'modal_class' => 'modal-dialog modal-xl', // use modal-sm, modal-lg to change width
                'modal_route' => route('trainer-inline-create'), // InlineCreate::getInlineCreateModal()
                'create_route' =>  route('trainer-inline-create-save'), // InlineCreate::storeInlineCreate()
                // 'include_main_form_fields' => ['field1', 'field2'], // pass certain fields from the main form to the modal
            ]
        ]);

        //fetch oparation
        // CRUD::addField([
        //     'method' => 'POST',
        //     'name' => 'trainer_id',
        //     'type' => 'select2_from_ajax',
        //     'entity' => 'trainer',
        //     'attribute' => 'name',
        //     // 'data_source'  => url("api/trainers"),
        //     'delay' => 500,
        //     // 'model' => 'App\Models\Trainer',
        //     'placeholder' => 'Please select a trainer',
        //     'minimum_input_length' => 0,
        //     'data_source' => url('admin/post/fetch/trainer')
        // ]);

        //none ajax
        // CRUD::addField([
        //     'label'       => "Category", // Table column heading
        //     'type'        => "select2_from_ajax",
        //     'name'        => 'categories', // the column that contains the ID of that connected entity
        //     'entity'      => 'categories', // the method that defines the relationship in your Model
        //     'attribute'   => "title", // foreign key attribute that is shown to user
        //     'data_source' => url("api/category"), // url to controller search function (with /{id} should return model)
        //     'placeholder'             => "Select a category", // placeholder for the select
        //     'minimum_input_length' => 1
        // ]);
       
        //ajax
        // CRUD::addField([
        //     'label'       => "Category", // Table column heading
        //     'type'        => "select2_from_ajax_multiple",
        //     'name'        => 'categories', // a unique identifier (usually the method that defines the relationship in your Model) 
        //     'entity'      => 'categories', // the method that defines the relationship in your Model
        //     'attribute'   => "title", // foreign key attribute that is shown to user
        //     'data_source' => url("/api/category"), // url to controller search function (with /{id} should return model)
        //     'pivot'       => true, // on create&update, do you need to add/delete pivot table entries?

        //     // OPTIONAL
        //     'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
        //     'model'                => "App\Models\Category", // foreign key model
        //     'placeholder'          => "Select a Category", // placeholder for the select
        //     'minimum_input_length' => 1, // minimum characters to type before querying results
        //     // 'include_all_form_fields'  => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            
        // ]);
        CRUD::addField([
            'label' => "Category",
            'name' => 'categories',
            'type' => 'select2_multiple',
            'entity' => 'categories',
            'attribute' => 'title',
        ]);
        CRUD::field('body')->type('ckeditor');
        
        CRUD::addField([
            'name'=>'user_id',
            'type'=>'hidden',
            'value'=> backpack_user()->id,
        ]);

        CRUD::addField([
            'name'=>'created_by',
            'type'=>'hidden',
            'value'=>backpack_user()->name,
        ]); 

        $this->crud->addField([
            'label' => "Thumbnail",
            'name' => "image",
            'type' => 'image',
            'default'=>'nothumbnail.jpg',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            'prefix'    => 'images/' 
            // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
    //overwhite method
    public function update()
    {
        $this->crud->addField(['type' => 'hidden', 'name' => 'updated_by']);
        request()->merge(['updated_by' => backpack_user()->id]);

        return  $this->traitUpdate();
    }
    public function fetchTrainer(){
        return $this->fetch([
             'model'=> Trainer::class,
             'paginate'=> 2,
             'query'=>function ($model){
                 return $model->where('name','Like','%'.request()->q.'%');
             }
        ]);
    }

}
