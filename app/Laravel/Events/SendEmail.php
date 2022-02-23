<?php namespace App\Laravel\Events;


use App\Laravel\Models\ContactInfo;
use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon;
// use App\Constech\Models\GeneralSetting;

class SendEmail extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(array $form_data)
	{
		$this->data['input'] = $form_data['input'];
		$this->data['type'] = $form_data['type'];

	}

	public function job(){	
		

		switch ($this->data['type']) {
			case 'booking':
			$data = ['email' => $this->data['input']['email'],'name' => $this->data['input']['name'],'contact_number' => $this->data['input']['contact_number'],'address' => $this->data['input']['address']];

			Mail::send('emails.booking', $data, function($message) use($data){
				$message->from('noreply@sonicexpress.com.ph');
				$message->to('book@sonicexpress.com.ph');
				$message->bcc('sonicexpress17@gmail.com');
				// $message->bcc("richardkennedy.domingo@yahoo.com");
				$message->subject("Booking Inquiry - {$data['name']} [".Helper::date_only(Carbon::now())."]");
			});
			break;
			
			default:
				
				$data = ['name' => $this->data['input']['name'],'email' => $this->data['input']['email'],'msg' => $this->data['input']['message'],'subject' => $this->data['input']['subject']];

				Mail::send('emails.inquiry', $data, function($message) use ($data){
					// $message->from($data['email'], $data['name']);
					$message->from('noreply@sonicexpress.com.ph');
					$message->to('info@sonicexpress.com.ph');
					$message->bcc('sonic.customercare1@gmail.com');
					// $message->bcc("richardkennedy.domingo@yahoo.com");
					$message->subject("Email Inquiry : {$data['subject']}");
				});

			break;
		}
		
	}
}
