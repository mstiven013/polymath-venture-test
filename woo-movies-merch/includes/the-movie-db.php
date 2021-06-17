<?php

use GuzzleHttp\Client;

class TheMovieDB {

	// API basic information
	protected $api_key;
	protected $language;
	protected $client;

	public function __construct() {
		$this->client = new GuzzleHttp\Client( [ 'base_uri' => 'https://api.themoviedb.org/3/' ] );
		$this->api_key = get_option( 'woo_movie_merch_settings' )['api_key'];
		$this->language = str_replace( '_', '-', get_locale() );
	}

	public function get_all_genres() {

		$response = [];
		$response['genres'] = [];
		$req = $this->client->request('GET', "genre/movie/list?api_key=$this->api_key&language=$this->language");

		$response['status'] = $req->getStatusCode();

		if( $req->getStatusCode() !== 200 ) {
			$req_body = json_decode( $req->getBody()->getContents() );
			$response['message'] = $req_body->status_message;
		} else {
			$req_body = json_decode( $req->getBody()->getContents() );
			$response['body'] = $req_body;
		}

		return $response;

	}

	public function get_genre_movie( $genre ) {

		$maximo_de_peliculas = get_option( 'woo_movie_merch_settings' );
		$maximo_de_peliculas = $maximo_de_peliculas['max_movies_number'];
		
		$response = [];
		$response['movies'] = [];
		$req = $this->client->request('GET', "discover/movie?api_key=$this->api_key&language=$this->language&sort_by=release_date.desc&with_genres=$genre&page=1");

		$response['status'] = $req->getStatusCode();

		if( $req->getStatusCode() !== 200 ) {
			$req_body = json_decode( $req->getBody()->getContents() );
			$response['message'] = $req_body->status_message;
		} else {
			$req_body = json_decode( $req->getBody()->getContents() );
			for( $i = 0; $i < $maximo_de_peliculas; $i++ ) {

				if( isset($req_body->results[$i]) ){
					$response['movies'][] = $req_body->results[$i];
				}
				
			}
		}

		return $response;

	}

}