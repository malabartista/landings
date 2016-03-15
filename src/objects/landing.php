<?php
	include_once __DIR__ . '/../render/dbvars.php';
	require __DIR__ . '/../../vendor/altorouter/AltoRouter.php';

	class landing{
		// global vars
		var $base_url = '';
		var $base_landing = '';
		var $base_path = '';
		var $image_path = '/img';
		var $js_path = '/js';
		var $css_path = '/css';
		var $css_file = 'style.css';
		var $ganalytics = '';
		var $id_landing = 0;
		var $id_landing_parent = 0;
		var $id_landing_page = 0;

		// seo
		var $title = '';
		var $meta_desc = '';
		var $meta_key = '';
		var $meta_url = '';
		var $city = '';
		var $cities_arr = array();
		var $cities_main_arr = array();
		var $seo_block = '';

		// templates
		var $layout_template = '1';

		var $phone_number = '';

		// images
		var $logo = '';
		var $logo_alt = '';

		var $promo_img = '';

		var $promotions_img = '';
		var $promotions_img_alt = '';

		// ids
		var $bodyId = 'lellamanBody';
		var $videoId = '';

		// components
		var $header_type = 1;
		var $navbar = array();
		var $navbar_active = 1;
		var $navs = array();
		var $navs_type = '';
		var $nav_phone = '';

		// header
		var $header_h = '';

		// footer
		var $footer_h = '';
		var $footer_h_sub = '';
		var $footer_button = '';
		var $footer_navbar = [array('name' => 'Aviso Legal', 'link' => '/common/legal/legal.html'),
					  array('name' => 'Declaración de privacidad', 'link' => '/common/legal/privacity.html'),
					  array('name' => 'Condiciones de la promoción', 'link' => '/common/legal/conditions.html')];

		// modal
		var $modal_title = '';
		var $modal_anim = '';
		var $modal_image = '';
		var $modal_image_alt = '';

		// geo
		var $geo_section_url = 'en';
		var $geo_section_title = 'Ofertas en';

		// forms
		var $form_type = '';

		var $form_h = '';
		var $form_p = '';
		var $form_button = '';
		var $form_privacity = '';

		var $form_big_h = '';
		var $form_big_p = '';
		var $form_big_button = '';

		var $form_modal_h = '';
		var $form_modal_p = '';
		var $form_modal_button = '';

		// promo
		var $box_promo_main = array();
		var $promo_title = '';

		// promotions
		var $promotions = '';

		// section templates
		var $sec_promo_temp = '';
		var $sec_pricing_temp = '';
		var $sec_detail_temp = '';
		var $sec_speedtest_temp = '';
		var $sec_animbanner_temp = '';

		// sections
		var $detail_arr = array();
		var $features_arr = array();
		var $pricing_arr = array();
		var $animbanner_arr = array();
		var $animbanner_h = '';

		public function __construct($id) {
			$this->id_landing = $id;
			$this->base_url = $_SERVER['SERVER_NAME'];
			$this->base_landing = $_SERVER['REQUEST_URI'];
		}
}

function setLandingParent($landing,$database){
	$datas = $database->select('landing_parent','*',["id_landing" => $landing->id_landing]);
	foreach($datas as $data){
		if (array_key_exists('id_landing_parent', $data)) {$landing->id_landing_parent = $data["id_landing_parent"];}
	}
}
function setIdLandingPage($landing,$database){
	$datas = $database->select('landing_pages','*',["AND" =>["url" => $_SERVER['REQUEST_URI'], "id_landing"=> $landing->id_landing_parent]]);
	if (empty($datas)){$datas = $database->select('landing_pages','*',["AND" =>["id_landing_page"=> 1,"id_landing"=> $landing->id_landing_parent]]);}
	foreach($datas as $data){
		if (array_key_exists('id_landing_page', $data)) {$landing->id_landing_page = $data["id_landing_page"];}
		if (array_key_exists('navbar_active', $data)) {$landing->navbar_active = $data["navbar_active"];}
		if (array_key_exists('bodyId', $data)) {$landing->bodyId = $data["bodyId"];}
		//if (!empty($landing->id_landing)) {$landing->bodyId = $landing->id_landing;}
		if (array_key_exists('promo_title', $data)) {$landing->promo_title = $data["promo_title"];}
	}
}
function setLandingPaths($landing,$database){
	$datas = $database->select('landing_paths','*',["id" => 1]);
	foreach($datas as $data){
		if (array_key_exists('base_path', $data)) {$landing->base_path = $data["base_path"];}
		if (array_key_exists('ws_base_domain', $data)) {$landing->ws_base_domain = $data["ws_base_domain"];}
	}
}

function setLandingSeo($landing,$database){
	$datas = $database->select('landing_seo','*',["id_landing" => $landing->id_landing]);
	foreach($datas as $data){
		if (array_key_exists('title', $data)) {$landing->title = $data["title"];}
		if (array_key_exists('meta_desc', $data)) {$landing->meta_desc = $data["meta_desc"];}
		if (array_key_exists('meta_key', $data)) {$landing->meta_key = $data["meta_key"];}
		if (array_key_exists('article', $data)) {$landing->seo_block = $data["article"];}
		if (array_key_exists('geo_section_title', $data)) {$landing->geo_section_title = $data["geo_section_title"];}
		if (array_key_exists('geo_section_url', $data)) {$landing->geo_section_url = $data["geo_section_url"];}
		if (array_key_exists('ganalytics', $data)) {$landing->ganalytics = $data["ganalytics"];}
	}
}

function setLandingForms($landing,$database){
	$datas = $database->select('landing_forms','*',["id_landing" => $landing->id_landing_parent]);
	foreach($datas as $data){
		if (array_key_exists('header_h', $data)) {$landing->header_h = $data["header_h"];}
		if (array_key_exists('footer_h', $data)) {$landing->footer_h = $data["footer_h"];}
		if (array_key_exists('theme', $data)) {$landing->css_file = $data["theme"];}
		if (array_key_exists('phone_number', $data)) {$landing->phone_number = $data["phone_number"];}
		if (array_key_exists('logo_alt', $data)) {$landing->logo_alt = $data["logo_alt"];}
		if (array_key_exists('form_type', $data)) {$landing->form_type = $data["form_type"];}
		if (array_key_exists('form_privacity', $data)) {$landing->form_privacity = $data["form_privacity"];}
		if (array_key_exists('form_h', $data)) {$landing->form_h = $data["form_h"];}
		if (array_key_exists('form_p', $data)) {$landing->form_p = $data["form_p"];}
		if (array_key_exists('form_button', $data)) {$landing->form_button = $data["form_button"];}
		if (array_key_exists('form_big_h', $data)) {$landing->form_big_h = $data["form_big_h"];}
		if (array_key_exists('form_big_p', $data)) {$landing->form_big_p = $data["form_big_p"];}
		if (array_key_exists('form_big_button', $data)) {$landing->form_big_button = $data["form_big_button"];}
		if (array_key_exists('form_modal_h', $data)) {$landing->form_modal_h = $data["form_modal_h"];}
		if (array_key_exists('form_modal_p', $data)) {$landing->form_modal_p = $data["form_modal_p"];}
		if (array_key_exists('form_modal_button', $data)) {$landing->form_modal_button = $data["form_modal_button"];}
		if (array_key_exists('modal_image', $data)) {$landing->modal_image = $data["modal_image"];}
		if (array_key_exists('modal_image_alt', $data)) {$landing->modal_image_alt = $data["modal_image_alt"];}
		if (array_key_exists('logo', $data)) {$landing->logo = $data["logo"];}
		if (array_key_exists('logo_alt', $data)) {$landing->logo_alt = $data["logo_alt"];}
	}
}
// templates and sections
function setLandingTemplates($landing,$database){
	$datas = $database->select('landing_templates','*',["id_landing" => $landing->id_landing_parent]);
	foreach($datas as $data){
		if (array_key_exists('layout_template', $data)) {$landing->layout_template = $data["layout_template"];}
		if (array_key_exists('sec_promo_temp', $data)) {$landing->sec_promo_temp = $data["sec_promo_temp"];}
		if (array_key_exists('sec_detail_temp', $data)) {$landing->sec_detail_temp = $data["sec_detail_temp"];}
		if (array_key_exists('sec_pricing_temp', $data)) {$landing->sec_pricing_temp = $data["sec_pricing_temp"];}
		if (array_key_exists('sec_thumbnails_temp', $data)) {$landing->sec_thumbnails_temp = $data["sec_thumbnails_temp"];}
	}
}
function setLandingBoxPromoMain($landing,$database){
	if($landing->id_landing_page==0){$landing->id_landing_page=1;}
	$datas = $database->select('landing_products', ["[>]landing_pages_products" => ["id_landing_product" => "id_landing_product"],"[>]landing_product_price" => ["id_price" => "id_price"]],'*',["AND" =>["is_main" => "S","landing_pages_products.id_landing"=>$landing->id_landing_parent,"landing_pages_products.id_landing_page"=>$landing->id_landing_page]]);
	foreach($datas as $data){
		array_push($landing->box_promo_main,$data);
	}
}
function setLandingPricingProducts($landing,$database){
	$datas = $database->select('landing_products', ["[>]landing_pages_products" => ["id_landing_product" => "id_landing_product"],"[>]landing_product_price" => ["id_price" => "id_price"]],'*',["AND" =>["landing_pages_products.id_landing" => $landing->id_landing_parent,"landing_pages_products.id_landing_page" => $landing->id_landing_page,"is_pricing_table" => "S"]]);
	foreach($datas as $data){
		$dataf = $database->select('landing_products_features',["[>]landing_product_features" => ["id_product_feature" => "id"]],'*',["id_product" => $data["id_landing_product"]]);
		$data["features"] = array();
		foreach($dataf as $feature){
			array_push($data["features"],array("descrip"=>$feature["descrip"],"glyphicon"=>$feature["glyphicon"]));
		}
		array_push($landing->pricing_arr,$data);
	}
}
function setLandingPromoDetail($landing,$database){
	if($landing->id_landing_page==0){$landing->id_landing_page=1;}
	$datas = $database->select('landing_promo_detail','*',["AND" =>["id_landing" => $landing->id_landing_parent,"id_landing_page" => $landing->id_landing_page]]);
	foreach($datas as $data){
		array_push($landing->detail_arr,$data["descrip"]);
	}
}
// components
function setLandingNavbar($landing,$database){
	$datas = $database->select('landing_navbars','*',["id_landing" => $landing->id_landing_parent]);
	foreach($datas as $data){
		array_push($landing->navbar,$data);
	}
	$landing->navbar[0]["active"]=1;
}
function setLandingImages($landing,$database){
	$datas = $database->select('landing_images','*',
		["AND"=>[
			"id_landing" => $landing->id_landing_parent,
			"id_landing_page" => $landing->id_landing_page
	]]);
	foreach($datas as $data){
		if (array_key_exists('logo', $data) && !empty($data["logo"])) {$landing->logo = $data["logo"];}
		if (array_key_exists('logo_alt', $data) && !empty($data["logo_alt"])) {$landing->logo_alt = $data["logo_alt"];}
		if (array_key_exists('promo_img', $data) && !empty($data["promo_img"])) {$landing->promo_img = $data["promo_img"];}
		if (array_key_exists('promo_img_alt', $data) && !empty($data["promo_img_alt"])) {$landing->promo_img_alt = $data["promo_img_alt"];}
		if (array_key_exists('modal_image', $data) && !empty($data["modal_image"])) {$landing->modal_image = $data["modal_image"];}
		if (array_key_exists('modal_image_alt', $data) && !empty($data["modal_image_alt"])) {$landing->modal_image_alt = $data["modal_image_alt"];}
	}
}
function initLandingParent($landing,$database){
	// parent
	setLandingParent($landing,$database);
	// paths
	setLandingPaths($landing,$database);
	// navbar
	setLandingNavbar($landing,$database);
	// templates
	setLandingTemplates($landing,$database);
	// forms
	setLandingForms($landing,$database);
	// images
	setLandingImages($landing,$database);
}
function initLanding($landing,$database){
	initLandingParent($landing,$database);
	// id page
	setIdLandingPage($landing,$database);
	// seo
	setLandingSeo($landing,$database);
	// forms
	setLandingForms($landing,$database);
	// images
	setLandingImages($landing,$database);
	// each page
	// box promo main
	setLandingBoxPromoMain($landing,$database);
	// pricing
	setLandingPricingProducts($landing,$database);
	setLandingPromoDetail($landing,$database);
	replaceLandingStrings($landing);
}

/* ROUTING */
/*
The following function will strip the script name from URL i.e.  http://www.something.com/search/book/fitzgerald will become /search/book/fitzgerald
*/
function getCurrentUri(){
	$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
	$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
	if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
	$uri = '/' . trim($uri, '/');
	return $uri;
}

/* Not in Use */
function setLandingRoute($landing){
	$base_url = getCurrentUri();
	$routes = array();
	$routes = explode('/', $base_url);
	foreach($routes as $route){
		if(trim($route) != '')
			array_push($routes, $route);
	}
	// the navbar
	if($routes[1] == "jazztel-fibra-optica-200"){
		$landing->navbar_active=1;
	}else if($routes[1] == "jazztel-fibra-optica-50"){
		$landing->navbar_active=2;
	}else if($routes[1] == "jazztel-fibra-optica-20"){
		$landing->navbar_active=3;
	}else if($routes[1] == "seguro-medico"){
		$landing->navbar_active=1;
	}else if($routes[1] == "seguro-dental"){
		$landing->navbar_active=2;
	}
}
/* Not in Use */
function AltoRouter(){
	$router = new AltoRouter();
	$router->setBasePath('marketing/landings/web-landing/');
	$router->map( 'GET', '/', function() {echo "Home";}, 'home');
	$router->map( 'GET', '/jazztel-fibra-optica-200', function() {echo "200";$landing->navbar_active=1;}, 'jazztel-fibra-optica-200');
	$router->map( 'GET', '/jazztel-fibra-optica-50', function() {echo "50";$landing->navbar_active=2;}, 'jazztel-fibra-optica-50');
	$router->map( 'GET', '/jazztel-fibra-optica-20', function() {echo "20";}, 'jazztel-fibra-optica-20');
	$router->map( 'GET', '/internet', function() {echo "Internet";$landing->navbar_active=1;}, 'internet');
	$router->map( 'GET', '/internet-movil', function() {echo "Internet-Movil";$landing->navbar_active=2;}, 'internet-movil');
	$router->map( 'GET', '/tv', function() {echo "TV";}, 'tv');
	$router->map( 'GET', '/fibra', function() {echo "Fibra";}, 'fibra');
	$router->map( 'GET', '/seguro-medico', function() {echo "Medico";}, 'medico');
	$router->map( 'GET', '/seguro-dental', function() {echo "Dental";}, 'dental');
	$match = $router->match();
	$target = $match['target'];
	$target();
}
function setLandingCityFromUri($landing){
	$base_url = getCurrentUri();
	$routes = array();
	$routes = explode('/', $base_url);
	foreach($routes as $route){
		if(trim($route) != '')
			array_push($routes, $route);
	}
	// the city
	if($routes[1] == "en"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if(($routes[1] == "cobertura") && ($routes[2] =="disponibilidad-jazztel-fibra")){
		$landing->city = ucwords(str_replace('-', ' ', $routes[3]));
	}else if(($routes[1] == "consultar") && ($routes[2] =="jazztel-cobertura")){
		$landing->city = ucwords(str_replace('-', ' ', $routes[3]));
	}else if(($routes[1] == "comprobar") && ($routes[2] =="jaztel-cobertura")){
		$landing->city = ucwords(str_replace('-', ' ', $routes[3]));
	}else if(($routes[1] == "cobertura-jazztel-movil") && ($routes[2] =="en")){
		$landing->city = ucwords(str_replace('-', ' ', $routes[3]));
	}else if(($routes[1] == "cobertura-jazztel") && ($routes[2] =="en")){
		$landing->city = ucwords(str_replace('-', ' ', $routes[3]));
	}else if(($routes[1] == "fibra-disponible") && ($routes[2] =="en")){
		$landing->city = ucwords(str_replace('-', ' ', $routes[3]));
	}else if(($routes[1] == "ofertas-jazztel") && ($routes[2] =="en")){
		$landing->city = ucwords(str_replace('-', ' ', $routes[3]));
	}else if($routes[1] == "tiene"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "comprobar-en"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "ofertas-cobertura"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "ofertas-jazztel"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "ofertas-jazztel-adsl-en"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "ofertas-de-jazztel-en"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "ofertas-jazztel-moviles"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "jazztel-fibra-optica"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "jazztel-internet"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "jaztell-cobertura"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "jazztel-cobertura-fibra"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "jazztel-moviles"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "cobertura"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "cobertura-adsl-jazztel"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "cobertura-fibra-jazztel"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "cobertura-jazztel-en"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "cobertura-jazztel-fibra"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "cobertura-fibra-adsl-movil-jazztel"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "comprobar-cobertura-fibra-jazztel"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "comprobar-cobertura-jazztel-fibra"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "tarifas-jazztel-en"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "tarifas-jazztel-movil"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}else if($routes[1] == "tarifas-moviles-jazztel"){
		$landing->city = ucwords(str_replace('-', ' ', $routes[2]));
	}
}
function replaceLandingStrings($landing){
	// city
	if (!empty($landing->city)) {
		$landing->title = str_replace("{{city}}", 'en ' . $landing->city, $landing->title);
		$landing->meta_desc = str_replace("{{city}}", 'en ' . $landing->city, $landing->meta_desc);
		$landing->meta_key = str_replace(",", ' ' . $landing->city . ',',$landing->meta_key);
		$landing->seo_block = str_replace("{{city}}", 'en ' . $landing->city, $landing->seo_block);
	}else{
		$landing->title = str_replace(" {{city}}", '', $landing->title);
		$landing->meta_desc = str_replace(" {{city}}", '', $landing->meta_desc);
		$landing->seo_block = str_replace(" {{city}}", '', $landing->seo_block);
	}

	// phone-number
	if (!empty($landing->phone_number)) {
		$landing->title = str_replace("{{phone}}", $landing->phone_number, $landing->title);
		$landing->meta_desc = str_replace("{{phone}}", $landing->phone_number, $landing->meta_desc);
		$landing->form_modal_p = str_replace("{{phone}}", $landing->phone_number, $landing->form_modal_p);
	}else{
		$landing->title = str_replace(" {{phone}}", '', $landing->title);
		$landing->meta_desc = str_replace(" {{phone}}", '', $landing->meta_desc);
		$landing->form_modal_p = str_replace(" {{phone}}", '', $landing->form_modal_p);
	}

	// ws-base-domain
	if (!empty($landing->ws_base_domain)) {
		// forms
		$landing->form_privacity = str_replace("{{ws_base_domain}}", $landing->ws_base_domain, $landing->form_privacity);
	}
}
function getIdLandingByDomain($server_name,$database){
	$datas = $database->select('landings','*',["domain[~]"=>$server_name]);
	$id_landing = 0;
	foreach($datas as $data){
		if (array_key_exists('id_landing', $data)) {$id_landing = $data["id_landing"];}
	}
	return $id_landing;
}
