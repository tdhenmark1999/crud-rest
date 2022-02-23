<?php

namespace App\Laravel\Controllers\Frontend;
use App\Laravel\Models\Inquiries;
use App\Laravel\Models\About;
use App\Laravel\Models\Banner;
use App\Laravel\Models\Team;
use App\Laravel\Models\webinfo;
use App\Laravel\Models\Article;
use App\Laravel\Models\Service;
use App\Laravel\Models\VideoArchive;
use App\Laravel\Models\News;
use App\Laravel\Requests\Frontend\InquiryRequest;
use App\Laravel\Events\SendEmail;



use Helper, Carbon, Session, Str, DB,Input,Event;

class MainController extends Controller
{	
	protected $data;

	public function __construct () {
		
	}

    public function index(){
   
			return view ('frontend.homepage');
	}

}
