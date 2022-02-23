<?php 

namespace App\Laravel\Transformers;

use Input;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\Resource\Collection;
use App\Laravel\Models\WishlistTransaction;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Serializer\DataArraySerializer;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use App\Laravel\Transformers\WishlistTransactionTransformer;

class TransformerManager
{
	public function transform($data, $transformer, $type = 'item')
	{
		$manager = new Manager();
		$manager->setSerializer(new DataArraySerializer());

		if(Input::has('include')) {
			$includes = str_replace(" ", "", Input::get('include'));
		    $manager->parseIncludes($includes);

		    // Eager load relationships found in includes
		    // if the data is an Eloquent object or LengthAwarePaginator.
		    // if($data instanceof Model OR $data instanceof LengthAwarePaginator) {

	    	// 	$relationships = array();

		    //     foreach (explode(",", $includes) as $relationship) {
		            
		    //     	if($transformer instanceof WishlistTransactionTransformer) {
		    //     		// If an include is related to the wishlist 
			   //          // rather than this record, load from the wishlist.
			   //          if(in_array($relationship, ['logs', 'tracker', 'comments'])) {
			   //              $relationship = "wishlist.{$relationship}";
			   //          }
		    //     	}

		    //         array_push($relationships, $relationship);
		    //     }

		    //     try {
		    //         $data->load($relationships);
		    //     } catch (RelationNotFoundException $e) {
		    //         // Do nothing
		    //     }
	    	// }
		    
		}

		if($type == 'item')
		{
			$resource = new Item($data, $transformer);
		}
		else
		{
			$resource = new Collection($data, $transformer);
		}
		
		$data = $manager->createData($resource)->toArray();

		// We want to return data key
		return $data['data'];
	}
}

