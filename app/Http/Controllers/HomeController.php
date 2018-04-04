<?php

namespace App\Http\Controllers;

use App\About;
use App\Article;
use App\Banner;
use App\CommunityUser;
use App\CorporateUser;
use App\Menu;
use App\PastProject;
use App\Project;
use App\ProjectCategory;
use App\Team;
use App\Testimonial;
use App\User;
//use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use \Validator;
use App\Http\Requests;
use \DrewM\MailChimp\MailChimp;

class HomeController extends Controller {
//	public function getMenuItems() {
//		$data = Menu::with( 'SubMenu' )->get()->toJson();
//		echo $data;
//
//	}

	public function getMenu() {
		$data = Menu::with( 'SubMenu' )->get()->toJson();
		echo $data;
	}

	public function getHomeBanner() {
		$homePageBanner = Banner::where( 'type', 'home' )->first()->toJson();
		echo $homePageBanner;
	}

	public function getHomeArticle( $section = null, $slug = null ) {
		$article = Article::where( 'section', $section )->where( 'slug', $slug )->first()->toJson();
		echo $article;
	}

	public function homeGettingStarted() {
		$gettingStarted = Article::where( 'section', 'home-getting-started' )->get()->toJson();
		echo $gettingStarted;
//		echo $gettingStarted;
//dd($gettingStarted);
	}

	public function getTestimonial() {
		$testimonials = Testimonial::all()->toJson();
		echo $testimonials;
	}

	public function getProjects() {
		$projects = ProjectCategory::with( 'projects' )->get()->toJson();
		echo $projects;
	}

	public function mail( Request $request ) {
		$MailChimp = new MailChimp( '51009372144a4654bf7405d554890c66-us12' );
		$result    = $MailChimp->get( 'lists' );
		$list_id   = '523e12ac5d';
		$result    = $MailChimp->post( "lists/$list_id/members", [
			'email_address' => $request['email'],
			'status'        => 'subscribed',
			'merge_fields'  => [
				"FNAME" => $request['name'],
			],

		] );
		if ( $result['status'] == 400 ) {
			echo "already registered";
		};
		if ( $result ) {
			echo "<h1>Thanks for subscribe !</h1>";
		} else {
			die( 'something going wrong !' );
		}

	}

	public function postCommunityUser( Request $request ) {
		$error   = [];
		$success = [];

		$validator = Validator::make( $request->all(), [
			'email' => 'required|unique:community_users,email|min:5',
			'name'  => 'required'
		] );

		if ( $validator->fails() ) {
			$error['status'] = 406;
			$messages        = $validator->messages();
			if ( ! empty( $messages->toArray()['email'][0] ) ) {
				$error['message'] = $messages->toArray()['email'][0];
			} elseif ( ! empty( $messages->toArray()['name'][0] ) ) {
				$error['message'] = $messages->toArray()['name'][0];
			} else {
				$error['message'] = "Something gong wrong with your input";
			}

		} else {
			$success['status'] = 200;
			$data              = $request->all();
			$data['password']  = '123456';
			$data['status']    = 1;
			$status            = CommunityUser::create( $data );


			$MailChimp = new MailChimp( '51009372144a4654bf7405d554890c66-us12' );
//			$result    = $MailChimp->get( 'lists' );
			$list_id = '523e12ac5d';
			$status2 = $MailChimp->post( "lists/$list_id/members", [
				'email_address' => $data['email'],
				'status'        => 'subscribed',
				'merge_fields'  => [
					"FNAME" => $data['name'],
				],

			] );

			$success['message'] = 'Successfully Subscribed !';

		}

		if ( ! empty( $error ) ) {
			echo json_encode( $error );
		} else {
			echo json_encode( $success );
		}
	}

	public function postCorporateUser( Request $request ) {
		$error   = [];
		$success = [];

		$validator = Validator::make( $request->all(), [
			'email' => 'required|unique:corporate_users,email|min:5',
			'name'  => 'required'
		] );

		if ( $validator->fails() ) {
			$error['status'] = 406;
			$messages        = $validator->messages();
			if ( ! empty( $messages->toArray()['email'][0] ) ) {
				$error['message'] = $messages->toArray()['email'][0];
			} elseif ( ! empty( $messages->toArray()['name'][0] ) ) {
				$error['message'] = $messages->toArray()['name'][0];
			} else {
				$error['message'] = "Something gong wrong with your input";
			}

		} else {
			$success['status'] = 200;
			$data              = $request->all();
			$data['password']  = '123456';
			$status            = CorporateUser::create( $data );

			$MailChimp = new MailChimp( '51009372144a4654bf7405d554890c66-us12' );
//			$result    = $MailChimp->get( 'lists' );
			$list_id = 'bfdf67f681';
			$status2 = $MailChimp->post( "lists/$list_id/members", [
				'email_address' => $data['email'],
				'status'        => 'subscribed',
				'merge_fields'  => [
					"FNAME" => $data['name'],
				],

			] );

			$success['message'] = 'Successfully Subscribed !';

		}

		if ( ! empty( $error ) ) {
			echo json_encode( $error );
		} else {
			echo json_encode( $success );
		}
	}

	public function getAboutContent() {
		$abouts = About::all()->toJson();
		echo $abouts;
	}

	public function getTeamMembers() {
		$teams = Team::all()->toJson();
		echo $teams;
	}

	public function getPastProject() {
		$MultipleImage = PastProject::where( 'type', 'multiple-image' )->with( 'pastProjectMedia' )->get()->toArray();
		$singleImage   = PastProject::where( 'type', 'single-image' )->get()->toArray();
		$pastProjects                 = [
			'MultipleImageProject' => $MultipleImage,
			'SingleImageProject' => $singleImage,
		];
		echo json_encode($pastProjects);
	}

}
