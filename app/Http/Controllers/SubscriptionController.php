<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Subscription\CreateValidateRequest;
use App\Http\Requests\Subscription\PublishRequest;
use App\Services\SubscriptionService;

class SubscriptionController extends Controller
{

    /**
     * protected class property
     * @var   App\Services\SubscriptionService 
     */
    protected $SubscriptionService;

    
    public function __construct(SubscriptionService $SubscriptionService){
        $this->subscriptionService = $SubscriptionService;
    }


     /**
     * creating an instance of subscription model
     * @param array 
     * @param string   
     */
    public function create(CreateValidateRequest $request){

        $topic = $request->input("topic");

        $data = $request->validated();

       

        return $this->subscriptionService->create($data , $topic);
    }

    public function publish(PublishRequest $request){
        $data = $request->validated();
        return $this->subscriptionService->publish($data);
    }
}
