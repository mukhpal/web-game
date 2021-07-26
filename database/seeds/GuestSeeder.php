<?php

use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ci_guests')->insert([
        	[
	            'name' => 'Daniel Pembroke',
	            'role' => 'Host',
	            'type' => 1,
	            'age'	=>	55,
	            'height' => 5.10,
	            'weight' => 170,
	            'eye_color' => 'Green',
	            'hair_color' => 'Silver',
	            'vehicle_no' => 'IWJ 3202',
	            'description' => 'Business magnate, fine art collector, owner of Walnut Grove Mansion',
	            'image' => 'img_001.jpg',
	            'fingerprints_img'	=>	'1.jpg',
	            'search_house_img'	=>	'bad_luck.png',
	            'search_house_link'	=>	'#'
        	],
        	[
	            'name' => 'Marcia Pembroke',
	            'role' => 'Hostess',
	            'type' => 1,
	            'age'	=>	54,
	            'height' => 5.7,
	            'weight' => 135,
	            'eye_color' => 'Blue',
	            'hair_color' => 'Light Brown',
	            'vehicle_no' => 'IFE 9451',
	            'description' => 'Lawyer. Wife of Daniel Pembroke',
	            'image' => 'img_002.jpg',
	            'fingerprints_img'	=>	'2.jpg',
	            'search_house_img'	=>	'bad_luck.png',
	            'search_house_link'	=>	'#'
        	],
        	[
	            'name' => 'Charles Ives',
	            'role' => 'Professor',
	            'type' => 1,
	            'age'	=>	62,
	            'height' => 6.2,
	            'weight' => 181,
	            'eye_color' => 'Blue',
	            'hair_color' => 'Gray',
	            'vehicle_no' => 'IKT 1487',
	            'description' => 'Professor of art history, art expert, restoration, author, artist, curator consultant . Professor Ives had been trying to acquire the Black Square painting for the local museum for which he is curator. The museum lost out to Daniel Pembroke whom outbid him',
	            'image' => 'img_003.jpg',
	            'fingerprints_img'	=>	'3.jpg',
	            'search_house_img'	=>	'black_gloves.png',
	            'search_house_link'	=>	'crimeinvestigation.compare_gloves'
        	],
        	[
	            'name' => 'Amanda Pembroke',
	            'role' => 'Niece',
	            'type' => 1,
	            'age'	=>	24,
	            'height' => 5.7,
	            'weight' => 135,
	            'eye_color' => 'Blue',
	            'hair_color' => 'Blonde',
	            'vehicle_no' => 'STF 9051',
	            'description' => 'Art student, aspiring business owner. Daniel’s/Marcia’s niece',
	            'image' => 'img_004.jpg',
	            'fingerprints_img'	=>	'4.jpg',
	            'search_house_img'	=>	'bad_luck.png',
	            'search_house_link'	=>	'#'
        	],
        	[
	            'name' => 'Brandon Pembroke',
	            'role' => 'Nephew',
	            'type' => 1,
	            'age'	=>	26,
	            'height' => 6.2,
	            'weight' => 170,
	            'eye_color' => 'Blue',
	            'hair_color' => 'Light Brown',
	            'vehicle_no' => 'ABP 5280',
	            'description' => 'Living off of trust fund his uncle Daniel Pembroke administrates. Daniel’s/Marcia’s nephew',
	            'image' => 'img_005.jpg',
	            'fingerprints_img'	=>	'5.jpg',
	            'search_house_img'	=>	'bad_luck.png',
	            'search_house_link'	=>	'#'
        	],
        	[
	            'name' => 'Sarah Abernathy',
	            'role' => 'Reporter',
	            'type' => 1,
	            'age'	=>	27,
	            'height' => 5.8,
	            'weight' => 140,
	            'eye_color' => 'Brown',
	            'hair_color' => 'Dark Brown',
	            'vehicle_no' => 'JAT 3834',
	            'description' => 'Photographer, journalist, writes for local paper. Reporter covering party and secretly dating Brandon.',
	            'image' => 'img_006.jpg',
	            'fingerprints_img'	=>	'6.jpg',
	            'search_house_img'	=>	'party_photos_thumb.png',
	            'search_house_link'	=>	'crimeinvestigation.partyphotos'
        	],
        	[
	            'name' => 'Dr. Jerome Cambridge',
	            'role' => 'Neighbor',
	            'type' => 1,
	            'age'	=>	55,
	            'height' => 6.3,
	            'weight' => 185,
	            'eye_color' => 'Brown',
	            'hair_color' => 'Gray',
	            'vehicle_no' => 'MRU 3170',
	            'description' => 'Physician. Neighbor, and friend of Daniel',
	            'image' => 'img_007.jpg',
	            'fingerprints_img'	=>	'7.jpg',
	            'search_house_img'	=>	'bad_luck.png',
	            'search_house_link'	=>	'#'
        	],
        	[
	            'name' => 'Mason Jarvis',
	            'role' => 'Business partner',
	            'type' => 1,
	            'age'	=>	39,
	            'height' => 6.4,
	            'weight' => 182,
	            'eye_color' => 'Brown',
	            'hair_color' => 'Brown',
	            'vehicle_no' => 'GQB 1465',
	            'description' => 'Business magnate, Daniel Pembroke;s business partner',
	            'image' => 'img_008.jpg',
	            'fingerprints_img'	=>	'8.jpg',
	            'search_house_img'	=>	'bad_luck.png',
	            'search_house_link'	=>	'#'
        	],
        	[
	            'name' => 'Claire',
	            'role' => 'Housekeeper',
	            'type' => 2,
	            'age'	=>	30,
	            'height' => 5.4,
	            'weight' => 140,
	            'eye_color' => 'Brown',
	            'hair_color' => 'Brown',
	            'vehicle_no' => 'NHB 5010',
	            'description' => 'Housekeeper. Joined the family around 6 months ago. Comes from not that well to do family.',
	            'image' => 'img_009.jpg',
	            'fingerprints_img'	=>	'9.jpg',
	            'search_house_img'	=>	'bad_luck.png',
	            'search_house_link'	=>	'#'
        	],
        	[
	            'name' => 'Tim',
	            'role' => 'House Painter',
	            'type' => 2,
	            'age'	=>	27,
	            'height' => 5.5,
	            'weight' => 172,
	            'eye_color' => 'Black',
	            'hair_color' => 'Black',
	            'vehicle_no' => 'OFK 4643',
	            'description' => 'House Painter with a history of stealing things from houses.',
	            'image' => 'img_0010.jpg',
	            'fingerprints_img'	=>	'10.jpg',
	            'search_house_img'	=>	'gloves.png',
	            'search_house_link'	=>	'crimeinvestigation.compare_gloves'
        	],
        	[
	            'name' => 'Carlos',
	            'role' => 'Chef',
	            'type' => 2,
	            'age'	=>	42,
	            'height' => 5.8,
	            'weight' => 154,
	            'eye_color' => 'Brown',
	            'hair_color' => 'Brown',
	            'vehicle_no' => 'OIF 9444',
	            'description' => 'Celebrity Chef. One of the best-known chefs in the city. ',
	            'image' => 'img_0011.jpg',
	            'fingerprints_img'	=>	'11.jpg',
	            'search_house_img'	=>	'bad_luck.png',
	            'search_house_link'	=>	'#'
        	]
        ]);
    }
}
