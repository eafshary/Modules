<?php

namespace App\Modules\DummyBasename\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class ExampleMutation extends Mutation {

    protected $attributes = [
        'name' => 'ExampleMutation'
    ];
    
    public function type()
    {
        return GraphQL::type('users'); 
    }
    
    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
            'email' => ['name' => 'password', 'type' => Type::string()]
        ];
    }

    public function rules()
    {
        return [
            'id' => ['required'],
            'email' => ['required', 'email']
        ];
    }
    
    public function resolve($root, $args)
    {
        // $user = User::whereEmail($args['email'])->first();
        // if(!$user)
        // {
        //     return null;
        // }
        
        // $user->password = bcrypt($args['password']);
        // $user->save();
        
        // return $user;
    }

}