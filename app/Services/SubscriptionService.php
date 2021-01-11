<?php
namespace App\Services;

use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\SubscriptionResource;
use App\Repositories\SubscriptionRepository;
use App\Repositories\TopicRepository;
use App\Repositories\TopicMessageRepository;



class SubscriptionService{

    /**
     * Using the ResponseTrait
     * 
     * @var  \App\Traits\ResponseTrait
     */
    use ResponseTrait;
    
    
    /**
     *  subscription Repository  instance
     *  topic Repository instance
     * @var \App\Repositories\Subscription
     * @var \App\Repositories\Topic
     */
    protected $SubscriptionRepository;
    protected $TopicRepository;
    protected $TopicMessageRepository;



    /**
     * constant variables for this instance
     * @return void
     */
     const created_success_message = "Subscription Created Successfully";
     const invalid_subscription = "Invalid Subscription ";
     const active_subscribed_message =" Susbcribed Message Resource";


    /**
     * Create a new subscription service instance
     * @param \App\Repository\SubscriptionRepository  
     * @param \App\Repository\TopicRepository  
     * @return void
     */
     public function __construct(SubscriptionRepository $SubscriptionRepository, TopicRepository $TopicRepository , TopicMessageRepository $TopicMessageRepository){
         $this->SubscriptionRepository = $SubscriptionRepository;
         $this->TopicRepository = $TopicRepository;
         $this->TopicMessageRepository = $TopicMessageRepository;
     }



     /**
      * create a subscription instance
      * @param array $data
      * @return void
      */

      public function create(array $data , string $topic){

            $checkTopic = $this->TopicRepository->getModelByName($topic)->first();

            

          //begin database transaction
          if(is_null($checkTopic)){
              $checkTopic = $this->createTopic($topic);  
          }

            DB::beginTransaction();

            try{

                $createDetails = ["topic_id" => $checkTopic->id , "url"=> $data["url"]];

                

                $create = $this->SubscriptionRepository->create($createDetails);

            }catch(Exception $e){
                DB::rollback();
                return $this->Exception($e);
            }
            DB::commit();

            $data = ["subscription" =>   new SubscriptionResource($create)];

            return $this->success( $data , self::created_success_message  , $this->code201);
      }


    
      public function createTopic($topic){
          DB::beginTransaction();

          try{

            $createDetails = [ "name" => $topic];
            
            $create = $this->TopicRepository->create($createDetails);

          }catch(Exception $e){
              DB::rollback();

              return $this->Exception($e);
          }

          DB::commit();

          return $create;
      }

      

     /**
      * publish message to subcribers
      * @param array $data
      * @return void
      */
      public function publish(array $data){
         
        $subscribersMessageList = [];
        $topic = $this->TopicRepository->getModelByName($data["topic"])->first();

        
        $subscriber =$this->SubscriptionRepository->whereColumn(['topic_id'=> $topic->id])->get();


 
        if(count($subscriber) < 1){
            return $this->error(self::invalid_subscription , $this->code422);
        }


        DB::beginTransaction();

        try{

            if(count($subscriber) >= 1){
                foreach($subscriber as $item)
                
                $createDetail = [
                    'topic_id' => $topic->id,
                    'message_id'=> $data["data"]["id"]
                ];

                

                $create = $this->TopicMessageRepository->create($createDetail);
     
            }else{
                $createDetail = [
                    'topic_id' => $topic->id,
                    'message_id'=> $data["data"]["id"]
                ];

                $create = $this->TopicMessageRepository->create($createDetail);
            }

           
        }catch(Exception $e){
            DB::rollback();

            return $this->Exception($e);  
        }

        DB::commit();

        $getSub = DB::table("topic_messages as tm")
                        ->selectRaw("t.name as name , m.body as text , s.id as id")
                        ->leftjoin("subscriptions as s" , "s.topic_id" , "=", "tm.topic_id")
                        ->leftjoin("topics as t" , "t.id", '=' , 's.topic_id')
                        ->leftjoin("messages as m" , "m.id" , '=' , "tm.message_id")
                        ->where("t.id" , '=' , $topic->id)
                        ->distinct()
                        ->get();

             

        
        foreach($getSub as $item){
            
            $listDetail = ["susbcriber_id" => $item->id ,"topic"=> $item->name , "message" =>$item->text];
            array_push($subscribersMessageList , $listDetail);
        }

        $data = ['subscribers'=>$subscribersMessageList];

         return $this->success($data , self::active_subscribed_message , $this->code201);

      }

}

