<?php 

namespace App\Traits;
 

use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;
 
trait ResponseTrait
{
    /**
     * The attributes that specifies the failure status of our api.
     *
     * @var string
     */
    protected $FailureStatus = 'failed';


    /**
     * The attributes that specifies the Success status of our api.
     *
     * @var string
     */
    protected $SuccessStatus = 'success';

    /**
     * The attributes that specifies http codes to be used.
     *
     * @var string
     */
    protected $code400 = 400;
    protected $code401 = 401;
    protected $code403 = 403;
    protected $code404 = 404;
    protected $code405 = 405;
    
    protected $code409 = 409;
    protected $code200 = 200;
    protected $code201 = 201;
    protected $code422 = 422;
    protected $code424 = 424; //'Failed Dependency'
    protected $code429 = 429;
    protected $code444 = 444; //Connection closed without response
    protected $code408 = 408; //Request time out
    protected $code417 = 417; //Expectation Failed
    protected $code503 = 503; //'Service Unavailable'
    protected $code504 = 504; //Gateway Timeout
    protected $code500 = 500; //Internal Server Error
    protected $code412 = 412; //Precondition Failed

    protected $code501 = 501; //'Not Implemented',

    protected $code599 = 599; //Network Connect Timeout Error
    protected $code413 = 413; //'Payload Too Large'
    protected $code407 = 407; //'Proxy Authentication Required'
	
 
	public function success($data,$message,$code)
	{
		return response()->json([
            'status'=>$this->SuccessStatus,
            'message'=>$message,
            'data'=>$data
        ],$code);
	}
 
    public function Exception(Exception $exception)
    {
        return $this->error($exception->getMessage() , $this->code500 , [
            'message'  => $exception->getMessage(),
            'file'     => $exception->getFile(),
            'line'     => $exception->getLine(),
            'trace'    => $exception->getTrace(),

        ]);
    }


  

    public function error($message="",$code){
        if($message instanceof MessageBag){
            foreach($message->getmessages() as $key => $value){

                $message = "'{$key}' : {$value[0]}";
                break;
            }
        }

        return response()->json([
            'status'=>$this->FailureStatus,
            'message'=>$message,
            'data'=>null
        ],$code);
    }
}