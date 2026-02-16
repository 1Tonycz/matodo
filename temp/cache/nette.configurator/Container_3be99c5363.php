<?php
// source: C:\xampp\htdocs\Matodo/config/common.neon
// source: C:\xampp\htdocs\Matodo/config/services.neon
// source: array

/** @noinspection PhpParamsInspection,PhpMethodMayBeStaticInspection */

declare(strict_types=1);

class Container_3be99c5363 extends Nette\DI\Container
{
	protected array $aliases = [
		'application' => 'application.application',
		'cacheStorage' => 'cache.storage',
		'database.default' => 'database.default.connection',
		'database.default.context' => 'database.default.explorer',
		'httpRequest' => 'http.request',
		'httpResponse' => 'http.response',
		'nette.cacheJournal' => 'cache.journal',
		'nette.database.default' => 'database.default',
		'nette.database.default.context' => 'database.default.explorer',
		'nette.httpRequestFactory' => 'http.requestFactory',
		'nette.latteFactory' => 'latte.latteFactory',
		'nette.mailer' => 'mail.mailer',
		'nette.presenterFactory' => 'application.presenterFactory',
		'nette.templateFactory' => 'latte.templateFactory',
		'nette.userStorage' => 'security.userStorage',
		'session' => 'session.session',
		'user' => 'security.user',
	];

	protected array $wiring = [
		'Nette\DI\Container' => [['container']],
		'Nette\Application\Application' => [['application.application']],
		'Nette\Application\IPresenterFactory' => [['application.presenterFactory']],
		'Nette\Application\LinkGenerator' => [['application.linkGenerator']],
		'Nette\Assets\Registry' => [['assets.registry']],
		'Nette\Caching\Storages\Journal' => [['cache.journal']],
		'Nette\Caching\Storage' => [['cache.storage']],
		'Nette\Database\Connection' => [['database.default.connection']],
		'Nette\Database\IStructure' => [['database.default.structure']],
		'Nette\Database\Structure' => [['database.default.structure']],
		'Nette\Database\Conventions' => [['database.default.conventions']],
		'Nette\Database\Conventions\DiscoveredConventions' => [['database.default.conventions']],
		'Nette\Database\Explorer' => [['database.default.explorer']],
		'Nette\Http\RequestFactory' => [['http.requestFactory']],
		'Nette\Http\IRequest' => [['http.request']],
		'Nette\Http\Request' => [['http.request']],
		'Nette\Http\IResponse' => [['http.response']],
		'Nette\Http\Response' => [['http.response']],
		'Nette\Bridges\ApplicationLatte\LatteFactory' => [['latte.latteFactory']],
		'Nette\Application\UI\TemplateFactory' => [['latte.templateFactory']],
		'Nette\Bridges\ApplicationLatte\TemplateFactory' => [['latte.templateFactory']],
		'Nette\Mail\Mailer' => [['mail.mailer']],
		'Nette\Security\Passwords' => [['security.passwords']],
		'Nette\Security\UserStorage' => [['security.userStorage']],
		'Nette\Security\User' => [['security.user']],
		'Nette\Http\Session' => [['session.session']],
		'Tracy\ILogger' => [['tracy.logger']],
		'Tracy\BlueScreen' => [['tracy.blueScreen']],
		'Tracy\Bar' => [['tracy.bar']],
		'Nette\Routing\RouteList' => [['01']],
		'Nette\Routing\Router' => [['01']],
		'ArrayAccess' => [
			2 => [
				'01',
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
				'022',
				'025',
				'026',
				'027',
				'028',
				'030',
				'031',
			],
		],
		'Nette\Application\Routers\RouteList' => [['01']],
		'App\Infrastructure\Model\LogErrorModel' => [['02']],
		'Nette\Security\Authenticator' => [['03']],
		'Nette\Security\IAuthenticator' => [['03']],
		'App\Infrastructure\Security\ProfilesAuthenticator' => [['03']],
		'App\Domain\Trips\TripImageStorage' => [['04']],
		'App\Domain\Reservations\ReservationFacade' => [['05']],
		'App\Domain\Transfer\TransferFacade' => [['06']],
		'App\Presentation\Admin\UI\BasePresenter' => [
			2 => ['application.1', 'application.2', 'application.3', 'application.4', 'application.5', 'application.6'],
		],
		'Nette\Application\UI\Presenter' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\Application\UI\Control' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\Application\UI\Component' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\ComponentModel\Container' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
				'022',
				'025',
				'026',
				'027',
				'028',
				'030',
				'031',
			],
		],
		'Nette\ComponentModel\Component' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
				'022',
				'025',
				'026',
				'027',
				'028',
				'030',
				'031',
			],
		],
		'Nette\ComponentModel\IComponent' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
				'022',
				'025',
				'026',
				'027',
				'028',
				'030',
				'031',
			],
		],
		'Nette\ComponentModel\IContainer' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
				'022',
				'025',
				'026',
				'027',
				'028',
				'030',
				'031',
			],
		],
		'Nette\Application\UI\SignalReceiver' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
				'022',
				'025',
				'026',
				'027',
				'028',
				'030',
				'031',
			],
		],
		'Nette\Application\UI\StatePersistent' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\Application\UI\Renderable' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\Application\IPresenter' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
				'application.12',
				'application.13',
			],
		],
		'App\Presentation\Admin\UI\Calendar\CalendarPresenter' => [2 => ['application.1']],
		'App\Presentation\Admin\UI\Home\HomePresenter' => [2 => ['application.2']],
		'App\Presentation\Admin\UI\Inquiry\InquiryPresenter' => [2 => ['application.3']],
		'App\Presentation\Admin\UI\Reservations\ReservationsPresenter' => [2 => ['application.4']],
		'App\Presentation\Admin\UI\Transfer\TransferPresenter' => [2 => ['application.5']],
		'App\Presentation\Admin\UI\Trips\TripsPresenter' => [2 => ['application.6']],
		'App\Presentation\Error\ErrorPresenter' => [2 => ['application.7']],
		'App\Presentation\Front\UI\Auth\AuthPresenter' => [2 => ['application.8']],
		'App\Presentation\Front\UI\BasePresenter' => [2 => ['application.9', 'application.10', 'application.11']],
		'App\Presentation\Front\UI\Excursion\ExcursionPresenter' => [2 => ['application.10']],
		'App\Presentation\Front\UI\Home\HomePresenter' => [2 => ['application.11']],
		'NetteModule\ErrorPresenter' => [2 => ['application.12']],
		'NetteModule\MicroPresenter' => [2 => ['application.13']],
		'App\Domain\Calendar\CalendarFacade' => [['07']],
		'App\Infrastructure\Database\BaseRepository' => [
			['08', '010', '012', '013', '014', '016', '017', '018', '019', '020'],
		],
		'App\Domain\Error\ErrorRepository' => [['08']],
		'App\Domain\Home\HomeFacade' => [['09']],
		'App\Domain\Inquiry\InquiriesRepository' => [['010']],
		'App\Domain\Inquiry\InquiryFacade' => [['011']],
		'App\Domain\Reservations\ReservationRepository' => [['012']],
		'App\Domain\Reservations\ReservationStartsRepository' => [['013']],
		'App\Domain\Transfer\TransferRepository' => [['014']],
		'App\Domain\Trips\TripFacade' => [['015']],
		'App\Domain\Trips\TripRatingsRepository' => [['016']],
		'App\Domain\Trips\TripSchedulesRepository' => [['017']],
		'App\Domain\Trips\TripsRepository' => [['018']],
		'App\Domain\Trips\TripViewsRepository' => [['019']],
		'App\Domain\User\ProfilesRepository' => [['020']],
		'App\Infrastructure\Mail\MailService' => [['021']],
		'Nette\Application\UI\Form' => [['022', '025', '026', '027', '028', '030', '031']],
		'Nette\Forms\Form' => [['022', '025', '026', '027', '028', '030', '031']],
		'Nette\Forms\Container' => [['022', '025', '026', '027', '028', '030', '031']],
		'Stringable' => [['022', '025', '026', '027', '028', '030', '031']],
		'Nette\HtmlStringable' => [['022', '025', '026', '027', '028', '030', '031']],
		'App\Presentation\Admin\Forms\InquiryReplyFormFactory' => [['022']],
		'App\Presentation\Admin\Forms\ReservationConfirmFormFactory' => [['023']],
		'App\Presentation\Admin\Forms\ReservationEmailFormFactory' => [['024']],
		'App\Presentation\Admin\Forms\ScheduleFormFactory' => [['025']],
		'App\Presentation\Admin\Forms\TransferConfirmFormFactory' => [['026']],
		'App\Presentation\Admin\Forms\TransferEmailFormFactory' => [['027']],
		'App\Presentation\Admin\Forms\TripFormFactory' => [['028']],
		'App\Presentation\Front\Forms\ContactFormFactory' => [['029']],
		'App\Presentation\Front\Forms\ReservationFormFactory' => [['030']],
		'App\Presentation\Front\Forms\TransferFormFactory' => [['031']],
	];


	public function __construct(array $params = [])
	{
		parent::__construct($params);
	}


	public function createService01(): Nette\Application\Routers\RouteList
	{
		return App\Infrastructure\Router\RouterFactory::createRouter();
	}


	public function createService02(): App\Infrastructure\Model\LogErrorModel
	{
		return new App\Infrastructure\Model\LogErrorModel($this->getService('08'));
	}


	public function createService03(): App\Infrastructure\Security\ProfilesAuthenticator
	{
		return new App\Infrastructure\Security\ProfilesAuthenticator($this->getService('020'));
	}


	public function createService04(): App\Domain\Trips\TripImageStorage
	{
		return new App\Domain\Trips\TripImageStorage('C:\xampp\htdocs\Matodo\www');
	}


	public function createService05(): App\Domain\Reservations\ReservationFacade
	{
		return new App\Domain\Reservations\ReservationFacade($this->getService('012'), $this->getService('021'));
	}


	public function createService06(): App\Domain\Transfer\TransferFacade
	{
		return new App\Domain\Transfer\TransferFacade($this->getService('014'), $this->getService('021'));
	}


	public function createService07(): App\Domain\Calendar\CalendarFacade
	{
		return new App\Domain\Calendar\CalendarFacade($this->getService('012'), $this->getService('014'));
	}


	public function createService08(): App\Domain\Error\ErrorRepository
	{
		return new App\Domain\Error\ErrorRepository($this->getService('database.default.explorer'));
	}


	public function createService09(): App\Domain\Home\HomeFacade
	{
		return new App\Domain\Home\HomeFacade(
			$this->getService('010'),
			$this->getService('018'),
			$this->getService('012'),
			$this->getService('019'),
			$this->getService('013'),
			$this->getService('cache.storage'),
		);
	}


	public function createService010(): App\Domain\Inquiry\InquiriesRepository
	{
		return new App\Domain\Inquiry\InquiriesRepository($this->getService('database.default.explorer'));
	}


	public function createService011(): App\Domain\Inquiry\InquiryFacade
	{
		return new App\Domain\Inquiry\InquiryFacade($this->getService('010'), $this->getService('021'));
	}


	public function createService012(): App\Domain\Reservations\ReservationRepository
	{
		return new App\Domain\Reservations\ReservationRepository($this->getService('database.default.explorer'));
	}


	public function createService013(): App\Domain\Reservations\ReservationStartsRepository
	{
		return new App\Domain\Reservations\ReservationStartsRepository($this->getService('database.default.explorer'));
	}


	public function createService014(): App\Domain\Transfer\TransferRepository
	{
		return new App\Domain\Transfer\TransferRepository($this->getService('database.default.explorer'));
	}


	public function createService015(): App\Domain\Trips\TripFacade
	{
		return new App\Domain\Trips\TripFacade(
			$this->getService('018'),
			$this->getService('017'),
			$this->getService('016'),
			$this->getService('019'),
			$this->getService('013'),
			$this->getService('021'),
			$this->getService('012'),
		);
	}


	public function createService016(): App\Domain\Trips\TripRatingsRepository
	{
		return new App\Domain\Trips\TripRatingsRepository($this->getService('database.default.explorer'));
	}


	public function createService017(): App\Domain\Trips\TripSchedulesRepository
	{
		return new App\Domain\Trips\TripSchedulesRepository($this->getService('database.default.explorer'));
	}


	public function createService018(): App\Domain\Trips\TripsRepository
	{
		return new App\Domain\Trips\TripsRepository($this->getService('database.default.explorer'));
	}


	public function createService019(): App\Domain\Trips\TripViewsRepository
	{
		return new App\Domain\Trips\TripViewsRepository($this->getService('database.default.explorer'));
	}


	public function createService020(): App\Domain\User\ProfilesRepository
	{
		return new App\Domain\User\ProfilesRepository($this->getService('database.default.explorer'));
	}


	public function createService021(): App\Infrastructure\Mail\MailService
	{
		return new App\Infrastructure\Mail\MailService($this->getService('mail.mailer'), $this->getService('latte.latteFactory'));
	}


	public function createService022(): App\Presentation\Admin\Forms\InquiryReplyFormFactory
	{
		return new App\Presentation\Admin\Forms\InquiryReplyFormFactory;
	}


	public function createService023(): App\Presentation\Admin\Forms\ReservationConfirmFormFactory
	{
		return new App\Presentation\Admin\Forms\ReservationConfirmFormFactory;
	}


	public function createService024(): App\Presentation\Admin\Forms\ReservationEmailFormFactory
	{
		return new App\Presentation\Admin\Forms\ReservationEmailFormFactory;
	}


	public function createService025(): App\Presentation\Admin\Forms\ScheduleFormFactory
	{
		return new App\Presentation\Admin\Forms\ScheduleFormFactory;
	}


	public function createService026(): App\Presentation\Admin\Forms\TransferConfirmFormFactory
	{
		return new App\Presentation\Admin\Forms\TransferConfirmFormFactory;
	}


	public function createService027(): App\Presentation\Admin\Forms\TransferEmailFormFactory
	{
		return new App\Presentation\Admin\Forms\TransferEmailFormFactory;
	}


	public function createService028(): App\Presentation\Admin\Forms\TripFormFactory
	{
		return new App\Presentation\Admin\Forms\TripFormFactory;
	}


	public function createService029(): App\Presentation\Front\Forms\ContactFormFactory
	{
		return new App\Presentation\Front\Forms\ContactFormFactory;
	}


	public function createService030(): App\Presentation\Front\Forms\ReservationFormFactory
	{
		return new App\Presentation\Front\Forms\ReservationFormFactory;
	}


	public function createService031(): App\Presentation\Front\Forms\TransferFormFactory
	{
		return new App\Presentation\Front\Forms\TransferFormFactory;
	}


	public function createServiceApplication__1(): App\Presentation\Admin\UI\Calendar\CalendarPresenter
	{
		$service = new App\Presentation\Admin\UI\Calendar\CalendarPresenter($this->getService('07'));
		$service->injectPrimary(
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('application.presenterFactory'),
			$this->getService('01'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory'),
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__10(): App\Presentation\Front\UI\Excursion\ExcursionPresenter
	{
		$service = new App\Presentation\Front\UI\Excursion\ExcursionPresenter(
			$this->getService('015'),
			$this->getService('05'),
			$this->getService('030'),
		);
		$service->injectPrimary(
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('application.presenterFactory'),
			$this->getService('01'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory'),
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__11(): App\Presentation\Front\UI\Home\HomePresenter
	{
		$service = new App\Presentation\Front\UI\Home\HomePresenter(
			$this->getService('02'),
			$this->getService('029'),
			$this->getService('031'),
			$this->getService('011'),
			$this->getService('06'),
			$this->getService('015'),
		);
		$service->injectPrimary(
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('application.presenterFactory'),
			$this->getService('01'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory'),
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__12(): NetteModule\ErrorPresenter
	{
		return new NetteModule\ErrorPresenter($this->getService('tracy.logger'));
	}


	public function createServiceApplication__13(): NetteModule\MicroPresenter
	{
		return new NetteModule\MicroPresenter($this, $this->getService('http.request'), $this->getService('01'));
	}


	public function createServiceApplication__2(): App\Presentation\Admin\UI\Home\HomePresenter
	{
		$service = new App\Presentation\Admin\UI\Home\HomePresenter($this->getService('09'));
		$service->injectPrimary(
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('application.presenterFactory'),
			$this->getService('01'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory'),
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__3(): App\Presentation\Admin\UI\Inquiry\InquiryPresenter
	{
		$service = new App\Presentation\Admin\UI\Inquiry\InquiryPresenter($this->getService('011'), $this->getService('022'));
		$service->injectPrimary(
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('application.presenterFactory'),
			$this->getService('01'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory'),
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__4(): App\Presentation\Admin\UI\Reservations\ReservationsPresenter
	{
		$service = new App\Presentation\Admin\UI\Reservations\ReservationsPresenter(
			$this->getService('05'),
			$this->getService('023'),
			$this->getService('024'),
		);
		$service->injectPrimary(
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('application.presenterFactory'),
			$this->getService('01'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory'),
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__5(): App\Presentation\Admin\UI\Transfer\TransferPresenter
	{
		$service = new App\Presentation\Admin\UI\Transfer\TransferPresenter(
			$this->getService('06'),
			$this->getService('027'),
			$this->getService('026'),
		);
		$service->injectPrimary(
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('application.presenterFactory'),
			$this->getService('01'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory'),
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__6(): App\Presentation\Admin\UI\Trips\TripsPresenter
	{
		$service = new App\Presentation\Admin\UI\Trips\TripsPresenter(
			$this->getService('015'),
			$this->getService('04'),
			$this->getService('028'),
			$this->getService('025'),
		);
		$service->injectPrimary(
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('application.presenterFactory'),
			$this->getService('01'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory'),
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__7(): App\Presentation\Error\ErrorPresenter
	{
		return new App\Presentation\Error\ErrorPresenter($this->getService('tracy.logger'), $this->getService('http.request'));
	}


	public function createServiceApplication__8(): App\Presentation\Front\UI\Auth\AuthPresenter
	{
		$service = new App\Presentation\Front\UI\Auth\AuthPresenter;
		$service->injectPrimary(
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('application.presenterFactory'),
			$this->getService('01'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory'),
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__9(): App\Presentation\Front\UI\BasePresenter
	{
		$service = new App\Presentation\Front\UI\BasePresenter($this->getService('02'));
		$service->injectPrimary(
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('application.presenterFactory'),
			$this->getService('01'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory'),
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__application(): Nette\Application\Application
	{
		$service = new Nette\Application\Application(
			$this->getService('application.presenterFactory'),
			$this->getService('01'),
			$this->getService('http.request'),
			$this->getService('http.response'),
		);
		Nette\Bridges\ApplicationDI\ApplicationExtension::initializeBlueScreenPanel(
			$this->getService('tracy.blueScreen'),
			$service,
		);
		$this->getService('tracy.bar')->addPanel(new Nette\Bridges\ApplicationTracy\RoutingPanel(
			$this->getService('01'),
			$this->getService('http.request'),
			$this->getService('application.presenterFactory'),
		));
		return $service;
	}


	public function createServiceApplication__linkGenerator(): Nette\Application\LinkGenerator
	{
		return new Nette\Application\LinkGenerator(
			$this->getService('01'),
			$this->getService('http.request')->getUrl()->withoutUserInfo(),
			$this->getService('application.presenterFactory'),
		);
	}


	public function createServiceApplication__presenterFactory(): Nette\Application\IPresenterFactory
	{
		$service = new Nette\Application\PresenterFactory(new Nette\Bridges\ApplicationDI\PresenterFactoryCallback(
			$this,
			5,
			'C:\xampp\htdocs\Matodo/temp/cache/nette.application/touch',
		));
		$service->setMapping([
			'Admin' => 'App\Presentation\Admin\UI\*\**Presenter',
			'Front' => 'App\Presentation\Front\UI\*\**Presenter',
			'Error' => 'App\Presentation\Error\*Presenter',
		]);
		return $service;
	}


	public function createServiceAssets__registry(): Nette\Assets\Registry
	{
		$service = new Nette\Assets\Registry;
		$baseUrl = new Nette\Http\UrlImmutable(rtrim(rtrim($this->getService('http.request')->getUrl()->getBaseUrl(), '/'), '/') . '/');
		$service->addMapper(
			'default',
			new Nette\Assets\FilesystemMapper(
			rtrim($baseUrl->resolve('assets')->getAbsoluteUrl(), '/'),
			rtrim(Nette\Utils\FileSystem::resolvePath('C:\xampp\htdocs\Matodo\www', 'assets'), '\/'),
			[],
			true,
		),
		);
		return $service;
	}


	public function createServiceCache__journal(): Nette\Caching\Storages\Journal
	{
		return new Nette\Caching\Storages\SQLiteJournal('C:\xampp\htdocs\Matodo/temp/cache/journal.s3db');
	}


	public function createServiceCache__storage(): Nette\Caching\Storage
	{
		return new Nette\Caching\Storages\FileStorage('C:\xampp\htdocs\Matodo/temp/cache', $this->getService('cache.journal'));
	}


	public function createServiceContainer(): Nette\DI\Container
	{
		return $this;
	}


	public function createServiceDatabase__default__connection(): Nette\Database\Connection
	{
		$service = new Nette\Database\Connection(
			'mysql:host=localhost:3306;dbname=matodo',
			/*sensitive{*/'root'/*}*/,
			/*sensitive{*/''/*}*/,
			[],
		);
		Nette\Bridges\DatabaseTracy\ConnectionPanel::initialize(
			$service,
			true,
			'default',
			true,
			$this->getService('tracy.bar'),
			$this->getService('tracy.blueScreen'),
		);
		return $service;
	}


	public function createServiceDatabase__default__conventions(): Nette\Database\Conventions\DiscoveredConventions
	{
		return new Nette\Database\Conventions\DiscoveredConventions($this->getService('database.default.structure'));
	}


	public function createServiceDatabase__default__explorer(): Nette\Database\Explorer
	{
		return new Nette\Database\Explorer(
			$this->getService('database.default.connection'),
			$this->getService('database.default.structure'),
			$this->getService('database.default.conventions'),
			$this->getService('cache.storage'),
		);
	}


	public function createServiceDatabase__default__structure(): Nette\Database\Structure
	{
		return new Nette\Database\Structure($this->getService('database.default.connection'), $this->getService('cache.storage'));
	}


	public function createServiceHttp__request(): Nette\Http\Request
	{
		return $this->getService('http.requestFactory')->fromGlobals();
	}


	public function createServiceHttp__requestFactory(): Nette\Http\RequestFactory
	{
		$service = new Nette\Http\RequestFactory;
		$service->setProxy([]);
		return $service;
	}


	public function createServiceHttp__response(): Nette\Http\Response
	{
		$service = new Nette\Http\Response;
		$service->cookieSecure = $this->getService('http.request')->isSecured();
		return $service;
	}


	public function createServiceLatte__latteFactory(): Nette\Bridges\ApplicationLatte\LatteFactory
	{
		return new class ($this) implements Nette\Bridges\ApplicationLatte\LatteFactory {
			public function __construct(
				private Container_3be99c5363 $container,
			) {
			}


			public function create(): Latte\Engine
			{
				$service = new Latte\Engine;
				$service->setTempDirectory('C:\xampp\htdocs\Matodo/temp/cache/latte');
				$service->setAutoRefresh(true);
				$service->setStrictTypes(true);
				$service->setStrictParsing(true);
				$service->enablePhpLinter(null);
				$service->setLocale(null);
				func_num_args() && $service->addExtension(new Nette\Bridges\ApplicationLatte\UIExtension(func_get_arg(0)));
				$service->addExtension(new Nette\Bridges\CacheLatte\CacheExtension($this->container->getService('cache.storage')));
				$service->addExtension(new Nette\Bridges\FormsLatte\FormsExtension);
				$service->addExtension(new Nette\Bridges\AssetsLatte\LatteExtension($this->container->getService('assets.registry')));
				return $service;
			}
		};
	}


	public function createServiceLatte__templateFactory(): Nette\Bridges\ApplicationLatte\TemplateFactory
	{
		$service = new Nette\Bridges\ApplicationLatte\TemplateFactory(
			$this->getService('latte.latteFactory'),
			$this->getService('http.request'),
			$this->getService('security.user'),
			$this->getService('cache.storage'),
			null,
		);
		Nette\Bridges\ApplicationDI\LatteExtension::initLattePanel($service, $this->getService('tracy.bar'), false);
		return $service;
	}


	public function createServiceMail__mailer(): Nette\Mail\Mailer
	{
		return new Nette\Mail\SmtpMailer('127.0.0.1', '', /*sensitive{*/''/*}*/, 25, null, false, 20, null, null);
	}


	public function createServiceSecurity__passwords(): Nette\Security\Passwords
	{
		return new Nette\Security\Passwords;
	}


	public function createServiceSecurity__user(): Nette\Security\User
	{
		$service = new Nette\Security\User($this->getService('security.userStorage'), $this->getService('03'));
		$this->getService('tracy.bar')->addPanel(new Nette\Bridges\SecurityTracy\UserPanel($service));
		return $service;
	}


	public function createServiceSecurity__userStorage(): Nette\Security\UserStorage
	{
		return new Nette\Bridges\SecurityHttp\SessionStorage($this->getService('session.session'));
	}


	public function createServiceSession__session(): Nette\Http\Session
	{
		$service = new Nette\Http\Session($this->getService('http.request'), $this->getService('http.response'));
		$service->setOptions(['cookieSamesite' => 'Lax']);
		return $service;
	}


	public function createServiceTracy__bar(): Tracy\Bar
	{
		return Tracy\Debugger::getBar();
	}


	public function createServiceTracy__blueScreen(): Tracy\BlueScreen
	{
		return Tracy\Debugger::getBlueScreen();
	}


	public function createServiceTracy__logger(): Tracy\ILogger
	{
		return Tracy\Debugger::getLogger();
	}


	public function initialize(): void
	{
		// di.
		(function () {
			$this->getService('tracy.bar')->addPanel(new Nette\Bridges\DITracy\ContainerPanel($this));
		})();
		// http.
		(function () {
			$response = $this->getService('http.response');
			$response->setHeader('X-Powered-By', 'Nette Framework 3');
			$response->setHeader('Content-Type', 'text/html; charset=utf-8');
			$response->setHeader('X-Frame-Options', 'SAMEORIGIN');
			Nette\Http\Helpers::initCookie($this->getService('http.request'), $response);
		})();
		// session.
		(function () {
			$this->getService('session.session')->autoStart(false);
		})();
		// tracy.
		(function () {
			if (!Tracy\Debugger::isEnabled()) { return; }
			$logger = $this->getService('tracy.logger');
			if ($logger instanceof Tracy\Logger) $logger->mailer = [
				new Tracy\Bridges\Nette\MailSender(
					$this->getService('mail.mailer'),
					null,
					$this->getByType('Nette\Http\Request', false)?->getUrl()->getHost(),
				),
				'send',
			];
		})();
	}


	protected function getDynamicParameter(string|int $key): mixed
	{
		return match($key) {
			'baseUrl' => rtrim($this->getService('http.request')->getUrl()->getBaseUrl(), '/'),
			default => parent::getDynamicParameter($key),
		};
	}
}
