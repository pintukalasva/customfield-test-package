<?php
	namespace Customfield;

	use Illuminate\Support\ServiceProvider;
	class CustomfieldServiceProvider extends ServiceProvider 
	{
		public function boot()
		{
			$this->loadRoutesFrom(__DIR__.'/routes/web.php');
			$this->loadViewsFrom(__DIR__.'/views','customfield');
			$this->loadMigrationsFrom(__DIR__.'/database/migrations');
		}
		public function register()
		{

		}
	}
?>