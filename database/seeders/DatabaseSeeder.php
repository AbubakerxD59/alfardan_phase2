<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Hotel;
use App\Models\Restaurant;
use App\Models\Resort;
use App\Models\Event;
use App\Models\ClassEvent;
use App\Models\Facility;
use App\Models\Image;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\MaintenanceRequest;
use App\Models\Property;
use App\Models\Apartment;
use App\Models\PrivilegeCategory;
use App\Models\Update;
use App\Models\Question;
use App\Models\Answer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ['name' => 'News Feed', 'icon' => 'newspaper.png', 'background' => 'Newsfeed---Covre-Page.jpg'],
            ['name' => 'Leasing', 'icon' => 'leasing.png', 'background' => 'Al-Fina_a---Cover-Page.jpg'],
            ['name' => 'Customer Service', 'icon' => 'customer-service@2x.png', 'background' => 'Customer-Service---Covre-Page.jpg'],
            ['name' => 'Engineering & Maintenance', 'icon' => 'tools@2x.png', 'background' => 'Engineering-_-Maintenance---Cover-Page.jpg'],
            ['name' => 'Privilege Programme', 'icon' => 'privilge.png', 'background' => 'Privilege-Programme---Cover-Page.jpg'],
            ['name' => 'Lifestyle', 'icon' => 'genderless.png', 'background' => 'Lifestyle---Cover-Page.jpg'],
            ['name' => 'Hospitality Outlets', 'icon' => 'tea.png', 'background' => 'Hospitality-Outlets---Cover-Page.jpg'],
            ['name' => 'Sell & Buy', 'icon' => 'shopping_bag.png', 'background' => 'Sell-_-Buy---Cover-Page.jpg'],
            ['name' => 'Concierge', 'icon' => 'concierge@2x.png', 'background' => 'Concierge---Cover-Page.jpg'],
            ['name' => 'Book a Limousine', 'icon' => 'limousine.png', 'background' => 'Book-a-Limousine---Cover-Page.jpg'],
        ]);

        Hotel::insert([
            [
                'name' => 'Kempinski Residences & Suites',
                'location' => 'West Bay, Doha',
                'description' => 'LUXURY SUITES & VILLAS IN WEST BAY
Kempinski Residences & Suites, Doha, the tallest tower in West Bay, measures 256 meters. This luxurious city hotel, which opened in 2010, features 368 city or sea view facing suites and villas, measuring between 72 sqm – 596 sqm. Every facility required for comfortable living is on hand, from the doorman and the residence services desk that warmly greet the guests, to the state-of-the-art leisure & wellness center.
Kempinski Residences & Suites, Doha, is located in the prestigious central business district of West Bay, just steps away from major embassies, companies, government offices, and the City Centre Shopping Mall. The Doha Corniche, a landscaped waterfront promenade extending elegantly around the Doha Bay, is located within a 5-minute walk from the hotel, while The Pearl Island is a mere 10-minutes’ drive away; Hamad International Airport is 20km / 25 minutes away.
Website: https://www.kempinski.com/en/doha/residences/',
                'phone' => '(+974 4405 3333)',
                'latitude' => null,
                'longitude' => null,
                'cover' => 'krdoh1_lobby_2_h_web.jpg'
            ],
            [
                'name' => 'Marsa Malaz Kempinski',
                'location' => 'The Pearl - Doha',
                'description' => 'A PALATIAL LUXURY BEACH RESORT IN DOHA
Welcome to an oasis of comfort, tranquillity and privacy which reflects the ultimate luxury of a genuine and majestic palace, an embodiment of both Arabian and European elegance, along with breathtaking views over the Arabian Gulf and the Pearl-Doha from the spacious balconies of its 281 rooms and suites.
Marsa Malaz Kempinski ensures the most spectacular family-friendly experience in Doha, from a blissful culinary experience with seven restaurants and four stylish bars and lounges, to unique facilities, such as the award-winning Spa by Clarins, a private beach, outdoor pools, a tennis court, a state-of-the-art fitness centre, and thrilling kids’ and adults’ activities, including water sports and a kids’ club.
This five-star hotel in Doha promises a great combination of conference rooms and outdoor areas, making it the perfect choice for outstanding events.
Kempinski White Glove Services has been implemented to ensure a healthy and safe environment for all our guests and employees.
Website:
https://www.kempinski.com/en/doha/marsa-malaz-kempinski-the-pearl-doha/

',
                'phone' => '(+974 4035 5555 )',
                'latitude' => '25.375952',
                'longitude' => '51.549673',
                'cover' => 'marsa-malaz-kempinski-night-exterior-shot.jpg'
            ],
            [
                'name' => 'St Regis',
                'location' => 'Al Gassar Resort, West Bay',
                'description' => 'St Regis:  The Finest Address in Doha. 
Steeped in Middle Eastern mystique, The St. Regis Doha is located on the West Bay, near the Diplomatic District in Qatar\'s sophisticated capital city. The hotel borders the Arabian Gulf, where sand dunes, ancient architecture and the scenic Pearl Island paint a magnificent landscape. Our timeless resort facilities comprise a cornucopia of destination restaurants and event spaces, including a 1,850-square meter Grand Ballroom. The St. Regis Doha also features a world-class Remède Spa and offers direct access to the beach, where private cabanas and water sports await. Each of our 336 luxury rooms and suites includes seductive sea views and bespoke Arabian-influenced décor, combined with state-of-the-art technology. Whatever the request, St. Regis Butler Service is available any time, day or night.
Website:  https://www.marriott.com/hotels/travel/dohxr-the-st-regis-doha/',
                'phone' => '(+974 4446 0000)',
                'latitude' => '25.350722',
                'longitude' => '51.530007',
                'cover' => 'dohxr-exterior-4958-hor-clsc.webp'
            ],
        ]);

        Image::insert([
            [
                'path' => 'krdoh1_lobby_2_h_web.jpg',
                'hotel_id' => 1,
            ],
            [
                'path' => 'lobby-kempinski-residences-1.jpg',
                'hotel_id' => 1,
            ],
            [
                'path' => 'tower-exterior-kempinskidoha.jpg',
                'hotel_id' => 1,
            ],
            [
                'path' => 'marsa-malaz-kempinski-night-exterior-shot.jpg',
                'hotel_id' => 2,
            ],
            [
                'path' => 'pools-at-marsa-malaz-kempinski-4.jpg',
                'hotel_id' => 2,
            ],
            [
                'path' => 'private-beach-pools-at-marsa-malaz-kempinski.jpg',
                'hotel_id' => 2,
            ],
            [
                'path' => 'dohxr-exterior-4958-hor-clsc.webp',
                'hotel_id' => 3,
            ],
            [
                'path' => 'dohxr-kingdeluxe-guestroom-3716-hor-clsc.webp',
                'hotel_id' => 3,
            ],
            [
                'path' => 'dohxr-terrace-8804-hor-clsc.jpg',
                'hotel_id' => 3,
            ],
        ]);

        Restaurant::insert([
            [
                'name' => 'Antika',
                'location' => 'Marsa Malaz Kempinski, The Pearl',
                'description' => 'Lebanon’s history comes alive at Antika, from rich interiors, detailed elements, and a stage for live shows, Antika serves the best of Levantine cuisine with inimitable Lebanese flavours since 2018, promising all the makings for a night to remember. Ample indoor seating and an outdoor terrace with wide views of the area offer a choice of surroundings, and the best of the Arab world’s hospitality is encapsulated in its mouth-watering food, appealing drinks and live entertainment. Founded by 7 Management, a Lebanese hospitality management company, a group of talented young entrepreneurs had a vision and spent years perfecting the right cuisine and entertainment blend along with visionary concepts, placing the company firmly at the vanguard of leading restaurant, lounge and bar operators in Beirut, Dubai and Doha.',
                'phone' => '(+974 7794 1838)',
                'latitude' => null,
                'longitude' => null,
                'cover' => 'available_hotel.png'
            ],
            [
                'name' => 'BiBo',
                'location' => 'Al Gassar Resort, St Regis Doha',
                'description' => 'BiBo is a dynamic, eclectic and carefree space by 3-Star Michelin Chef Dani Garcia. The brand was born in Marbella in 2014 thanks to Dani García\'s idea of creating a casual concept with which to democratize fine dining in the form of a brasserie and a tapas bar. The BiBo menu brings together dishes that the chef’s gastronomic memory has accumulated thanks to his travels in and out of Spain. BiBo stands out for its variety, style and concept flexibility being able to adapt to different locations such as CITY, BEACH and TRAVEL. An informal, cosmopolitan concept, with each establishment providing a different experience. Website: www.grupodanigarcia.com',
                'phone' => '(+974 4424 4870 )',
                'latitude' => null,
                'longitude' => null,
                'cover' => 'Bibo.jpg'
            ],
            [
                'name' => 'Hakkasan',
                'location' => 'St Regis Doha',
                'description' => 'Hakkasan Doha, is a modern award-winning Cantonese fine dining concept and one of the world’s most distinguished global restaurants founded in London which serves authentic Cantonese flavors. Its international popularity has sent influencers, tastemakers and celebrities raving about its Chinese dishes in a vibrant dining atmosphere. Website: www.hakkasan.com',
                'phone' => '(+974 4446 0170 )',
                'latitude' => null,
                'longitude' => null,
                'cover' => 'Hakkasan.jpg'
            ],
            [
                'name' => 'Huqqa',
                'location' => 'Al Gassar Resort St Regis Doha',
                'description' => 'Huqqa, has two parts – one an international style restaurant and the other the Turkish steakhouse. Accommodates indoor and outdoor seating, serves guests shisha. It aims at offering a dynamic dining experience within design-driven surroundings, delivering a unique experience with style and charisma. Website: www.huqqa.com',
                'phone' => '(+974 4424486)',
                'latitude' => null,
                'longitude' => null,
                'cover' => 'Huqqa.jfif'
            ],
        ]);

        Image::insert([
            [
                'path' => 'available_hotel.png',
                'restaurant_id' => 1,
            ],
            [
                'path' => 'Bibo.jpg',
                'restaurant_id' => 2,
            ],
            [
                'path' => 'Bibo-1.jpg',
                'restaurant_id' => 2,
            ],
            [
                'path' => 'Hakkasan.jpg',
                'restaurant_id' => 3,
            ],
            [
                'path' => 'Hakkasan-1.jpg',
                'restaurant_id' => 3,
            ],
            [
                'path' => 'Hakkasan-2.jpg',
                'restaurant_id' => 3,
            ],
            [
                'path' => 'Huqqa.jfif',
                'restaurant_id' => 4,
            ],
            [
                'path' => 'Huqqa2.png',
                'restaurant_id' => 4,
            ],
        ]);

        Resort::insert([
            [
                'name' => 'Guerlain Spa, Alfardan',
                'location' => '39th Floor, Alfardan Residential Tower',
                'description' => 'With a legacy of over 180 years in the beauty world, Doha’s prestigious Guerlain Spa at Alfardan Towers, West Bay, creates serene and rejuvenating experiences – transforming beauty treatments into personal occasions and therapeutic moments.
It also offers a high-quality hairdressing salon alongside the spa facilities.',
                'type' => 'Type',
                'phone' => '+974 4420 8660',
                'latitude' => '25.321087',
                'longitude' => '51.529804',
                'cover' => 'Gerlain-spa.jpg'
            ],
            [
                'name' => 'Remède Spa',
                'location' => 'The St. Regis Doha',
                'description' => 'A soothing haven wrapped in cream hues and natural wood, with 22 private treatments rooms, as well as gender-specific, spacious pre- and post-treatment lounges, the Remède Spa at The St. Regis Doha elevates personal wellness.

Both timeless St. Regis elegance and captivating local traditions are seamlessly integrated into the spa\'s sophisticated interiors and stunning relaxation spaces—defined by clean, organic lines and diffused natural light—and the extensive treatment menu, which includes a number of singular face and body therapies as well as steam rooms, a manicure/pedicure studio, and hydro-massage relaxation pools developed exclusively for the spa.

We are pleased to welcome both in-house and visiting guests to the Remède Spa at The St. Regis Doha, and while we do our utmost to accommodate walk-in guests, we highly recommend advance reservations. We request that guests arrive a minimum of 15 to 30 minutes prior to their appointment. Please note that bookings are scheduled with the first available therapist and gratuity is based upon guest’s discretion.
Prior appointment is required
Timings:  Monday to Sunday 10:00am – 10:00pm',
                'type' => 'Type',
                'phone' => '+974 4446 0300',
                'latitude' => null,
                'longitude' => null,
                'cover' => 'dohxr-spa-8847-hor-clsc.webp'
            ],
            [
                'name' => 'SPA BY CLARINS & FITNESS CENTRE',
                'location' => 'Marsa Malaz Kempinski, The Pearl – Doha',
                'description' => 'With the focus firmly on beauty, relaxation and wellbeing, Spa by Clarins at Marsa Malaz Kempinski is a retreat for the body and soul. In a setting so serene, the heavenly treatments on offer by highly specialised spa personnel delight and de-stress guests. Spa by Clarins provides a full range of therapies, making use of the finest products, the latest technology and the incomparable human touch in a truly serene setting across 3,000sqm and 21 treatment rooms.
Opening hours: Daily from 10:00am to 10:00pm.
Prior appointment is required',
                'type' => 'Type',
                'phone' => '+974 4035 5555',
                'latitude' => null,
                'longitude' => null,
                'cover' => 'spa-by-clarins-couples-treatment-room.jpg'
            ],
        ]);

        Image::insert([
            [
                'path' => 'Gerlain-spa.jpg',
                'resort_id' => 1,
            ],
            [
                'path' => 'image_01-1.jpg',
                'resort_id' => 1,
            ],
            [
                'path' => 'image_28.jpg',
                'resort_id' => 1,
            ],
            [
                'path' => 'IMG_5879.jpg',
                'resort_id' => 1,
            ],
            [
                'path' => 'IMG_9856.jpg',
                'resort_id' => 1,
            ],
            [
                'path' => 'dohxr-spa-8847-hor-clsc.webp',
                'resort_id' => 2,
            ],
            [
                'path' => 'dohxr-spa-9264-hor-clsc.webp',
                'resort_id' => 2,
            ],
            [
                'path' => 'dohxr-spa-9654-hor-clsc.webp',
                'resort_id' => 2,
            ],
            [
                'path' => 'spa-by-clarins-couples-treatment-room.jpg',
                'resort_id' => 3,
            ],
            [
                'path' => 'spa-by-clarins-treatment-room.jpg',
                'resort_id' => 3,
            ],
            [
                'path' => 'spa-by-clarins-waiting-room.jpg',
                'resort_id' => 3,
            ],
            [
                'path' => 'spa-by-clarins-womens-pool.jpg',
                'resort_id' => 3,
            ],
        ]);

        Event::insert([
            [
                'name' => 'Event Name',
                'date' => '2021-12-01',
                'location' => 'Location',
                'description' => 'Lorem ipsum',
                'latitude' => '34.1312',
                'longitude' => '35.1312',
                'cover' => 'event_upcomming.jpeg'
            ],
        ]);

        Image::insert([
            [
                'path' => 'resot_detail.png',
                'event_id' => 1,
            ],
            [
                'path' => 'resot_detail.png',
                'event_id' => 1,
            ],
        ]);

        ClassEvent::insert([
            [
                'name' => 'Yoga Class',
                'teacher' => 'Bella',
                'location' => 'Alfardan Gardens',
                'description' => 'Benefit from our variety of fitness classes selected to boost your everyday energy',
                'seats' => 50,
                'latitude' => null,
                'longitude' => null,
                'cover' => 'classes_upcomming.jpeg'
            ],
            [
                'name' => 'Pilates Class',
                'teacher' => 'Bella',
                'location' => 'Alfardan Gardens',
                'description' => 'Benefit from our variety of fitness classes selected to boost your everyday energy',
                'seats' => 50,
                'latitude' => null,
                'longitude' => null,
                'cover' => 'classes_upcomming.jpeg'
            ],
            [
                'name' => 'HIIT',
                'teacher' => 'Bella',
                'location' => 'Alfardan Gardens',
                'description' => 'Benefit from our variety of fitness classes selected to boost your everyday energy',
                'seats' => 50,
                'latitude' => null,
                'longitude' => null,
                'cover' => 'classes_upcomming.jpeg'
            ],
        ]);

        Image::insert([
            [
                'path' => 'classes_upcomming.jpeg',
                'class_id' => 1,
            ],
            [
                'path' => 'classes_upcomming.jpeg',
                'class_id' => 2,
            ],
            [
                'path' => 'classes_upcomming.jpeg',
                'class_id' => 3,
            ],
        ]);

        Facility::insert([
            [
                'name' => 'Lounge area',
                'location' => 'Alfardan Gardens',
                'description' => '',
                'latitude' => null,
                'longitude' => null,
                'cover' => 'available_fac.png'
            ],
            [
                'name' => 'Swimming pool',
                'location' => 'Alfardan Gardens',
                'description' => '',
                'latitude' => null,
                'longitude' => null,
                'cover' => 'available_fac.png'
            ],
            [
                'name' => 'Kids swimming pool',
                'location' => 'Alfardan Gardens',
                'description' => '',
                'latitude' => null,
                'longitude' => null,
                'cover' => 'available_fac.png'
            ],
        ]);

        Image::insert([
            [
                'path' => 'available_fac.png',
                'facility_id' => 1,
            ],
            [
                'path' => 'available_fac.png',
                'facility_id' => 2,
            ],
            [
                'path' => 'available_fac.png',
                'facility_id' => 3,
            ],
        ]);

        ProductCategory::insert([
            ['name' => 'Vehicles'],
            ['name' => 'Electronics'],
            ['name' => 'Furniture'],
            ['name' => 'Kids'],
            ['name' => 'Sports']
        ]);

        Product::insert([
            [
                'name' => 'Product Name',
                'description' => 'Lorem ipsum',
                'phone' => '923123312312',
                'cover' => 'resot_detail.png',
                'condition' => 'excellent',
                'featured' => 1,
                'price' => 500,
                'user_id' => 1,
                'category_id' => 2,
            ],
            [
                'name' => 'Featured Product',
                'description' => 'Lorem ipsum',
                'phone' => '923123312312',
                'cover' => 'resot_detail.png',
                'condition' => 'excellent',
                'featured' => 1,
                'price' => 500,
                'user_id' => 1,
                'category_id' => 2,
            ]
        ]);

        MaintenanceRequest::insert([
            [
                'name' => 'Test Request',
                'location' => 'Location',
                'type' => 'Type 1',
                'description' => 'Lorem ipsum',
                'date' => '2021-12-12',
                'time' => '12:00',
                'user_id' => 1
            ]
        ]);

        Image::insert([
            [
                'path' => 'resot_detail.png',
                'maintenance_request_id' => 1,
            ],
            [
                'path' => 'resot_detail.png',
                'maintenance_request_id' => 1,
            ],
        ]);

        Property::insert([
            [
                'name' => 'Property Name',
                'location' => 'Location',
                'description' => 'Lorem ipsum',
                'phone' => '9231234567890',
                'email' => 'Email',
                'residences' => 'Fully Furnished,Basement Parking',
                'facilities' => 'Lobby Lounge,Relaxation Room',
                'services' => '24/7 Security,Fire Alarm System',
                'privileges' => 'Acces to One Porto Arabia,Special Rates',
                'latitude' => '34.1312',
                'longitude' => '35.1312',
                'cover' => 'resot_detail.png'
            ],
        ]);

        Image::insert([
            [
                'path' => 'resot_detail.png',
                'property_id' => 1,
            ],
            [
                'path' => 'resot_detail.png',
                'property_id' => 1,
            ],
        ]);

        Apartment::insert([
            [
                'name' => 'Apartment Name',
                'title' => 'Title',
                'location' => 'Location',
                'description' => 'Lorem ipsum',
                'phone' => '9231234567890',
                'email' => 'Email',
                'latitude' => '34.1312',
                'longitude' => '35.1312',
                'cover' => 'resot_detail.png',
                'property_id' => 1
            ],
        ]);
        
        Image::insert([
            [
                'path' => 'resot_detail.png',
                'apartment_id' => 1,
            ],
            [
                'path' => 'resot_detail.png',
                'apartment_id' => 1,
            ],
        ]);

        PrivilegeCategory::insert([
            ['name' => 'F&B'],
            ['name' => 'Wellness'],
            ['name' => 'Hotels'],
            ['name' => 'Medical']
        ]);

        Update::insert([
            [
                'cover' => 'resot_detail.png',
                'description' => 'Description',
            ],
            [
                'cover' => 'resot_detail.png',
                'description' => 'Description',
            ]
        ]);

        Question::insert([
            [
                'cover' => 'resot_detail.png',
                'text' => 'First Question',
            ],
            [
                'cover' => 'resot_detail.png',
                'text' => 'Second Question',
            ]
        ]);

        Answer::insert([
            [
                'text' => 'Answer 1',
                'question_id' => 1,
            ],
            [
                'text' => 'Answer 2',
                'question_id' => 1,
            ],
            [
                'text' => 'Answer 3',
                'question_id' => 1,
            ],
            [
                'text' => 'Answer 4',
                'question_id' => 1,
            ],
            [
                'text' => 'Answer 1',
                'question_id' => 2,
            ],
            [
                'text' => 'Answer 2',
                'question_id' => 2,
            ],
            [
                'text' => 'Answer 3',
                'question_id' => 2,
            ],
            [
                'text' => 'Answer 4',
                'question_id' => 2,
            ],
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
